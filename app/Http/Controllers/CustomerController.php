<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginView()
    {
        //return the view for customer login
        return Inertia::render('customer/login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('phone_number', 'password');

        try {
            if (Auth::guard('customer')->attempt($credentials)) {
                return redirect()->intended('/customer/dashboard');
            }

            return redirect()->back()->withInput()->withErrors([
                'phone_number' => 'رقم الهاتف أو كلمة المرور غير صحيحة',
            ]);
        } catch (\Throwable $e) {
            // إظهار الخطأ في الشاشة أثناء التطوير
            return back()->withErrors([
                'auth_error' => 'حدث خطأ أثناء محاولة تسجيل الدخول: ' . $e->getMessage(),
            ]);

            // أو يمكنك تسجيله في ملف اللوق بدون إظهاره للمستخدم:
            // Log::error('Login error: ' . $e->getMessage());
            // return back()->withErrors(['phone_number' => 'خطأ غير متوقع أثناء تسجيل الدخول.']);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        try {

            // إنشاء العميل
            $customer = Customer::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'password' => bcrypt($request->password),
            ]);

            // إنشاء كود فريد للعميل: مثل 0001، 0002، ...
            $customerCode = str_pad($customer->id, 4, '0', STR_PAD_LEFT);

            // تحديث السطر
            $customer->customer_code = $customerCode;
            $customer->save();

            // تسجيل الدخول تلقائيًا
            Auth::guard('customer')->login($customer);

            // توجيه العميل إلى لوحة التحكم
            // redirect with inertia
            return redirect()->route('customer.dashboard');

        } catch (\Exception $e) {
            // في حالة حدوث خطأ عام
            return redirect()->back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء التسجيل: ' . $e->getMessage()]);
        }
    }

    // dashboardView
    public function dashboardView()
    {
        $customer = Auth::guard('customer')->user();

        $visits = $customer->visits()
            ->with([
                'restaurant.rewardSettings:id,restaurant_id,visits_required,gift_title,gift_description',
                'restaurant:id,name'
            ])
            ->orderBy('visit_date', 'desc')
            ->get();

        $grouped = $visits->groupBy('restaurant_id');

        $giftGroups = [];
        $totalVisits = $visits->count();
        $totalGifts = 0;

        foreach ($grouped as $restaurantId => $restaurantVisits) {
            $restaurant = $restaurantVisits->first()->restaurant;
            $rewardSettings = optional($restaurant->rewardSettings);
            $visitsRequired = $rewardSettings->visits_required ?? 1;

            $chunks = $restaurantVisits->chunk($visitsRequired);
            $visitChunksCounts = $chunks->map(fn($group) => $group->count())->toArray();

            // احتساب الهدايا المحصلة (مجموعات مكتملة)
            $restaurantGiftCount = collect($visitChunksCounts)->filter(fn($count) => $count == $visitsRequired)->count();
            $totalGifts += $restaurantGiftCount;

            $giftGroups[] = [
                'restaurant' => [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'last_visit_date' => $restaurantVisits->first()->visit_date,
                    'visits_required' => $visitsRequired,
                    'gift_title' => $rewardSettings->gift_title,
                    'gift_description' => $rewardSettings->gift_description,
                ],
                'Groups' => $visitChunksCounts,
            ];
        }

        // عدد الهدايا المتاحة حالياً (مجموعات مكتملة فقط)
        $eligibleGifts = $totalGifts;

        return Inertia::render('customer/dashboard/dashboard', [
            'customer' => array_merge($customer->toArray(), [
                'totalVisits' => $totalVisits,
                'totalGifts' => $totalGifts,
            ]),
            'eligibleGifts' => $eligibleGifts,
            'visits' => $visits,
            'giftGroups' => $giftGroups,
        ]);
    }




}
