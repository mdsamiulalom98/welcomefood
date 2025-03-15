<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\CustomerController;


Route::group(['namespace' => 'Api','prefix'=>'v1','middleware' => 'api'], function(){
    
     Route::get('app-config', [FrontendController::class, 'appconfig']);
     Route::get('slider', [FrontendController::class, 'slider']);
     Route::get('category-menu', [FrontendController::class, 'categorymenu']);
     Route::get('hotdeal-food', [FrontendController::class, 'hotdealfood']);
     Route::get('homepage-food', [FrontendController::class, 'homepagefood']);
     Route::get('footer-menu-left', [FrontendController::class, 'footermenuleft']);
     Route::get('footer-menu-right', [FrontendController::class, 'footermenuright']);
     Route::get('social-media', [FrontendController::class, 'socialmedia']);
     
     Route::get('contactinfo', [FrontendController::class, 'contactinfo']);
     Route::get('review', [FrontendController::class, 'getReview']);
     
    //  Home Page Api End =================================
    
  
    
    // ========== My Api ============//
    
     Route::get('category/{id}', [FrontendController::class, 'catfood']);
     Route::get('popular-food-items', [FrontendController::class, 'popular_items']);
     Route::get('main-category', [FrontendController::class, 'main_cateogory']);
     Route::get('shipping-charge', [FrontendController::class, 'shipping_charge']);
     Route::get('quick-view/{id}', [FrontendController::class, 'quick_view']);
     Route::get('search', [FrontendController::class, 'search'])->name('search');
     
     
     
     
// customer route
    Route::get('/shipping-charge', [FrontendController::class, 'shipping_charge'])->name('shipping.charge');
    Route::get('districts', [FrontendController::class, 'districts'])->name('districts');
    Route::get('areas', [FrontendController::class, 'areas'])->name('areas');
    
    // customer routes
    Route::post('customer/login', [CustomerController::class, 'login']);
    Route::post('customer/store', [CustomerController::class, 'register']);
    Route::post('customer/order-save', [CustomerController::class, 'order_save']);
    
    

});

Route::group(['namespace' => 'Api','prefix'=>'v1','middleware' =>'auth.jwt'], function(){
    Route::post('customer/resend-otp', [CustomerController::class, 'resendotp']);
    Route::post('customer/verify', [CustomerController::class, 'account_verify']);
    Route::post('customer/forgot-password', [CustomerController::class, 'forgot_password']);
    Route::post('customer/resend-forgot', [CustomerController::class, 'resend_forgot']);
    Route::post('customer/forgot-verify', [CustomerController::class, 'forgot_verify']);
    Route::get('customer/setting', [CustomerController::class, 'setting']);
    Route::get('customer/orders', [CustomerController::class, 'orders']);
    
    Route::get('customer/profile', [CustomerController::class, 'profile']);
    Route::post('customer/change-password', [CustomerController::class, 'change_password'])->name('change_password');
    Route::post('customer/profile-update', [CustomerController::class, 'profile_update'])->name('profile_update');
    
    Route::get('customer/order-track/result', [CustomerController::class, 'order_track'])->name('customer.order_track');
    Route::get('/customer/order/invoice/{id}', [CustomerController::class, 'invoice']);
    Route::post('/customer/coupon', [CustomerController::class, 'customer_coupon'])->name('customer.coupon');
    Route::post('/customer/post/review', [CustomerController::class, 'review'])->name('customer.review');
    
});
    
    
    
