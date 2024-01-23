<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/apager', [PageController::class, 'showApagerStore'])->name('apager.store');
Route::get('/clearcache', [PageController::class, 'makeCacheClear'])
    ->name('admin.clearcache');
Route::get('/readcookie', [PageController::class, 'SetReadCookie'])
    ->name('readcookie');

#Route::group(['middleware' => 'isadmin'], function () {
Route::get('/admin/{path?}', [PageController::class, 'admin'])
    ->where(['path' => '.*'])
    ->name('admin_react');
#});

Route::get('/app/{path?}', [PageController::class, 'app'])
    ->where(['path' => '.*'])
    ->name('admin_react');
Route::get('/sitemap.xml', [PageController::class, 'sitemap_xml'])->name('sitemap.xml');

Route::get('/{path?}', [PageController::class, 'home'])
    ->where(['path' => '.*'])
    ->name('react');

Route::get('/admincookie', [AdminController::class, 'setAdminCookie']);
