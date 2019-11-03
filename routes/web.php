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
Route::get('/test', function () {
    return view('pusherManagement/showNotification');
});


Route::post('/postMessage', 'SendMessageController@sendMessage')->name('postMessage');

Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['auth']], function(){
        Route::get('/home', 'HomeController@index')->name('home');
        
        Route::get('/chats', 'chatController@index')->name('chat.index');
        Route::resource('claim', 'ClaimController');
        Route::post('/search', 'ClaimController@searchFullText')->name('search');
        Route::post('/search2', 'ClaimController@searchFullText2')->name('search2');
        Route::post('/template', 'ClaimController@template')->name('template');
        Route::post('/exportLetter','ClaimController@exportLetter')->name('exportLetter');

        Route::resource('reason_reject', 'ReasonRejectController');
        Route::resource('product', 'ProductController');
        Route::resource('term', 'TermController');
        Route::resource('letter_template', 'LetterTemplateController');

        Route::get('importExportView', 'CSVController@importExportView')->middleware(['role:Admin']);
        Route::post('import', 'CSVController@import')->name('import')->middleware(['role:Admin']);
        Route::resource('admins', 'AdminController')->middleware(['role:Admin']);
        Route::resource('role', 'RoleController')->middleware(['role:Admin']);
        Route::resource('permission', 'PermissionController')->middleware(['role:Admin']);

        //ajax
        Route::get('/dataAjaxHBSClaim', 'ClaimController@dataAjaxHBSClaim')->name('dataAjaxHBSClaim');
        Route::post('/loadInfoAjaxHBSClaim', 'ClaimController@loadInfoAjaxHBSClaim')->name('loadInfoAjaxHBSClaim');
        
    });
});