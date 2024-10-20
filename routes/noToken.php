<?php

use Modules\Investigation\Http\Controllers\ThesisController;

Route::post('thesis/upload/image', [ThesisController::class, 'uploadImage'])->name('investigation_thesis_upload_image');
