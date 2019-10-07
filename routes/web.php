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
    return redirect('login');
});

Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['auth']], function(){
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('form_claim', 'formClaimController');
        Route::post('/annotate', 'formClaimController@annotateImage');
        Route::resource('list_reason_inject', 'ListReasonInjectController');
        Route::resource('product', 'ProductController');

        Route::get('importExportView', 'CSVController@importExportView');
        Route::post('import', 'CSVController@import')->name('import');
    });
});