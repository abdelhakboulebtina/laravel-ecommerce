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

Route::view('/','welcome');
Route::get('/boutique','ProductController@index')->name('products.index');
Route::get('/search','ProductController@search')->name('products.search');
Route::get('/boutique/{slug}','ProductController@show')->name('products.show');
route::group(['middleware'=>['auth']],function(){
    Route::get('/panier','CartController@index')->name('cart.index');
    Route::patch('/panier/{rowid}','CartController@update')->name('Cart.update');
    Route::delete('/panier/{rowid}','CartController@destroy')->name('Cart.destroy');
    Route::post('/panier/ajouter','CartController@store')->name('panier.store');
});
route::group(['middleware'=>['auth']],function(){
Route::get('/paiement','CheckoutController@index')->name('checkout.index');
Route::post('/paiement','CheckoutController@store')->name('checkout.store');
Route::get('/merci','CheckoutController@thankyou')->name('checkout.thankyou');
});
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
