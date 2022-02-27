<?php

use App\Http\Controllers\CollectibleController;
use App\Http\Controllers\StaticPagesController;
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
/* Guest/Public area */
Route::get('/', [StaticPagesController::class, 'welcome'])->name('welcome');

/* Protected area */
Route::middleware(['auth'])->group(function() {
    Route::get('collection', [StaticPagesController::class, 'collection'])->name('collection');
});

/* Add Laravel Breeze route definitions */
require __DIR__.'/auth.php';