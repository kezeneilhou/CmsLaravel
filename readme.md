# Laravel Content Management System

This package provides the essential framework for building a robust Content Management System (CMS) in Laravel.

## Documentation

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Post-Installation Steps](#post-installation-steps)
- [Usage](#usage)

## Requirements

Ensure you have the following installed:

- Laravel 8.x or higher
- PHP 7.4 or higher

## Installation

To install the package, run the following command:

```bash
composer require kezeneilhou/cms-laravel
```

Next, publish the vendor assets:

```bash
php artisan vendor:publish
```

## Configuration

### CDN Integration

Import the Quill CDN in your layout view to enable rich text editing features:

```html
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
```

### Routes Setup

Add the following routes to your `routes/web.php` file:

```php
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuillUploadController;

Route::resource('post', PostController::class);
Route::post('/upload-image', [QuillUploadController::class, 'uploadImage'])->name('quill.upload');
Route::post('/upload-file', [QuillUploadController::class, 'uploadFile'])->name('quill.upload.file');
```

## Post-Installation Steps

After running the vendor publish command, ensure you update the namespaces for the published Models and Controllers. This is necessary to align with your application's structure:

1. Open the published Model and Controller files.
2. Update the namespaces from `Kezeneilhou\CmsLaravel\` to `App\` (or your desired namespace).

### Example of Namespace Update

For instance, if you have a model published at `app/Models/Post.php`, change the namespace as follows:

**Before:**

```php
namespace Kezeneilhou\CmsLaravel\Models;
```

**After:**

```php
namespace App\Models;
```



