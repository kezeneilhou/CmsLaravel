# Laravel Content Management System

This package allows you to dynamically show your Laravel Livewire 3 components inside tailwind modals.

 **Warning:** This package is not backward compatible with Livewire 2.

## Documentation

- [Requirements](#requirements)
- [Installation](#installation)

## Installation

Require the package:

```console
composer require kezeneilhou/cms-laravel
```

```console
php artisan vendor:publish
```

Import the Quill CDN in your layout view.

Add the routes below to your web.php:
Route::resource('post', PostController::class);
Route::post('/upload-image', [QuillUploadController::class, 'uploadImage'])->name('quill.upload');
Route::post('/upload-file', [QuillUploadController::class, 'uploadFile'])->name('quill.upload.file');

Vendor publish will publish the Post and Category Models & Controllers.
After vendor publish, fix the namespace for the Models and Controllers.
