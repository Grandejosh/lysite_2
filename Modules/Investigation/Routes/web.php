<?php

use \Firebase\JWT\JWT;
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

Route::middleware(['auth.device', 'auth:sanctum', 'verified'])->prefix('investigation')->group(function () {
    Route::middleware(['single-session'])->group(function () {
        Route::middleware(['middleware' => 'role_or_permission:investigacion'])->get('dashboard', 'InvestigationController@index')->name('investigation_dashboard');

        Route::group(['prefix' => 'parts'], function () {
            Route::middleware(['middleware' => 'role_or_permission:investigacion_partes'])->get('list/{id}', 'PartsController@index')->name('investigation_parts');
        });

        Route::group(['prefix' => 'universities'], function () {
            Route::middleware(['middleware' => 'role_or_permission:universities_list'])->get('list', 'UniversitiesController@list')->name('Investigation_universities_list');
            Route::middleware(['middleware' => 'role_or_permission:universities_edit'])->get('edit/{id}', 'UniversitiesController@edit')->name('Investigation_universities_edit');
            Route::middleware(['middleware' => 'role_or_permission:universities_create'])->get('create', 'UniversitiesController@create')->name('Investigation_universities_create');
            Route::middleware(['middleware' => 'role_or_permission:universities_list'])->get('schools/{id}', 'UniversitiesController@schools')->name('Investigation_universities_schools');
            Route::middleware(['middleware' => 'role_or_permission:universities_create'])->get('schools/create/{id}', 'UniversitiesController@schools_create')->name('Investigation_universities_schools_create');
            Route::middleware(['middleware' => 'role_or_permission:universities_edit'])->get('schools/edit/{university_id}/{school_id}', 'UniversitiesController@schools_edit')->name('Investigation_universities_schools_edit');
        });

        Route::group(['prefix' => 'thesis_formats'], function () {
            Route::middleware(['middleware' => 'role_or_permission:investigacion_partes'])->get('list/{school_id}', 'ThesisFormatsController@list')->name('Investigation_thesis_formats_list');
            Route::middleware(['middleware' => 'role_or_permission:investigacion_partes'])->get('all/formats', 'ThesisFormatsController@list_complete')->name('Investigation_thesis_formats_list_complete');
            Route::middleware(['middleware' => 'role_or_permission:investigacion_partes_nuevo'])->get('create/{school_id}', 'ThesisFormatsController@create')->name('Investigation_thesis_formats_create');
            Route::middleware(['middleware' => 'role_or_permission:investigacion_partes_editar'])->get('edit/{school_id}/{thesis_format_id}', 'ThesisFormatsController@edit')->name('Investigation_thesis_formats_edit');
            Route::middleware(['middleware' => 'role_or_permission:investigacion_partes_nuevo'])->get('create/format/new', 'ThesisFormatsController@create_complete')->name('Investigation_thesis_formats_create_complete');
            Route::middleware(['middleware' => 'role_or_permission:investigacion_partes_nuevo'])->get('edit/format/edit/{thesis_format_id}', 'ThesisFormatsController@edit_complete')->name('Investigation_thesis_formats_edit_complete');
        });

        Route::group(['prefix' => 'thesis'], function () {
            Route::get('create', 'ThesisController@create')->name('investigation_thesis_create');
            Route::get('edit/{id}', 'ThesisController@edit')->name('investigation_thesis_edit');

            Route::get('parts/{thesis_id}/{sub_part?}', 'ThesisController@parts')->name('investigation_thesis_parts');
            Route::get('parts_test/{thesis_id}/{sub_part?}', 'ThesisController@parts_test')->name('investigation_thesis_parts_test');
            Route::get('export/pdf/{thesis_id}', 'ThesisController@exportPDF')->name('investigation_thesis_export_pdf');
            Route::get('export/word/{thesis_id}', 'ThesisController@exportWORD')->name('investigation_thesis_export_word');
            Route::get('export_word/{thesis_id}', 'ThesisController@exportWORDView')->name('investigation_thesis_export_word_btn');
            Route::get('permissionsThesisAllowed', 'ThesisController@permissions_thesis_allowed')->name('investigation_thesis_permissions_thesis_allowed');
            Route::middleware(['middleware' => 'role_or_permission:investigacion_tesis'])->get('all', 'ThesisController@allthesis')->name('investigation_thesis_all');
            Route::middleware(['middleware' => 'role_or_permission:investigacion_tesis'])->get('check/{id}/{part_id?}', 'ThesisController@thesischeck')->name('investigation_thesis_check');
            Route::post('ckeditor/upload_image', 'ThesisController@uploadImage')->name('investigation_thesis_upload_image');
            Route::get('export/complete/{thesis_id}', 'ThesisController@completethesis')->name('investigation_thesis_export_word_ckeditor');
            Route::post('export/completedatos', 'ThesisController@completethesisDatos')->name('investigation_thesis_export_word_datos');
            Route::post('comentary/thesis/selecction', 'ThesisStudentPartCommentaryController@createComenntarySelection')->name('investigation_thesis_selection_comments');
            Route::post('references/thesis', 'GetReferencesController@citar')->name('investigation_thesis_references');
            Route::post('helpkeywords/thesis', 'GrammarCorrectionController@grammarCorrection')->name('investigation_thesis_grammar_correction');
            Route::post('recommendation/thesis', 'GetArticlesRecommendationController@getArticles')->name('investigation_thesis_recommendation');
            Route::get('comentary/thesis/data/{id}', 'ThesisStudentPartCommentaryController@getCommetsByThesis')->name('investigation_thesis_get_comments');
            Route::get('comentary/thesis/destroy/{id}/{tid}', 'ThesisStudentPartCommentaryController@destroyCommetsById')->name('investigation_thesis_destroy_comments');

            Route::post('index_export', 'ThesisController@index_export')->name('investigation_index_export');
        });
    });

    Route::post('subindex/store', 'InveThesisStudentIndexController@store')->name('investigation_thesis_student_index_store');
});

Route::get('thesis_editor', function () {
    return view('investigation::thesis.thesis_editor_sample');
})->name('thesis_editor_sample');

Route::get('thesis_cadenas', function () {
    $cadena = 'The substring to search for https://web.facebook.com/?_rdc=1&_rdrin the will always return true';
    $reg_exUrl = "/.[http|https|ftp|ftps]*\:\/\/.[^$|\s]*/";
    $reg_exUrl2 = "/www.[^$|\s]*/";
    $cadena = preg_replace($reg_exUrl, "<a href='$0' target='_blank'>$0</a>", $cadena);
    return  preg_replace($reg_exUrl2, "<a href='http://$0' target='_blank'>$0</a>", $cadena);
    //dd($cadena);
})->name('thesis_cadenas');


Route::get('ckeditor_token', function () {

    $secretKey = env('CKEDITOR_SECRET_KEY');

    $payload = array(
        'aud' => env('CKEDITOR_ENVIRONMENT_ID'),
        'iat' => time()
    );

    $jwt = JWT::encode($payload, $secretKey, 'HS256');

    // Here we are printing the token to the console. In a real usage scenario
    // it should be returned in an HTTP response of the token endpoint.
    echo $jwt;
})->name('ckeditor_token_generate');
