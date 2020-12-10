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

Route::get('/', function () {
    return view('welcome');
});

/*---------------------------------------------------------------------------------------
*
*									GLOBAL ROUTES
*
*-------------------------------------------------------------------------------------*/
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::post('profile_upload', 'HomeController@profile_upload')->name('profile_upload');
Route::post('profile_update', 'HomeController@profile_update')->name('profile_update');
Route::post('profile_pass_reset', 'HomeController@profile_pass_reset')->name('profile_pass_reset');
Route::get('/pending', 'PendingController@pending')->name('pending');
Route::resource('area','AreaController');
Route::resource('file_replacement', 'FileReplacementController');
Route::resource('file_damage', 'ProductFileDamagesController');


/*---------------------------------------------------------------------------------------
*
*									ADMIN ROUTES
*
*-------------------------------------------------------------------------------------*/
Route::get('profile', 'HomeController@profile')->name('profile');
Route::get('edit_product/{id}','ProductController@edit_product')->name('edit_product');
Route::resource('product','ProductController');
Route::resource('stock','StockController');
Route::resource('fridge','FridgeController');
Route::post('assign-fridge','FridgeController@assign');
Route::resource('order', 'OrderController');
Route::resource('undeliver', 'UndeliveredOrderController');
Route::resource('history', 'TransactionHistoryOrderController');
Route::resource('sales', 'SalesReportController');
Route::resource('loss', 'LossReportController');
Route::resource('emergency', 'EmergencyController');
Route::resource('notification', 'NotificationController');
Route::resource('order_replacement', 'OrderReplacementController');
Route::resource('order_damage', 'ProductDamagesController');
Route::resource('ads', 'AdController');
Route::resource('quota', 'QuotaController');
Route::get('client/{id}/stores', 'ClientController@storeList');
Route::get('client/{id}/stores/json', 'ClientController@storeListJson');
Route::post('replacement/set-deliver', 'OrderReplacementController@setDeliveryDate');

Route::post('update/replacement', 'OrderReplacementController@updateProducts');

//admin dashboard
Route::get('display_order_to_deliver_count', 'HomeController@display_order_to_deliver_count')->name('display_order_to_deliver_count');
Route::get('display_order_to_approve_count', 'HomeController@display_order_to_approve_count')->name('display_order_to_approve_count');
Route::get('display_out_of_stocks_product_count', 'HomeController@display_out_of_stocks_product_count')->name('display_out_of_stocks_product_count');
Route::get('display_product_of_the_month', 'HomeController@display_product_of_the_month')->name('display_product_of_the_month');
Route::get('display_weekly_sales_data', 'HomeController@display_weekly_sales_data')->name('display_weekly_sales_data');
Route::get('display_sales_data', 'HomeController@display_sales_data')->name('display_sales_data');
Route::get('display_loss_data', 'HomeController@display_loss_data')->name('display_loss_data');
Route::get('low-stocks', 'HomeController@lowStocks')->name('low-stocks');


/*---------------------------------------------------------------------------------------
*
*									STAFF ROUTES
*
*-------------------------------------------------------------------------------------*/
Route::resource('staff','StaffController');
Route::resource('main','StaffDashboardController');
Route::resource('product_list','StaffProductController');
Route::post('emergency', 'StaffDashboardController@emergency');
Route::get('get-sizes/{id}', 'ProductController@getSizes');


/*---------------------------------------------------------------------------------------
*
*									CLIENT ROUTES
*
*-------------------------------------------------------------------------------------*/
Route::resource('client','ClientController');
Route::resource('client_list','ClientListController');
Route::get('shop', 'ShopController@shop')->name('shop');
Route::post('save_to_cart', 'ShopController@save_to_cart')->name('save_to_cart');
Route::resource('store','StoreController');
Route::get('save_cart', 'CartController@save_cart')->name('save_cart');
Route::resource('cart', 'CartController');
Route::resource('transaction', 'TransactionController');
Route::resource('transaction_history', 'TransactionHistoryController');
Route::get('info', 'TransactionController@info')->name('info');

//client dashboard
Route::get('display_order_to_receive_count_for_client', 'HomeController@display_order_to_receive_count_for_client')->name('display_order_to_receive_count_for_client');
Route::get('display_order_to_approve_count_for_client', 'HomeController@display_order_to_approve_count_for_client')->name('display_order_to_approve_count_for_client');
Route::get('display_3_best_product_of_the_month', 'HomeController@display_3_best_product_of_the_month')->name('display_3_best_product_of_the_month');