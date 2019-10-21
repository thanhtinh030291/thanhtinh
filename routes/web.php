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
        Route::post('/search', 'formClaimController@searchFullText')->name('search');
        Route::post('/search2', 'formClaimController@searchFullText2')->name('search2');

        Route::resource('list_reason_inject', 'ListReasonInjectController');

        Route::resource('product', 'ProductController');

        Route::get('importExportView', 'CSVController@importExportView')->middleware(['role:super-admin']);
        Route::post('import', 'CSVController@import')->name('import')->middleware(['role:super-admin']);
        Route::resource('admins', 'AdminController')->middleware(['role:super-admin']);
        Route::resource('role', 'RoleController')->middleware(['role:super-admin']);
    });
});