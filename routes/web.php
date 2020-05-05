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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/products', 'ProductsController');
Route::get('/getProducts', 'ProductsController@getProducts')->name('getProducts');
Route::get('/deleteProduct/{id}', 'ProductsController@destroy')->name('deleteProduct');
Route::get('/getProduct/{id}', 'ProductsController@edit')->name('getProduct');
Route::post('/updateProduct', 'ProductsController@update')->name('updateProduct');


//clients
Route::resource('/clients', 'ClientsController');
Route::get('/getClients', 'ClientsController@getClients')->name('getClients');
Route::get('/deleteClient/{id}', 'ClientsController@destroy')->name('deleteClient');
Route::get('/getClient/{id}', 'ClientsController@edit')->name('getClient');
Route::post('/updateClient', 'ClientsController@update')->name('updateClient');

//documents
Route::resource('/documents', 'DocumentsController');
Route::get('/getDocuments', 'DocumentsController@getDocuments')->name('getDocuments');
Route::get('/deleteDocument/{id}', 'DocumentsController@destroy')->name('deleteDocument');
Route::get('/getDocument/{id}', 'DocumentsController@edit')->name('getDocument');
Route::post('/updateDocument', 'DocumentsController@update')->name('updateDocument');
