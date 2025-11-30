<?php

use App\Http\Controllers\AuthCustomerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaystackController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


Route::domain('hpanel.ilvarire.com')
    ->group(function () {
        Route::get('/', function () {
            return view('welcome');
        })->name('try');
        // Add other admin routes here...
    });


Route::view('/maintenance', 'pages.maintenance-page')
    ->middleware('notmaintenance')
    ->name('maintenance');
Route::get('dashboard', [AuthCustomerController::class, 'dashboard'])
    ->middleware(['auth', 'verified', 'maintenance'])
    ->name('dashboard');

Route::middleware('maintenance')->controller(CustomerController::class)->group(function () {

    Route::get('/', 'home')->name('home');
    Route::get('/cart', 'cart')->name('cart');
    Route::get('/wishlist', 'wishlist')->name('wishlist');
    Route::get('/products', 'products')->name('products');
    Route::get('/product/{slug}', 'productDetails')->name('product.details');

    //company
    Route::get('/policy', 'policy')->name('policy');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
});

Route::middleware(['auth', 'verified', 'maintenance', 'rolemanager:customer'])->controller(AuthCustomerController::class)->group(function () {
    Route::get('/checkout', 'checkout')->name('checkout');
    Route::get('/orders', 'orders')->name('orders');
    Route::get('/order/{reference}', 'orderDetails')->name('orders.details');

    Route::get('/profile', 'profile')->name('profile');
    Route::get('/payments', 'payments')->name('payments');
    Route::get('/payment/{reference}', 'paymentDetails')->name('payment.details');
    Route::get('/order/success/{transaction_reference}', 'successPage')->name('order.success');
});

Route::middleware(['auth', 'verified', 'rolemanager:customer'])->controller(PaystackController::class)->group(function () {
    // Paystack Payment Gateway Routes
    Route::get('/paystack/callback', 'handleGatewayCallback')->name('paystack.callback');
    Route::post('/paystack/webhook', 'handle')->name('paystack.webhook');
});

Route::middleware(['auth'])->group(function () {
    // Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__ . '/admin.php';
