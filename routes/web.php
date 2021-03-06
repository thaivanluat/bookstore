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




Route::get('/user/login', 'UserController@getLogin');
Route::post('/user/login', 'UserController@postLogin');


Route::group(['middleware' => 'check.user'], function () {
    Route::get('/', function() {
        return redirect('/home/index');
    });
    
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
    Route::get('/book/detail/{id}', 'BookController@detail');
    Route::post('/book/edit', 'BookController@edit');
    Route::post('/book/delete', 'BookController@delete');
    Route::post('/book/add', 'BookController@add');
    
    Route::post('/bookedition/edit', 'BookEditionController@edit');
    Route::post('/bookedition/delete', 'BookEditionController@delete');
    Route::post('/bookedition/add', 'BookEditionController@add');
    Route::get('/bookedition/index', 'BookEditionController@index');
    
    Route::get('/customer/index', 'CustomerController@index');
    Route::post('/customer/edit', 'CustomerController@edit');
    Route::post('/customer/delete', 'CustomerController@delete');
    Route::post('/customer/add', 'CustomerController@add');
    Route::get('/customer/detail/{id}', 'CustomerController@detail');
    Route::get('/customer/birthday', 'CustomerController@birthday');
    Route::post('/customer/birthday', 'CustomerController@birthdaySearch');
    
    Route::get('/inputreceipt/index', 'InputReceiptController@index');
    Route::get('/inputreceipt/detail/{id}', 'InputReceiptController@detail');
    Route::get('/inputreceipt/add', 'InputReceiptController@addView');
    Route::post('/inputreceipt/getBookEditionOptionlist', 'InputReceiptController@getBookEditionOptionList');
    Route::post('/inputreceipt/add', 'InputReceiptController@add');
    Route::post('/inputreceipt/delete', 'InputReceiptController@delete');

    Route::get('/inventory/index', 'InventoryController@index');
    Route::get('/inventory/detail/{id}', 'InventoryController@detail');
    Route::get('/inventory/add', 'InventoryController@addView');
    Route::post('/inventory/getBookEditionOptionlist', 'InventoryController@getBookEditionOptionList');
    Route::post('/inventory/add', 'InventoryController@add');
    Route::post('/inventory/delete', 'InventoryController@delete');
    
    Route::get('/invoice/index', 'InvoiceController@index');
    Route::get('/invoice/detail/{id}', 'InvoiceController@detail');
    Route::get('/invoice/add', 'InvoiceController@addView');
    Route::post('/invoice/delete', 'InvoiceController@delete');
    Route::post('/invoice/getBookEditionOptionlist', 'InvoiceController@getBookEditionOptionList');
    Route::post('/invoice/add', 'InvoiceController@add');
    Route::post('/invoice/searchCustomer', 'InvoiceController@searchCustomer');
    
    Route::get('/receipt/index', 'ReceiptController@index');
    Route::post('/receipt/delete', 'ReceiptController@delete');
    Route::post('/receipt/add', 'ReceiptController@add');

    Route::get('/user/profile', 'UserController@profile');
    Route::post('/user/profile', 'UserController@editProfile');
    Route::get('/user/change-password', 'UserController@changePassword');
    Route::post('/user/change-password', 'UserController@postChangePassword');
    Route::get('/user/logout', 'UserController@logout');

    Route::group(['middleware' => 'check.manager'], function () {
        Route::get('/report/{type}', 'ReportController@index');
        Route::post('create-debt-report', 'ReportController@createDebtReport');
        Route::post('create-inventory-report', 'ReportController@createInventoryReport');
        Route::post('create-staff-report', 'ReportController@createStaffReport');

        Route::group(['middleware' => 'check.admin'], function () {
            Route::get('/user/index', 'UserController@index');
            Route::post('/user/edit', 'UserController@edit');
            Route::post('/user/delete', 'UserController@delete');
            Route::post('/user/add', 'UserController@add');

            Route::get('/policy', 'PolicyController@index');
            Route::post('/policy', 'PolicyController@edit');
        });
    });
});