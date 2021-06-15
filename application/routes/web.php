<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('tags', [IndexController::class, 'tags'])->name('tags');
Route::get('news', [IndexController::class, 'news'])->name('news');
Route::get('galleries', [IndexController::class, 'galleries'])
    ->name('galleries');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('news', [NewsController::class, 'index'])
        ->name('admin.news.index');
    Route::get('news/edit/{id}', [NewsController::class, 'edit'])
        ->name('admin.news.edit');
    Route::get('news/show/{id}', [NewsController::class, 'show'])
        ->name('admin.news.show');
    Route::post('news/store/', [NewsController::class, 'store'])
        ->name('admin.news.store');
    Route::get('news/create/', [NewsController::class, 'create'])
        ->name('admin.news.create');
    Route::post('news/upload/', [NewsController::class, 'upload'])
        ->name('admin.news.upload');
    Route::post('news/update/{id}', [NewsController::class, 'update'])
        ->name('admin.news.update');
    Route::post('news/delete/{id}', [NewsController::class, 'delete'])
        ->name('admin.news.delete');

    Route::get('galleries', [GalleriesController::class, 'index'])
        ->name('admin.galleries.index');
    Route::get('galleries/all/', [GalleriesController::class, 'all'])
        ->name('admin.galleries.all');
    Route::get('galleries/edit/{id}', [GalleriesController::class, 'edit'])
        ->name('admin.galleries.edit');
    Route::get('galleries/show/{id}', [GalleriesController::class, 'show'])
        ->name('admin.galleries.show');
    Route::post('galleries/store/', [GalleriesController::class, 'store'])
        ->name('admin.galleries.store');
    Route::get('galleries/create/', [GalleriesController::class, 'create'])
        ->name('admin.galleries.create');
    Route::post('galleries/upload/', [GalleriesController::class, 'upload'])
        ->name('admin.galleries.upload');
    Route::post('galleries/update/{id}', [GalleriesController::class, 'update'])
        ->name('admin.galleries.update');
    Route::post('galleries/delete/{id}', [GalleriesController::class, 'delete'])
        ->name('admin.galleries.delete');
});
