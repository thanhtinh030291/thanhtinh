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
        Route::get('/claim/barcode/{barcode}', 'ClaimController@barcode_link');

        Route::post('/search', 'ClaimController@searchFullText')->name('search');
        Route::post('/search2', 'ClaimController@searchFullText2')->name('search2');
        Route::post('/template', 'ClaimController@template')->name('template');
        Route::post('/requestLetter','ClaimController@requestLetter')->name('requestLetter');
        Route::post('/exportLetter','ClaimController@exportLetter')->name('exportLetter');
        Route::post('/previewLetter','ClaimController@previewLetter')->name('previewLetter');
        Route::post('/changeStatus','ClaimController@changeStatus')->name('changeStatus');
        Route::post('/waitCheck','ClaimController@waitCheck')->name('waitCheck');
        Route::post('/sendEtalk','ClaimController@sendEtalk')->name('sendEtalk');
        
        Route::post('/addNote','ClaimController@addNote')->name('addNote');
        Route::get('/test/{claim_id}', 'ClaimController@test')->name('test.index');

        Route::resource('reason_reject', 'ReasonRejectController');
        Route::resource('product', 'ProductController');
        Route::resource('term', 'TermController');
        Route::resource('letter_template', 'LetterTemplateController');

        Route::get('importExportView', 'CSVController@importExportView')->middleware(['role:Admin']);
        Route::post('import', 'CSVController@import')->name('import')->middleware(['role:Admin']);
        Route::resource('admins', 'AdminController')->middleware(['role:Admin']);
        Route::resource('role', 'PermissionController')->middleware(['role:Admin']);
        Route::resource('permiss', 'PermissController')->middleware(['role:Admin']);

        Route::resource('roleChangeStatuses', 'RoleChangeStatusController')->middleware(['role:Admin']);
        Route::resource('levelRoleStatuses', 'LevelRoleStatusController')->middleware(['role:Admin']);
        Route::resource('transactionRoleStatuses', 'TransactionRoleStatusController')->middleware(['role:Admin']);

        //ajax
        Route::get('/dataAjaxHBSClaim', 'AjaxCommonController@dataAjaxHBSClaim')->name('dataAjaxHBSClaim');
        Route::post('/loadInfoAjaxHBSClaim', 'AjaxCommonController@loadInfoAjaxHBSClaim')->name('loadInfoAjaxHBSClaim');

        Route::get('/dataAjaxHBSClaimRB', 'AjaxCommonController@dataAjaxHBSClaimRB')->name('dataAjaxHBSClaimRB');
        Route::post('/loadInfoAjaxHBSClaimRB', 'AjaxCommonController@loadInfoAjaxHBSClaimRB')->name('loadInfoAjaxHBSClaimRB');
        Route::post('/checkRoomBoard', 'AjaxCommonController@checkRoomBoard')->name('checkRoomBoard');

        Route::resource('roomAndBoards', 'RoomAndBoardController');

        Route::get('users/{user}',  'UserController@edit');
        Route::patch('users/{user}/update','UserController@update');
        
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






Route::resource('transactionRoleStatuses', 'TransactionRoleStatusController');