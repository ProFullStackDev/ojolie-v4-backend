<?php

use GuzzleHttp\Middleware;
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

Route::namespace('API\Auth')->group(function(){
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->middleware('auth:sanctum');

    Route::get('verify/{id}', 'AccountVerifyController@active_user');
    Route::post('password/email','ForgotPasswordController@forgot_password');
    Route::post('password/reset','ResetPasswordController@reset');
    Route::get('reset/password/{token}/{email}', 'ResetPasswordController@reset_password')->name('reset.password');
});

Route::namespace('API\Account')->prefix('account')->middleware('auth:sanctum')->group(function(){
    Route::get('profile', 'ProfileController@index');
    Route::put('profile/{type}', 'ProfileController@update');
    Route::get('profile/favourite/toggle/{ecard_id}', 'ProfileController@togglefavourite');
    Route::get('profile/favourite/cards', 'ProfileController@favouritecards');
    Route::get('profile/favourite/check/{ecard_id}', 'ProfileController@checkfavourite');
    Route::post('renew', 'ProfileController@renew');

    Route::apiResource('addressgroups', 'AddressbookGroupsController');

    Route::put('addressbooks/group/{type}','AddressbooksController@group');
    Route::put('addressbooks/group/multiple/{type}','AddressbooksController@group_multiple');
    Route::apiResource('addressbooks', 'AddressbooksController');
    Route::post('addressbooks/import/contact', 'AddressbooksController@contact_store');
    Route::delete('addressbooks/delete/{id}', 'AddressbooksController@destroy');
    Route::post('addressbooks/delete/multiple', 'AddressbooksController@destroy_multiple');

    Route::get('payments', 'PaymentsController@index');
});

Route::namespace('API\Product')->prefix('product')->group(function(){
    Route::get('categories', 'EcardCategoriesController@index');
    Route::get('categories/menu/holidays', 'EcardCategoriesController@holidays_menu');
    Route::get('categories/menu/other', 'EcardCategoriesController@other_categories_menu');
    Route::get('categories/{id}', 'EcardCategoriesController@show');
    // Route::get('category/detail/{slug}', 'EcardCategoriesController@show_slug');
    Route::get('category/detail/{slug}', 'EcardCategoriesController@get_slug');
    Route::get('cards', 'EcardsController@index');
    Route::get('cards/free', 'EcardsController@free_cards');
    Route::get('cards/private', 'EcardsController@private_cards');
    Route::get('latest/cards', 'EcardsController@latest');
    Route::get('recommended/cards', 'EcardsController@recommended');
    Route::get('popular/cards', 'EcardsController@popular');
    Route::get('popular/cards/slideshow', 'EcardsController@popular_slideshow');
    Route::get('cards/{id}', 'EcardsController@show');
    Route::post('search', 'EcardsController@search');
    Route::get('last_payment', 'PaymentsController@last_payment');

    Route::apiResource('ecardsentitems', 'EcardsentItemsController')->middleware('auth:sanctum');
    Route::post('sentcard/draft', 'EcardsentItemsController@store_draft')->middleware('auth:sanctum');
    Route::put('sentcard/draft/update/{id}', 'EcardsentItemsController@update_draft')->middleware('auth:sanctum');
    Route::get('sentcard/delete/{id}', 'EcardsentItemsController@destroy')->middleware('auth:sanctum');

    Route::get('ecardpickup/redirect/{ecardsent_recipient_id}', 'EcardpickupController@redirectPickup');
    Route::get('ecardpickup/{ecardsent_recipient_id}', 'EcardpickupController@index');
    Route::post('ecardpickup/reply', 'EcardpickupController@reply');

    Route::get('prices', 'PricesController@index');
    Route::get('popular-searches','PopularSearch@index');
});

Route::namespace('API\Extra')->prefix('extra')->group(function(){
    Route::get('timezones', 'TimezonesController@index');

    Route::get('pages/{name}', 'PagesController@index');
    Route::post('pages/contactus', 'PagesController@contactus');

    Route::get('autosuggest/categories', 'AutoSuggestController@categories');
    Route::get('autosuggest/cards', 'AutoSuggestController@cards');
});

Route::namespace('API\Dynamic')->prefix('dynamic')->group(function(){
    Route::get('homepage/video', 'DynamicVideoController@index');
    Route::get('homepage/3cards', 'HomeDynamicCardsController@index');
});

Route::namespace('API\Mailing')->prefix('mailing')->group(function(){
    Route::post('sent', 'MailingController@store');
    Route::post('newsletter/subscribe', 'NewsletterSubscriptionController@store');
    Route::get('unsubscribe-newsletter/{id}', 'NewsletterSubscriptionController@destroy');
});

Route::namespace('API\Contact')->prefix('contact')->group(function(){
    Route::post('send/message', 'ContactMessageController@store');
});
