<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*****************/
View::creator('frontend.layout.master', function ($view) {
    $view->with('option' , \App\Models\Option::find(1));
});
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect']
], function() {
    Auth::routes();
});

Route::group([
    'namespace' => 'User',
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect']
], function() {

    view()->share('lang', app()->getLocale());
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('search', 'HomeController@search')->name('search');
    /********** profile **********/
    Route::get('profile', 'ProfileController@profile')->name('profile');
    Route::get('purchases', 'ProfileController@purchases')->name('purchases');
    Route::post('edit_profile', 'ProfileController@edit_profile')->name('edit_profile');
    /******** category *******/
    Route::get('all-categories', 'CategoryController@all')->name('all_categories');
    Route::get('category/{slug}', 'CategoryController@single')->name('single_category');
    /******** product *******/
    Route::get('all-products', 'ProductController@all')->name('all_products');
    Route::get('product/{slug}', 'ProductController@single')->name('single_product');
    /******** video *******/
    Route::get('all-videos', 'VideoController@all')->name('all_videos');
    Route::get('video/{slug}', 'VideoController@single')->name('single_video');
    /******* contact ******/
    Route::get('contact', 'HomeController@contact')->name('contact');
    Route::post('contact/send', 'HomeController@send_contact')->name('send_contact');
    /******* page ******/
    Route::get('about-us', 'PageController@about')->name('about');
    Route::get('page/{slug}', 'PageController@page')->name('page');
    /******* end contact ******/
    /*** cart ****/
    Route::post('ajaxadd', 'CartController@productcart')->name('ajaxadd');
    Route::get('cart', 'CartController@cart')->name('cart');
    Route::get('clear_cart', 'CartController@clear_cart')->name('clear_cart');
    Route::post('remove', 'CartController@remove')->name('remove');
    Route::get('update_cart', 'CartController@edit_cart')->name('editcart');
    /********** make order *************/
    Route::post('make_order', 'CartController@make_order')->name('make_order');
    /******** wishlist **********/
    Route::get('wishlist', 'wishController@wishlist')->name('wishlist');
    Route::post('wishlist_add', 'wishController@addToWish')->name('addToWish');
    Route::post('wishlist/remove/{wishID}', 'wishController@removeFromWish')->name('removeFromWish');
    Route::get('wishlist/distroy', 'wishController@distroy')->name('wishlistDistroy');
    /*** send email ****/
    Route::post('email', 'HomeController@send_email')->name('send_email');
});

