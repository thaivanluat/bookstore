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
Route::get('/author/detail/{id}', 'AuthorController@detail');
Route::post('/author/edit', 'AuthorController@edit');
Route::post('/author/delete', 'AuthorController@delete');
Route::post('/author/add', 'AuthorController@add');

Route::get('/bookcategory/index', 'BookCategoryController@index');
Route::get('/bookcategory/detail/{id}', 'BookCategoryController@detail');
Route::post('/bookcategory/edit', 'BookCategoryController@edit');
Route::post('/bookcategory/delete', 'BookCategoryController@delete');
Route::post('/bookcategory/add', 'BookCategoryController@add');

Route::get('/book/index', 'BookController@index');
Route::post('/book/edit', 'BookController@edit');
Route::post('/book/delete', 'BookController@delete');
Route::post('/book/add', 'BookController@add');

Route::get('/customer/index', 'CustomerController@index');
Route::post('/customer/edit', 'CustomerController@edit');
Route::post('/customer/delete', 'CustomerController@delete');
Route::post('/customer/add', 'CustomerController@add');

Route::get('/book/index', 'BookController@index');
Route::get('/bookedition/index', 'BookEditionController@index');
Route::get('/customer/index', 'CustomerController@index');
Route::get('/inputreceipt/index', 'InputReceiptController@index');
Route::get('/invoice/index', 'InvoiceController@index');
Route::get('/receipt/index', 'ReceiptController@index');
Route::get('/report/{type}', 'ReportController@index');

Route::get('/test', 'AuthorController@test');