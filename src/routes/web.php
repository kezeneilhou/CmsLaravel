<?php
use bm\cms\Controllers\PostController;
use bm\cms\Controllers\QuillUploadController;

Route::middleware('auth')->group(function () {
    Route::resource('post', PostController::class);
    // Route::get('addEditPost/{postId?}', AddEditPost::class);
    Route::post('/upload-image', [QuillUploadController::class, 'uploadImage'])->name('quill.upload');
    Route::post('/upload-file', [QuillUploadController::class, 'uploadFile'])->name('quill.upload.file');
});