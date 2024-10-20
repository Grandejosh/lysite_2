<?php

use App\Models\User;
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

Route::prefix('chat')->group(function () {
    Route::post('private/messages', 'ChatController@showChatMessates')->name('get_private_messages');
    Route::post('private/send/message', 'ChatController@sendMessage')->name('get_private_send_message');
    Route::post('private/change/message', 'ChatController@isSeenChecked')->name('get_private_change_message');
});
