<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use App\Mail\EmailConfirmation;

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

Route::get('/', 'ProductController@showAllProducts');
Route::get('/sonicsalescms', 'CustomAuthController@showAdminPage');
Route::get('/sonicsalescmsreg', 'CustomAuthController@showRegisterAdminPage');
Route::get('/logout', 'CustomAuthController@logout');
Route::get('/dashboard', 'AdminController@dashboard');
Route::get('/item/{id}', 'AdminController@getItem');
Route::get('/orders', 'AdminController@getOrders');
Route::get('/products', 'AdminController@getAllProducts');
Route::get('/inventory', 'AdminController@inventory');
Route::get('/cart', 'ProductController@cart');
Route::get('/check-order/{id}', 'AdminController@getCustomerOrder');
Route::get('/confirm-order/{id}', 'AdminController@confirmOrder');
Route::get('/delivery-fee/{id}', 'ProductController@getDeliveryFee');
Route::get('/refresh-captcha', 'ProductController@refreshCaptcha');
Route::get('/import', 'ImportExcelController@index');

Route::post('/login', 'CustomAuthController@login');
Route::post('/register', 'CustomAuthController@register');
Route::get('/search-item', 'AdminController@searchItem');
Route::post('/update/item/{id}', 'AdminController@updateItem');
Route::post('/addcart/{id}', 'ProductController@addToCart');
Route::post('/submit-order', 'ProductController@submitOrder');
Route::post('/continue-shopping', 'ProductController@continueShopping');
Route::post('/categorize-by', 'AdminController@categorize');
Route::post('/import-stl', 'ImportExcelController@ImportExcel');
Route::post('/select-audit-date', 'ImportExcelController@filterAuditByDate');

Route::delete('remove-from-cart', 'ProductController@remove');