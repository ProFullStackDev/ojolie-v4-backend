<?php

use App\Mail\FreeMemberMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::group(['middleware' => ['auth']], function() {

Route::get('/', 'DashboardController@index')->name('dashboard.index')->middleware('auth');

Route::post('ecardcategories/datasource','EcardCategoriesController@datasource')->name('ecardcategories.datasource');
Route::get('ecardcategories/setdate/{id}','EcardCategoriesController@setdate')->name('ecardcategories.setdate');
Route::put('ecardcategories/setdate_add/{id}','EcardCategoriesController@setdate_add')->name('ecardcategories.setdate_add');
Route::resource('ecardcategories', 'EcardCategoriesController');

Route::post('ecards/datasource','EcardsController@datasource')->name('ecards.datasource');
Route::get('ecards/sort_delete/{id}','EcardsController@sort_delete')->name('ecards.sort_delete');
Route::post('ecards/sort_delete_multiple','EcardsController@sort_delete_multiple')->name('ecards.sort_delete_multiple');
Route::get('ecards/sort','EcardsController@sort')->name('ecards.sort');
Route::post('ecards/sort_store_multiple','EcardsController@sort_store_multiple')->name('ecards.sort_store_multiple');
Route::post('ecards/sort','EcardsController@sort_store')->name('ecards.sort.store');
Route::put('ecards/autoupdate/{id}', 'EcardsController@autoupdate')->name('ecards.autoupdate');
Route::put('ecards/update_template/{id}', 'EcardsController@update_template')->name('ecards.update_template');
Route::post('ecards/copy_template', 'EcardsController@copy_template')->name('ecards.copy_template');
Route::post('ecards/draftsave', 'EcardsController@draft_store')->name('ecards.draft_store');
Route::resource('ecards', 'EcardsController');
Route::resource('pages', 'PagesController');

Route::get('ecard-template','EcardTemplateController@index');
Route::post('ecard-template/add', 'EcardTemplateController@add');
Route::post('ecard-template/update', 'EcardTemplateController@update');
Route::post('ecard-template/update_assigned', 'EcardTemplateController@update_assigned');
Route::get('ecard-template/delete/{id}', 'EcardTemplateController@destroy');
Route::get('ecard-template/get_card_info/{id}', 'EcardTemplateController@get_card_info');
Route::get('ecard-template/get_template_info/{id}', 'EcardTemplateController@get_template_info');
Route::resource('ecard-template','EcardTemplateController');

Route::post('users/datasource','UsersController@datasource')->name('users.datasource');
Route::resource('users', 'UsersController');

Route::post('sentcards/datasource','SentCardsController@datasource')->name('sentcards.datasource');
Route::get('sentcards/detail/{id}','SentCardsController@show')->name('sentcards.detail');
Route::resource('sentcards', 'SentCardsController');

Route::post('orders/datasource','OrdersController@datasource')->name('orders.datasource');
Route::resource('orders', 'OrdersController');

Route::get('settings','SettingsController@index')->name('settings.index');
Route::post('settings','SettingsController@store')->name('settings.store');

Route::get('blacklist','BlackListController@index');
Route::post('blacklist/add', 'BlackListController@add');
Route::get('blacklist/delete/{id}', 'BlackListController@destroy');
Route::resource('blacklist','BlackListController');

Route::get('dynamic-video','DynamicVideoController@index');
Route::post('dynamic-video/add', 'DynamicVideoController@add');
Route::get('dynamic-video/delete/{id}', 'DynamicVideoController@destroy');
Route::resource('dynamic-video','DynamicVideoController');

Route::get('home-dynamic-cards','HomeDynamicCardsController@index');
Route::post('home-dynamic-cards/add', 'HomeDynamicCardsController@add');
Route::get('home-dynamic-cards/delete/{id}', 'HomeDynamicCardsController@destroy');
Route::resource('home-dynamic-cards','HomeDynamicCardsController');

Route::get('mailing-list','MailingController@index');
Route::get('mailing-list/delete/{id}', 'MailingController@destroy');
Route::resource('mailing-list','MailingController');

Route::get('newsletter-subscription','NewsletterSubscriptionController@index');
Route::get('newsletter-subscription/delete/{id}', 'NewsletterSubscriptionController@destroy');
Route::resource('newsletter-subscription','NewsletterSubscriptionController');

Route::get('pricing-list','PricesController@index');
Route::post('pricing-list/add', 'PricesController@add');
Route::get('pricing-list/delete/{id}', 'PricesController@destroy');
Route::resource('pricing-list','PricesController');

Route::get('premium-subscription-type','PremiumSubscriptionTypeController@index');
Route::post('premium-subscription-type/add', 'PremiumSubscriptionTypeController@add');
Route::get('premium-subscription-type/delete/{id}', 'PremiumSubscriptionTypeController@destroy');
Route::resource('premium-subscription-type','PremiumSubscriptionTypeController');

Route::get('contact-messages','ContactMessageController@index');
Route::get('contact-messages/{id}/detail', 'ContactMessageController@show');
Route::get('contact-messages/delete/{id}', 'ContactMessageController@destroy');
Route::resource('contact-messages','ContactMessageController');
Route::resource('popular-searches','PopularSearchController');

});

Auth::routes(['register'=>false]);

Route::get('member/activate/{id}', function($id){
    $user = App\User::find(decrypt($id));
    if($user)
    {
        $user->active = 0;
        $user->save();

        Mail::to($user)
        ->queue(new FreeMemberMail($user));
    }
    return redirect('https://staging-ojolie-frontend-pfylq.ondigitalocean.app/account-activate-message');

})->name('member.activate');

Route::get('test-payment', function (){
    return view('test-payment.index');
});
