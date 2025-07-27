<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\owner;
use App\Models\Visit;
use App\Models\Customer;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ownerController extends Controller
{
    // return inertia login view for owner
    public function index()
    {
        return Inertia::render('owner/login');
    }
    // singup function can be added here if needed
    public function signup(Request $request)
    {
        DB::beginTransaction();

        try {
            $restaurant = Restaurant::create([
                'name' => $request->restaurant_name,
                'location' => $request->restaurant_location,
            ]);

            $owner = Owner::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'restaurant_id' => $restaurant->id,
            ]);
            // create default reward settings for the restaurant
            DB::table('reward_settings')->insert([
                'restaurant_id' => $restaurant->id,
                'visits_required' => 10, // مثلا قيمة افتراضية
                'gift_title' => 'هدية مجانية',
                'gift_description' => 'احصل على هدية بعد 10 زيارات',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();

            Auth::guard('owner')->login($owner);


            return redirect()->route('owner.dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء التسجيل.']);
        }
    }

    // login function can be added here if needed
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('owner')->attempt($credentials)) {
            $request->session()->regenerate();

            return Inertia::location('/owner/dashboard');
        }

        return back()->withErrors([
            'email' => 'المعلومات غير صحيحة.',
        ])->onlyInput('email');
    }


    // return dashboard view for owner
    public function dashboardView()
    {
        $owner = Auth::guard('owner')->user();

        if (!$owner) {
            return redirect()->route('owner.login');
        }

        // Load relationships
        $owner->load(['restaurant', 'restaurant.rewardSettings', 'restaurant.customers']);

        // set restaurant
        $restaurant = $owner->restaurant;
        $customersCount = $restaurant->customers()->count();
        // Today's date
        $today = Carbon::today();
        // Count today's visits
        $todayVisitsCount = $restaurant
            ? $restaurant->visits()->whereDate('created_at', $today)->count()
            : 0;

        // Count eligible customers
        $eligibleCustomers = $this->eligibleCustomers($restaurant->id);



        // customers count this restaurant


        return Inertia::render('owner/dashboard/dashboard', [
            'owner' => $owner,
            'todayVisitsCount' => $todayVisitsCount,
            'customersCount' => $customersCount,
            'eligibleCustomersCount' => $eligibleCustomers->count(),
        ]);
    }

    // return  clients dashboard  view for owner
    public function clientsDashboardView()
    {
        $owner = Auth::guard('owner')->user();
        $restaurant = $owner->restaurant;

        // جلب جميع الزيارات لهذا المطعم مع الزبون
        $visits = \App\Models\Visit::with('customer')
            ->where('restaurant_id', $restaurant->id)
            ->orderBy('visit_date', 'desc')
            ->get();

        $rewardSettings = $restaurant->rewardSettings;
        $visitsRequired = optional($rewardSettings)->visits_required ?? 1;

        $groupedByCustomer = $visits->groupBy('customer_id');

        $giftGroups = [];
        $totalVisits = $visits->count();
        $totalGifts = 0;

        foreach ($groupedByCustomer as $customerId => $customerVisits) {
            $customer = $customerVisits->first()->customer;

            $chunks = $customerVisits->chunk($visitsRequired);
            $visitChunksCounts = $chunks->map(fn($group) => $group->count())->toArray();

            $giftCount = collect($visitChunksCounts)->filter(fn($count) => $count == $visitsRequired)->count();
            $totalGifts += $giftCount;

            $giftGroups[] = [
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'last_visit_date' => $customerVisits->first()->visit_date,
                    'phone' => $customer->phone_number,
                ],
                'Groups' => $visitChunksCounts,
            ];
        }

        return Inertia::render('owner/dashboard/clients', [
            'restaurant' => array_merge($restaurant->toArray(), [
                'visits_required' => $visitsRequired,
                'gift_title' => optional($rewardSettings)->gift_title,
                'gift_description' => optional($rewardSettings)->gift_description,
            ]),
            'giftGroups' => $giftGroups,
            'totalVisits' => $totalVisits,
            'totalGifts' => $totalGifts,
        ]);
    }
    public function loyaltySettingsView()
    {
        $owner = Auth::guard('owner')->user();

        if (!$owner) {
            return redirect()->route('owner.login');
        }
        $owner->load(['restaurant.rewardSettings']);
        return Inertia::render('owner/dashboard/loyaltySettings', [
            'rewardSettings' => $owner->restaurant->rewardSettings,
        ]);
    }
    // loyalty settings update function
    public function updateLoyaltySettings(Request $request)
    {
        $request->validate([
            'visitsRequired' => 'required|integer|min:1|max:50',
            'giftDescription' => 'required|string|max:255',
            'giftTitle' => 'required|string|max:500',
        ]);

        $owner = Auth::guard('owner')->user();
        if (!$owner) {
            return redirect()->route('owner.login');
        }

        $rewardSettings = $owner->restaurant->rewardSettings;



        $rewardSettings->update([
            'visits_required' => $request->visitsRequired,
            'gift_title' => $request->giftTitle,
            'gift_description' => $request->giftDescription,
        ]);

        // return with interjs response
        return Inertia::location('/owner/dashboard/loyalty-settings');
    }
    // function to get eligible customers for rewards
    // this function will return customers who have enough visits to claim a reward
    // it will check the last claimed reward date and count visits since that date
    // if the visits count is greater than or equal to the required visits, the customer is eligible

    public function eligibleCustomers($restaurantId)
    {
        $restaurant = Restaurant::with('rewardSettings')->findOrFail($restaurantId);
        $visitsRequired = optional($restaurant->rewardSettings)->visits_required ?? 1;

        // جلب كل الزيارات مع الزبائن
        $visits = Visit::with('customer')
            ->where('restaurant_id', $restaurantId)
            ->orderBy('visit_date', 'desc')
            ->get();

        $groupedByCustomer = $visits->groupBy('customer_id');
        $eligibleCustomers = [];

        foreach ($groupedByCustomer as $customerId => $customerVisits) {
            $customer = $customerVisits->first()->customer;

            // قسم الزيارات إلى مجموعات حسب العدد المطلوب
            $chunks = $customerVisits->chunk($visitsRequired);

            // تحقق من آخر مجموعة فقط
            $lastChunk = $chunks->last();

            // لو آخر مجموعة مكتملة (يعني مؤهل لهدية)
            if ($lastChunk && $lastChunk->count() == $visitsRequired) {
                $eligibleCustomers[] = $customer;
            }
        }

        return collect($eligibleCustomers);
    }

    // cashier interface
    public function cashierInterface()
    {
        $owner = Auth::guard('owner')->user();

        if (!$owner) {
            return redirect()->route('owner.login');
        }

        // Load relationships
        $owner->load(['restaurant', 'restaurant.rewardSettings']);

        // set restaurant
        $restaurant = $owner->restaurant;

        return Inertia::render('owner/dashboard/cashier', [
            'owner' => $owner,
            'restaurant' => $restaurant,
        ]);
    }
    // cashier visit function by customer code client
    public function cashierVisit(Request $request)
    {
        $owner = Auth::guard('owner')->user();

        if (!$owner) {
            return redirect()->route('owner.login');
        }

        // البحث عن العميل برمز العميل
        $customer = Customer::where('customer_code', $request->customer_code)->first();

        if (!$customer) {
            return response()->json([
                'error' => 'العميل غير موجود.',
            ], 404);
        }

        // تسجيل الزيارة الجديدة
        $visit = new Visit();
        $visit->restaurant_id = $owner->restaurant->id;
        $visit->customer_id = $customer->id;
        $visit->visit_date = now();
        $visit->save();

        // ربط العميل بالمطعم (إن لم يكن موجودًا مسبقًا)
        $owner->restaurant->customers()->syncWithoutDetaching([$customer->id]);

        // جلب جميع الزيارات للعميل في هذا المطعم
        $allVisits = Visit::where('restaurant_id', $owner->restaurant->id)
            ->where('customer_id', $customer->id)
            ->orderBy('visit_date', 'asc')
            ->get();

        // جلب visits_required من إعدادات المكافأة
        $visitsRequired = optional($owner->restaurant->rewardSettings)->visits_required ?? 1;

        // تقسيم الزيارات إلى مجموعات
        $chunks = $allVisits->chunk($visitsRequired);

        // عدد زيارات آخر مجموعة
        $lastGroupCount = $chunks->last()->count();

        // تحقق هل آخر مجموعة مكتملة (أي عدد زياراتها == visitsRequired)
        $message = ($lastGroupCount == $visitsRequired)
            ? '🎉 العميل استحق هدية!'
            : '✅ تم تسجيل الزيارة بنجاح.';

        return response()->json([
            'success' => $message,
            'customer' => $customer,
            'visit' => $visit,
        ]);
    }
    // handle page no active restaurant
    public function noActiveRestaurant()
    {
        return Inertia::render('owner/dashboard/noActive');
    }
}