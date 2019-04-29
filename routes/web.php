<?php

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

Route::get('/add', 'AddressController@addAddress');
Route::get('/view', 'AddressController@viewAddress');
Route::post('/saveaddress', 'AddressController@saveAddress');
Route::get('/delete/{id}', 'AddressController@deleteAddress')->where('id', '[0-9]+');
