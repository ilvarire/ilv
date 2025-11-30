<?php

use App\Livewire\Admin\AboutSetting;
use App\Livewire\Admin\AddCouponCode;
use App\Livewire\Admin\AddProduct;
use App\Livewire\Admin\AddShippingRate;
use App\Livewire\Admin\AdSetting;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\ContactSetting;
use App\Livewire\Admin\Countries;
use App\Livewire\Admin\CouponCodes;
use App\Livewire\Admin\Customers;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\HeroSetting;
use App\Livewire\Admin\NewsletterEmails;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Payments;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Profile;
use App\Livewire\Admin\Reviews;
use App\Livewire\Admin\SendEmails;
use App\Livewire\Admin\SentEmails;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\ShippingRates;
use App\Livewire\Admin\SiteSetting;
use App\Livewire\Admin\Tags;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'rolemanager:admin'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        //dashboard
        Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');

        //categories
        Route::get('/categories', Categories::class)->name('admin.categories');

        //product
        Route::get('/products', Products::class)->name('admin.products');
        Route::get('/products/add', AddProduct::class)->name('admin.products.add');
        Route::get('/reviews', Reviews::class)->name('admin.reviews');

        //tags
        Route::get('/tags', Tags::class)->name('admin.tags');

        //order
        Route::get('/orders', Orders::class)->name('admin.orders');

        //payments
        Route::get('/payments', Payments::class)->name('admin.payments');

        //customers
        Route::get('/customers', Customers::class)->name('admin.customers');

        //coupons & discount
        Route::get('/coupons', CouponCodes::class)->name('admin.coupons');
        Route::get('/coupon/add', AddCouponCode::class)->name('admin.coupon.add');

        //countries
        Route::get('/countries', Countries::class)->name('admin.countries');

        //shipping rates
        Route::get('/rates', ShippingRates::class)->name('admin.rates');
        Route::get('/rates/add', AddShippingRate::class)->name('admin.rates.add');

        //Emails - newsletter
        Route::get('/emails', NewsletterEmails::class)->name('admin.emails');
        Route::get('/email/send', SendEmails::class)->name('admin.sendmail');
        Route::get('/email/sent', SentEmails::class)->name('admin.sentmail');

        //Settings
        Route::get('/settings', Settings::class)->name('admin.settings');
        Route::get('/settings/about', AboutSetting::class)->name('admin.settings.about');
        Route::get('/settings/contact', ContactSetting::class)->name('admin.settings.contact');
        Route::get('/settings/hero', HeroSetting::class)->name('admin.settings.hero');
        Route::get('/settings/ad', AdSetting::class)->name('admin.settings.ad');
        Route::get('/settings/site', SiteSetting::class)->name('admin.settings.site');

        //Profile
        Route::get('/profile', Profile::class)->name('admin.profile');
    });
});
