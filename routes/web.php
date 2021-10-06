<?php

use Illuminate\Support\Facades\Route;
use App\Mail\MessageMail;
/* use Illuminate\Notifications\Messages\MailMessage; */
use Illuminate\Support\Facades\Mail;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/', [App\Http\Controllers\HomeController::class, 'mail'])->name('mail');
Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');

Route::group(['prefix' => 'admin'], function() {
    Auth::routes();

    Route::get('/', function() {
        return redirect('/admin/index');
    });

    Route::get('/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin-index');

    Route::get('/item/create', [App\Http\Controllers\AdminController::class, 'createItem'])->name('admin-create-item');
    Route::post('/item', [App\Http\Controllers\AdminController::class, 'storeItem'])->name('admin-store-item');
    Route::get('/item/{item}', [App\Http\Controllers\AdminController::class, 'showItem'])->name('admin-show-item');
    Route::get('/item/{item}/edit', [App\Http\Controllers\AdminController::class, 'editItem'])->name('admin-edit-item');
    Route::patch('/item/{item}', [App\Http\Controllers\AdminController::class, 'updateItem'])->name('admin-update-item');
    Route::delete('/item/{item}', [App\Http\Controllers\AdminController::class, 'destroyItem'])->name('admin-destroy-item');

    Route::post('/type', [App\Http\Controllers\AdminController::class, 'storeType']);
    Route::get('/type/{type}', [App\Http\Controllers\AdminController::class, 'showType'])->name('admin-show-type');
    Route::patch('/type/{type}', [App\Http\Controllers\AdminController::class, 'updateType'])->name('admin-update-type');
    Route::delete('/type/{type}', [App\Http\Controllers\AdminController::class, 'destroyType'])->name('admin-destroy-type');
});