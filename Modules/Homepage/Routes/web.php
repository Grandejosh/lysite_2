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


Route::middleware(['auth.device', 'auth:sanctum', 'verified'])->prefix('homepage')->group(function () {
    Route::middleware(['single-session'])->group(function () {
        Route::group(['prefix' => 'settings'], function () {

            Route::middleware(['middleware' => 'role_or_permission:configuraciones_modulos'])->get('list', 'HomepageController@index')->name('homepage_settings');

            Route::group(['prefix' => 'instructors'], function () {
                Route::middleware(['middleware' => 'role_or_permission:configuraciones_modulos'])->get('list', 'HomepageController@instructors')->name('homepage_instructors');
                Route::middleware(['middleware' => 'role_or_permission:configuraciones_modulos'])->get('create', 'HomepageController@create_instructor')->name('homepage_instructors_create');
                Route::middleware(['middleware' => 'role_or_permission:configuraciones_modulos'])->get('edit/{id}', 'HomepageController@edit_instructor')->name('homepage_instructors_edit');
            });

            Route::group(['prefix' => 'histories'], function () {
                Route::middleware(['middleware' => 'role_or_permission:configuraciones_modulos'])->get('list', 'HomepageController@histories')->name('homepage_histories');
                Route::middleware(['middleware' => 'role_or_permission:configuraciones_modulos'])->get('create', 'HomepageController@create_history')->name('homepage_histories_create');
                Route::middleware(['middleware' => 'role_or_permission:configuraciones_modulos'])->get('edit/{id}', 'HomepageController@edit_history')->name('homepage_histories_edit');
            });
        });
    });
});
