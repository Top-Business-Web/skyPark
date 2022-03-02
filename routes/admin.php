<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'admin','middleware'=>'auth:admin','namespace'=>'Admin'],function (){
    Route::get('/', function () {
        return view('Admin/index');
    })->name('adminHome');


    #### Admins ####
    Route::resource('admins','AdminController');
    Route::POST('admins.delete','AdminController@delete')->name('admins.delete');
    Route::get('my_profile','AdminController@myProfile')->name('myProfile');
    Route::post('store-profile','AdminController@saveProfile')->name('store-profile');

    #### Categories ####
    Route::resource('category','CategoryController');
    Route::POST('category.delete','CategoryController@delete')->name('category.delete');

    #### Products ####
    Route::resource('product','ProductController');
    Route::POST('product.delete','ProductController@delete')->name('product.delete');

    #### Bracelets ####
    Route::resource('bracelet','BraceletsController');
    Route::POST('bracelet.delete','BraceletsController@delete')->name('bracelet.delete');

    #### References ####
    Route::resource('reference','RefernceController');
    Route::POST('reference.delete','RefernceController@delete')->name('reference.delete');

    #### Users ####
    Route::resource('users','UsersController');
    Route::POST('users.delete','UsersController@delete')->name('users.delete');

    #### Capacity ####
    Route::resource('capacities','CapacityController');
    Route::POST('capacities.delete','CapacityController@delete')->name('capacities.delete');

    #### Clients ####
    Route::resource('clients','ClientsController');
    Route::POST('client.delete','ClientsController@delete')->name('client.delete');

    #### Sliders ####
    Route::resource('sliders','SlidersController');
    Route::POST('slider.delete','SlidersController@delete')->name('slider.delete');

    #### About Us ####
    Route::resource('about_us','AboutUsController');
    Route::POST('about_us.delete','AboutUsController@delete')->name('about_us.delete');

    #### Activities ####
    Route::resource('activity','ActivityController');
    Route::POST('activity.delete','ActivityController@delete')->name('activity.delete');

    #### Offers ####
    Route::resource('offers','OfferController');
    Route::POST('offer.delete','OfferController@delete')->name('offer.delete');

    #### Offers Items ####
    Route::resource('items','OfferItemsController');
    Route::POST('items.delete','OfferItemsController@delete')->name('items.delete');


    #### Contact Us ####
    Route::resource('contact_us','ContactUsController');
    Route::POST('contact_us.delete','ContactUsController@delete')->name('contact_us.delete');
    Route::POST('read_message','ContactUsController@read_message')->name('read_message');
    Route::get('getCount','ContactUsController@getCount')->name('getCount');


    #### Setting ####
    Route::get('general_setting','SettingController@index')->name('general_setting.index');
    Route::POST('edit_setting','SettingController@edit')->name('admin.edit.setting');
    Route::get('getLogo','SettingController@getLogo')->name('getLogo');

    #### Auth ####
    Route::get('logout', 'AuthController@logout')->name('admin.logout');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    Route::get('login', 'AuthController@index')->name('admin.login');
    Route::POST('login', 'AuthController@login')->name('admin.login');
});






