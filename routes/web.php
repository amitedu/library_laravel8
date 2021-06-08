<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\CheckoutController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/books', [BookController::class, 'store']);
Route::patch('/books/{book}', [BookController::class, 'update']);
Route::delete('books/{book}', [BookController::class, 'destroy']);

Route::post('/author', [AuthorController::class, 'store']);

Route::post('/checkout/{book}', [CheckoutController::class, 'store'])->middleware('auth');
Route::post('/checkin/{book}', [CheckinController::class, 'store'])->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
