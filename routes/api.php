<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('register', 'Auth\RegisterController@registerapi');
Route::post('login', 'Auth\LoginController@loginapi');
Route::group(['middleware' => 'localization'], function () {
    /********* logout **************/
    Route::post('/logout', 'Auth\LoginController@logoutapi');
});
Route::group(['namespace' => 'Api', 'middleware' => 'localization'], function () {
    Route::resource('page', 'PageController', ['only' => ['index', 'show']]);
    Route::get('faq', 'PageController@faq');
    Route::resource('all-categories', 'CategoryController', ['only' => ['index', 'show']]);
    Route::get('all-subcategories', 'CategoryController@subcategories');
    Route::get('subcategory/{id}', 'CategoryController@subcategory');
    Route::get('home/category', 'HomeController@categories');
    Route::get('home/sliders', 'HomeController@sliders');

    Route::resource('all-products', 'ProductController');

    Route::get('similar/product/{id}', 'ProductController@similar');
    Route::get('last-views/product/{id}', 'ProductController@views');

    Route::get('cart', 'CartController@cart');

    Route::get('all-types', 'ProductController@types');
    Route::get('all-materials', 'ProductController@materials');
    Route::get('all-brands', 'ProductController@brands');
    Route::get('all-sizes', 'ProductController@sizes');
    Route::get('all-colors', 'ProductController@colors');

    /******** new get **************/
    Route::get('privacy', 'HomeController@privacy');
    Route::get('legal', 'HomeController@legal');
    Route::get('home/hot_offers', 'HomeController@hot_offers');
    Route::get('home/all_hot_offers', 'HomeController@all_hot_offers');
    Route::get('home/chosen', 'HomeController@chosen');
    Route::get('home/all_chosen', 'HomeController@all_chosen');
    Route::get('home/interests', 'HomeController@interests');
    Route::get('home/all_interests', 'HomeController@all_interests');
    Route::get('wish-list', 'WishListController@favourites');
    Route::get('whatsapp', 'OptionsController@whatsapp');
    Route::get('facebook', 'OptionsController@facebook');
    Route::get('instagram', 'OptionsController@insta');
    Route::get('social', 'OptionsController@social');
    /* address */
    Route::get('addresses', 'AddressController@index');
    Route::get('address/{id}', 'AddressController@show');
    Route::get('contact-address', 'HomeController@contact_address');
    Route::get('contact-email', 'HomeController@contact_email');
    Route::get('contact-phone', 'HomeController@contact_phone');
    Route::get('all-cities', 'CountriesController@cities');
    Route::get('all-countries', 'CountriesController@index');
    Route::get('cat-slider', 'CategoryController@category_sliders');
    /******** post ************************************************************/
    /* add and delet from wishlist */
    Route::post('add_delete_wishlist', 'WishListController@add_delete_wishlist');
    /* address */
    Route::post('add/address', 'AddressController@store');
    Route::post('edit/address/{id}', 'AddressController@update');
    Route::post('delete/address/{id}', 'AddressController@destroy');
    Route::post('delete/addresses', 'AddressController@delete_all');
    Route::post('main/address/{id}', 'AddressController@main');
    /* profile */
    Route::post('edit/profile', 'ProfileController@edit_info');
    Route::post('contact', 'HomeController@contact');
    /* search */
    Route::post('search', 'ProductController@search');
    /* country */
    Route::post('chose_country', 'CountriesController@choose_country');
    Route::post('change_country', 'CountriesController@change_country');

});
