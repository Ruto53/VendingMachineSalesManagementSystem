<?php

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
    return view('auth.login');
});

Auth::routes();

//ログイン後の画面
Route::get('list', [App\Http\Controllers\ProductController::class, 'showList'])->name('list');
Route::post('list', [App\Http\Controllers\ProductController::class, 'search'])->name('search');

//新規追加の画面
Route::get('add', [App\Http\Controllers\ProductController::class, 'addList'])->name('add');
Route::post('add', [App\Http\Controllers\ProductController::class, 'addSubmit'])->name('submit');

//削除を行う処理
Route::post('delete{id}',[App\Http\Controllers\ProductController::class, 'delete'])->name('delete');

//詳細ボタンクリック時
Route::get('detail{id}', [App\Http\Controllers\ProductController::class, 'detail'])->name('detail');
Route::post('detail{id}', [App\Http\Controllers\ProductController::class, 'detail'])->name('detail');

//編集ボタンクリック時
Route::get('edit{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
Route::post('update{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
