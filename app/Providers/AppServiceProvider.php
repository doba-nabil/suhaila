<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Moderator;
use App\Models\Option;
use App\Models\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if(\Schema::hasTable('options')){
            $option = Option::find(1);
            if(!isset($option)){
                $option = new Option();
                $option->id = 1;
                $option->title_ar = 'سهيلة';
                $option->title_en = 'Suhaila';
                $option->face = 'facebook.com';
                $option->insta = 'instagram.com';
                $option->twitter = 'twitter.com';
                $option->youtube = 'youtube.com';
                $option->phone = '99999900000000';
                $option->whats = '99999900000000';
                $option->email = 'najla@gmail.com';
                $option->ios = 'https://apps.apple.com/';
                $option->andriod = 'https://play.google.com/';
                $option->active = 1;
                $option->save();
            }
            $admin = Moderator::find(1);
            if(!isset($admin)){
                $admin = new Moderator();
                $admin->id = 1;
                $admin->name = 'Admin';
                $admin->email = 'admin@gmail.com';
                $admin->password = Hash::make('123456789');
                $admin->status = 1;
                $admin->save();
            }
            $page = Page::find(1);
            if(!isset($page)){
                $page = new Page();
                $page->id = 1;
                $page->name_ar = 'عن سهيلة';
                $page->name_en = 'About Suhaila';
                $page->body_ar = 'عن سهيلة';
                $page->body_en = 'About Suhaila';
                $page->slug = 'about-home';
                $page->active = 1;
                $page->save();

                $page = new Page();
                $page->id = 2;
                $page->name_ar = 'عن سهيلة';
                $page->name_en = 'About Suhaila';
                $page->body_ar = 'عن سهيلة';
                $page->body_en = 'About Suhaila';
                $page->slug = 'about-us';
                $page->active = 1;
                $page->save();
            }
            $country = Country::find(1);
            if(!isset($country)){
                $country = new Country();
                $country->id = 1;
                $country->name_ar = 'المملكة العربية السعودية';
                $country->name_en = 'Saudi Arabia';
                $country->code = 'KSA';
                $country->active = 1;
                $country->save();

                $currency = new Currency();
                $currency->id = 1;
                $currency->name_ar = 'ريال';
                $currency->name_en = 'SAR';
                $currency->code = 'KSA';
                $currency->country_id = $country->id;
                $currency->active = 1;
                $currency->save();
            }
        }
    }
}
