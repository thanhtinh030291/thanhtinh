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
        Route::post('/read_all_messages', 'SendMessageController@readAll')->name('readAll');

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
        Route::get('/dataAjaxHBSClaim', 'AjaxCommonController@dataAjaxHBSClaim')->name('dataAjaxHBSClaim');
        Route::post('/loadInfoAjaxHBSClaim', 'AjaxCommonController@loadInfoAjaxHBSClaim')->name('loadInfoAjaxHBSClaim');

        Route::resource('roomAndBoards', 'RoomAndBoardController');
        
    });
});

Auth::routes();

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');


