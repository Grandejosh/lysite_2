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

Route::middleware(['auth.device', 'auth:sanctum', 'verified'])->prefix('academic')->group(function () {
    Route::middleware(['single-session'])->group(function () {
        Route::group(['prefix' => 'courses'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_cursos'])->get('list', 'CoursesController@index')->name('academic_courses');
            Route::middleware(['middleware' => 'role_or_permission:academico_cursos_nuevo'])->get('create', 'CoursesController@create')->name('academic_courses_create');
            Route::middleware(['middleware' => 'role_or_permission:academico_cursos_editar'])->get('edit/{id}', 'CoursesController@edit')->name('academic_courses_editar');
            Route::middleware(['middleware' => 'role_or_permission:academico_secciones'])->get('section_list/{course_id}', 'SectionsController@index')->name('academic_sections');
            Route::middleware(['middleware' => 'role_or_permission:academico_secciones_nuevo'])->get('section_create/{course_id}', 'SectionsController@create')->name('academic_sections_create');
            Route::middleware(['middleware' => 'role_or_permission:academico_secciones_editar'])->get('section_edit/{course_id}/{section_id}', 'SectionsController@edit')->name('academic_sections_editar');

            Route::group(['prefix' => 'section/contents'], function () {
                Route::middleware(['middleware' => 'role_or_permission:academico_contenido'])->get('list/{course_id}/{section_id}', 'ContentsController@index')->name('academico_contenido');
                Route::middleware(['middleware' => 'role_or_permission:academico_contenido_nuevo'])->get('create/{section_id}', 'ContentsController@create')->name('academico_contenido_create');
                Route::middleware(['middleware' => 'role_or_permission:academico_contenido_editar'])->get('edit/{section_id}/{content_id}', 'ContentsController@edit')->name('academico_contenido_editar');
                Route::middleware(['middleware' => 'role_or_permission:academico_contenido_enlazar'])->get('link/{section_id}/{content_id}', 'ContentsController@link')->name('academico_contenido_enlazar');
            });
        });
        Route::group(['prefix' => 'content_types'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_tipo_contenido'])->get('list', 'ContentTypesController@index')->name('academic_content_types');
            Route::middleware(['middleware' => 'role_or_permission:academico_tipo_contenido_nuevo'])->get('create', 'ContentTypesController@create')->name('academic_content_types_create');
            Route::middleware(['middleware' => 'role_or_permission:academico_tipo_contenido_editar'])->get('edit/{id}', 'ContentTypesController@edit')->name('academic_content_types_editar');
        });
        Route::group(['prefix' => 'students'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos'])->get('list', 'StudentsController@index')->name('academic_students');
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_nuevo'])->get('create', 'StudentsController@create')->name('academic_students_create');
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_editar'])->get('edit/{id}', 'StudentsController@edit')->name('academic_students_edit');
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_mi_curso'])->get('my_course/{id}', 'StudentsController@my_course')->name('academic_students_my_course');
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_mi_curso'])->get('take_lesson/{course_id}/{section_id}/{content_id}', 'StudentsController@take_lesson')->name('academic_students_take_lesson');
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_mi_curso'])->get('discussions_ask/{course_id}/{section_id}/{content_id}', 'StudentsController@discussions_ask')->name('academic_students_discussions_ask'); //vista para hacer preguntas
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_mi_curso'])->get('discussion/{course_id}/{section_id}/{content_id}/{question_id}', 'StudentsController@discussion')->name('academic_students_discussion'); //vista para responder
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_mi_curso'])->get('discussions_ask_edit/{course_id}/{section_id}/{content_id}/{question_id}', 'StudentsController@discussions_ask_edit')->name('academic_students_discussions_ask_edit');
        });

        Route::group(['prefix' => 'instructor/courses/assign'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_cursos_instructor'])->get('list', 'CoursesController@instructorCourses')->name('academic_instructor_courses_list');
            Route::middleware(['middleware' => 'role_or_permission:academico_cursos_edit_instructor'])->get('edit/{course_id}', 'CoursesController@instructorCoursesEdit')->name('academic_instructor_courses_Edit');
        });

        Route::group(['prefix' => 'instructor/courses'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_cursos_instructor'])->get('list', 'CoursesController@dashinstructorCourses')->name('academic_dash_instructor_courses_list');
            Route::middleware(['middleware' => 'role_or_permission:academico_cursos_edit_instructor'])->get('edit/{id}', 'CoursesController@dashinstructorCoursesEdit')->name('academic_dash_instructor_courses_edit');
        });

        Route::group(['prefix' => 'instructors'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_instructors'])->get('list', 'InstructorsController@listInstructors')->name('academic_instructors_list');
            Route::middleware(['middleware' => 'role_or_permission:academico_instructors_nuevo'])->get('create', 'InstructorsController@createInstructors')->name('academic_instructors_create');
            Route::middleware(['middleware' => 'role_or_permission:academico_instructors_editar'])->get('edit/{id}', 'InstructorsController@editInstructors')->name('academic_instructors_edit');
        });

        Route::group(['prefix' => 'assign/courses'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_instructores_asignar'])->get('instructors/{course_id}', 'InstructorsController@index')->name('academic_instructor_assign');
            Route::middleware(['middleware' => 'role_or_permission:academico_estudiantes_asignar'])->get('students/{course_id}', 'StudentsController@index2')->name('academic_student_assign');
            Route::middleware(['middleware' => 'role_or_permission:academico_estudiantes_asignar'])->get('student/{course_id}/{id}', 'StudentsController@edit2')->name('academic_student_assign_edit');
        });

        Route::group(['prefix' => 'downloads/students'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_alumnos_mi_curso'])->get('file/{content_id}/{studentd_id}', 'DownloadsController@downloadFile')->name('download_file');
        });

        Route::group(['prefix' => 'reports'], function () {
            Route::middleware(['middleware' => 'role_or_permission:academico_reporte_total_alumnos'])->get('students_total', 'ReportStudentController@studentTotal')->name('academic_reports_students_total');
        });

        // Route::middleware(['middleware' => 'role_or_permission:academico_cursos_instructor'])->get('openai', 'StudentsController@openai')->name('openai');
    });
});
