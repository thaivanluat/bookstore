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

Route::get('/home/index', 'HomeController@index');

Route::get('/author/index', 'AuthorController@index');
Route::post('/author/edit', 'AuthorController@edit');
Route::post('/author/delete', 'AuthorController@delete');
Route::post('/author/add', 'AuthorController@add');

Route::get('/bookcategory/index', 'BookCategoryController@index');
Route::get('/book/index', 'BookController@index');
Route::get('/bookedition/index', 'BookEditionController@index');
Route::get('/customer/index', 'CustomerController@index');
Route::get('/inputreceipt/index', 'InputReceiptController@index');
Route::get('/invoice/index', 'InvoiceController@index');
Route::get('/receipt/index', 'ReceiptController@index');
Route::get('/report/{type}', 'ReportController@index');

Route::get('/test', 'AuthorController@test');