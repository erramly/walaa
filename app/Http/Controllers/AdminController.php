<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\Visit;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboardView()
    {
        // count of customers, owners, and restaurants
        $customerCount = \App\Models\Customer::count();
        // count visits today
        $todayVisits = Visit::whereDate('created_at', today())->count();
        $restaurantCount = Restaurant::count();
        // best five resturants by visits
        $bestRestaurants = Restaurant::select('name')
            ->withCount('visits')
            ->orderBy('visits_count', 'desc')
            ->take(5)
            ->get();
        return Inertia::render('admin/dashboard/dashboard', [
            'statistics' => [
                'customers' => $customerCount,
                'visits' => $todayVisits,
                'restaurants' => $restaurantCount,
            ],
            'bestRestaurants' => $bestRestaurants,
        ]);
    }
    /**
     * Handle the admin login request.
     */
    public function adminLogin(Request $request)
    {
        // dd($request->all());


        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/admin/dashboard');
        }
        // If authentication fails, redirect back with an error
        return redirect()->back()->withInput()->withErrors([
            'email' => 'Invalid email or password.',
        ]);

    }
    /**
     * Show the admin management view.
     */
    public function managementView()
    {
        // جلب كل المالكين مع المطاعم الخاصة بهم + عدد الزيارات والعملاء
        $owners = Owner::with([
            'restaurant' => function ($query) {
                $query->withCount('visits') // عدد الزيارات
                    ->withCount('customers'); // عدد العملاء
            }
        ])->get();

        // تجهيز البيانات للواجهة
        $data = $owners->map(function ($owner) {
            $restaurant = $owner->restaurant;

            return [
                'id' => $owner->id,
                'restaurant_name' => $restaurant->name,
                'restaurant_location' => $restaurant->location,
                'owner_name' => $owner->name,
                'status' => 'نشط',
                'visits' => $restaurant->visits_count,
                'customers' => $restaurant->customers_count,
                'visitsRequired' => optional($restaurant->rewardSettings)->visits_required,
                'phone' => $owner->phone,
                'is_active' => $restaurant->is_active,
            ];
        });

        return Inertia::render('admin/dashboard/management', [
            'restaurants' => $data,
        ]);
    }

    public function signupForRestaurant(Request $request)
    {
        DB::beginTransaction();

        try {
            $restaurant = Restaurant::create([
                'name' => $request->restaurant_name,
                'location' => $request->address,
            ]);

            $owner = Owner::create([
                'name' => $request->owner_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'password' => bcrypt($request->password),
                'restaurant_id' => $restaurant->id,
            ]);
            // create default reward settings for the restaurant
            DB::table('reward_settings')->insert([
                'restaurant_id' => $restaurant->id,
                'visits_required' => 10, // مثلا قيمة افتراضية
                'gift_title' => 'هدية مجانية',
                'gift_description' => 'احصل على هدية ',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();

            Auth::guard('owner')->login($owner);


            return redirect()->route('admin.dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء التسجيل.']);
        }
    }
    // delete owner with his restaurant by id
    public function deleteOwner($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->withErrors(['error' => 'غير مصرح لك.']);
        }

        DB::beginTransaction();
        try {
            $owner = Owner::findOrFail($id);
            $restaurant = $owner->restaurant;

            if ($restaurant) {
                // افصل الربط بين المالك والمطعم أولاً
                $owner->restaurant_id = null;
                $owner->save();

                // ثم احذف العلاقات المرتبطة بالمطعم
                $restaurant->rewardSettings()?->delete();
                $restaurant->visits()->delete();
                $restaurant->restaurantCustomers()->delete();

                $restaurant->delete(); // الآن يمكن حذفه بأمان
            }

            $owner->delete(); // ثم نحذف المالك

            DB::commit();
            return redirect()->route('admin.management')->with('success', 'تم حذف المالك والمطعم بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
    /** update data of restaurant by this data :

    */
    public function updateRestaurantData(Request $request, $id)
    {
        //dd($request->all(), $id);
        DB::beginTransaction();

        try {
            $owner = Owner::findOrFail($id);
            $owner->update([
                'name' => $request->owner_name,

                'phone' => $request->phone,
            ]);

            $restaurant = $owner->restaurant;
            $restaurant->update([
                'name' => $request->restaurant_name,
                'location' => $request->restaurant_location,


            ]);
            $restaurant->rewardSettings()
                ->updateOrCreate(
                    [], // شرط البحث (لا شيء لأن hasOne تربط بسطر واحد)
                    [
                        'visits_required' => $request->visitsRequired,
                    ]
                );
            if ($request->filled('password')) {
                $owner->password = bcrypt($request->password);
                $owner->save();
            }

            DB::commit();

            return redirect()->route('admin.management')->with('success', 'تم تحديث بيانات المطعم بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء تحديث البيانات.']);
        }
    }
    public function toggleRestaurantStatus($id)
    {
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->is_active = !$restaurant->is_active; // Toggle the status
            $restaurant->save();
             //dd($restaurant->is_active);
            return redirect()->route('admin.management')->with('success', 'تم تحديث حالة المطعم بنجاح.');
        } catch (\Exception $e) {
            dd($e->getMessage());

        }
    }


}



// <?php

// namespace App\Http\Controllers;

// use Inertia\Inertia;
// use App\Models\Admin;
// use App\Models\Owner;
// use App\Models\Restaurant;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;

// class AdminController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function dashboardView()
//     {
//         return Inertia::render('admin/dashboard/dashboard');
//     }
//     /**
//      * Handle the admin login request.
//      */
//     public function adminLogin(Request $request)
//     {
//         // dd($request->all());


//         $credentials = $request->only('email', 'password');
//         if (Auth::guard('admin')->attempt($credentials)) {
//             // Authentication passed...
//             return redirect()->intended('/admin/dashboard');
//         }
//         // If authentication fails, redirect back with an error
//         return redirect()->back()->withInput()->withErrors([
//             'email' => 'Invalid email or password.',
//         ]);

//     }
//     /**
//      * Show the admin management view.
//      */
//     public function managementView()
//     {
//         return Inertia::render('admin/dashboard/management');
//     }
//     public function signupForRestaurant(Request $request)
//     {
//         DB::beginTransaction();

//         try {
//             $restaurant = Restaurant::create([
//                 'name' => $request->restaurant_name,
//                 'location' => $request->address,
//             ]);

//             $owner = Owner::create([
//                 'name' => $request->owner_name,
//                 'email' => $request->email,
//                 'phone' => $request->phone_number,
//                 'password' => bcrypt($request->password),
//                 'restaurant_id' => $restaurant->id,
//             ]);
//             // create default reward settings for the restaurant
//             DB::table('reward_settings')->insert([
//                 'restaurant_id' => $restaurant->id,
//                 'visits_required' => 10, // مثلا قيمة افتراضية
//                 'gift_title' => 'هدية مجانية',
//                 'gift_description' => 'احصل على هدية ',
//                 'active' => true,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);
//             DB::commit();

//             Auth::guard('owner')->login($owner);


//             return redirect()->route('owner.dashboard');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return back()->withErrors(['error' => 'حدث خطأ أثناء التسجيل.']);
//         }
//     }
// }