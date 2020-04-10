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
        Route::post('/claim/uploadSortedFile/{id}', 'ClaimController@uploadSortedFile')->name('uploadSortedFile');
        
        Route::get('/claim/barcode/{barcode}', 'ClaimController@barcode_link');

        Route::post('/search', 'ClaimController@searchFullText')->name('search');
        Route::post('/search2', 'ClaimController@searchFullText2')->name('search2');
        Route::post('/template', 'ClaimController@template')->name('template');
        Route::post('/requestLetter','ClaimController@requestLetter')->name('requestLetter');
        Route::post('/exportLetter','ClaimController@exportLetter')->name('exportLetter');
        Route::post('/exportLetterPDF','ClaimController@exportLetterPDF')->name('exportLetterPDF');
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

        Route::resource('message', 'SendMessageController');
        Route::post('message/destroyMany', 'SendMessageController@destroyMany')->name('message.destroyMany');
        Route::get('/sent','SendMessageController@sent')->name('message.sent');
        Route::get('/trash','SendMessageController@trash')->name('message.trash');
        Route::post('message/important', 'SendMessageController@important')->name('message.important');


        //ajax
        Route::get('/dataAjaxHBSClaim', 'AjaxCommonController@dataAjaxHBSClaim')->name('dataAjaxHBSClaim');
        Route::post('/loadInfoAjaxHBSClaim', 'AjaxCommonController@loadInfoAjaxHBSClaim')->name('loadInfoAjaxHBSClaim');

        Route::get('/dataAjaxHBSClaimRB', 'AjaxCommonController@dataAjaxHBSClaimRB')->name('dataAjaxHBSClaimRB');
        Route::post('/loadInfoAjaxHBSClaimRB', 'AjaxCommonController@loadInfoAjaxHBSClaimRB')->name('loadInfoAjaxHBSClaimRB');
        Route::post('/checkRoomBoard', 'AjaxCommonController@checkRoomBoard')->name('checkRoomBoard');

        Route::resource('roomAndBoards', 'RoomAndBoardController');

        Route::get('users/',  'UserController@edit')->name('MyProfile');
        Route::post('users/update','UserController@update');

        Route::get('getPaymentHistory/{cl_no}',  'AjaxCommonController@getPaymentHistory')->name('getPaymentHistory');
        Route::get('getPaymentHistoryCPS/{cl_no}',  'AjaxCommonController@getPaymentHistoryCPS')->name('getPaymentHistoryCPS');
        Route::get('getBalanceCPS/{mem_ref_no}/{cl_no}',  'AjaxCommonController@getBalanceCPS')->name('getBalanceCPS');
        

        Route::resource('claimWordSheets', 'ClaimWordSheetController');
        Route::get('claimWordSheets/pdf/{claimWordSheet}',  'ClaimWordSheetController@pdf')->name('claimWordSheets.pdf');
        Route::get('claimWordSheets/summary/{claimWordSheet}',  'ClaimWordSheetController@summary')->name('claimWordSheets.summary');
        Route::get('claimWordSheets/sendSortedFile/{claimWordSheet}',  'ClaimWordSheetController@sendSortedFile')->name('claimWordSheets.sendSortedFile');
        
        //setting
        Route::get('setting/',  'SettingController@index')->name('setting.index')->middleware(['role:Admin']);
        Route::post('setting/update','SettingController@update')->middleware(['role:Admin']);
        Route::post('setting/notifiAllUser','SettingController@notifiAllUser')->middleware(['role:Admin']);
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


// Push Subscriptions
Route::post('check_subscriptions', 'PushController@check_subscriptions');
Route::post('subscriptions', 'PushController@update');
Route::post('subscriptions/delete', 'PushController@destroy');



