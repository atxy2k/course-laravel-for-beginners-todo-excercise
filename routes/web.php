<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
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

Route::get('/', function () {
    return redirect()->route('todo.index');
})->name('root');

Route::prefix('todo')->group(function(){

    Route::get('/', [TodoController::class, 'index'])->name('todo.index');
    Route::get('add', [TodoController::class, 'add'])->name('todo.add');
    Route::post('store', [TodoController::class, 'store'])->name('todo.store');
    Route::get('complete/{id}', [TodoController::class, 'complete'])->name('todo.complete');
    Route::get('update/{id}', [TodoController::class, 'update'])->name('todo.update');
    Route::post('store-update/{id}', [TodoController::class, 'storeUpdate'])->name('todo.store-update');
    Route::get('delete/{id}', [TodoController::class,'delete'])->name('todo.delete');

});