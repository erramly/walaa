<?php

use App\Http\Controllers\AdminController;
use Inertia\Inertia;
use App\Models\owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ownerController;
use App\Http\Controllers\CustomerController;
use App\Models\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['redirect.if.authenticated:owner'])->group(function () {
    // owner login route view
    Route::get('/owner/login', [ownerController::class, 'index']);
    //login and signup routes for owner
    Route::post('/owner/login', [ownerController::class, 'login'])->name('owner.login');
    Route::post('/owner/signup', [ownerController::class, 'signup']);



});
// redirect if authenticated admin
Route::middleware(['redirect.if.authenticated:admin'])->group(function () {
    // admin login
    Route::get('/admin/login', function () {
        return Inertia::render('admin/login');
    })->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');
});
// redirect if authenticated customer

Route::middleware(['redirect.if.authenticated:customer'])->group(function () {
    // customer login
    Route::get('/customer/login', [CustomerController::class, 'loginView'])->name('customer.login');
    // customer registration
    Route::post('/customer/register', [CustomerController::class, 'register'])->name('customer.register');
    Route::post('/customer/login', [CustomerController::class, 'login'])->name('customer.login');
});


Route::middleware(['auth:owner', 'owner.active'])->group(function () {
    Route::get('/owner/dashboard', [ownerController::class, 'dashboardView'])->name('owner.dashboard');
    Route::get('/owner/dashboard/clients', [ownerController::class, 'clientsDashboardView']);
    Route::get('/owner/dashboard/loyalty-settings', [ownerController::class, 'loyaltySettingsView']);
    // Update loyalty settings
    Route::post('/owner/dashboard/loyalty-settings', [ownerController::class, 'updateLoyaltySettings'])->name('owner.updateLoyaltySettings');
    // cashier interface
    Route::get('/owner/cashier', [ownerController::class, 'cashierInterface'])->name('owner.cashier');
    // cashier visit
    Route::post('/owner/cashier/visit', [ownerController::class, 'cashierVisit'])->name('owner.cashier.visit');
    Route::get('/owner/no-active', [ownerController::class, 'noActiveRestaurant'])->name('owner.noActiveRestaurant');

});


// routes for customers
Route::middleware(['auth:customer'])->group(function () {

    // customer dashboard routes
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboardView'])->name('customer.dashboard');


    // customer logout
    Route::post('/customer/logout', function () {
        Auth::guard('customer')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('customer.login');
    })->name('customer.logout');
});

// routes for admin
Route::middleware(['auth:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboardView'])->name('admin.dashboard');
    // admin management view
    Route::get('/admin/dashboard/management', [AdminController::class, 'managementView'])->name('admin.management');

    // admin signup for restaurant
    Route::post('/admin/signup-for-restaurant', [AdminController::class, 'signupForRestaurant'])->name('admin.signupForRestaurant');
    //delete restaurant
    Route::post('/admin/delete-restaurant/{id}', [AdminController::class, 'deleteOwner'])->name('admin.deleteRestaurant');
    // update restaurant data
    Route::post('/admin/update-restaurant/{id}', [AdminController::class, 'updateRestaurantData'])->name('admin.updateRestaurantData');
    // toggle restaurant status
    Route::post('/admin/toggle-restaurant-status/{id}', [AdminController::class, 'toggleRestaurantStatus'])->name('admin.toggleRestaurantStatus');
    //logout
    Route::post('/admin/logout', function () {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('admin.logout');
});














Route::post('/logout', function () {
    Auth::guard('owner')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

})->name('logout');


