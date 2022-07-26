<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
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

//book routes
Route::post('/books',[BookController::class,'store']);
Route::patch('books/{book}',[BookController::class,'update']);
Route::delete('books/{book}',[BookController::class,'destroy']);
//author routes
Route::post('/authors',[AuthorController::class,'store']);

