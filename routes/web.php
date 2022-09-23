<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/login', [App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class,'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/reservation');
})->middleware('auth'); 


Route::get('reservation', [ReservationController::class, 'index'])->middleware('auth'); // 入力フォーム
Route::post('reservation', [ReservationController::class, 'store'])->middleware('auth');// 送信先

Route::get('myreserve', [ReservationController::class, 'myreserve'])->middleware('auth'); // 自身の予約確認
Route::post('myreserve/edit', [ReservationController::class, 'edit'])->middleware('auth'); // 自身の予約削除
Route::post('myreserve/remove', [ReservationController::class, 'remove'])->middleware('auth'); // 自身の予約削除

Route::get('users', [ReservationController::class, 'other'])->middleware('auth'); // ユーザー別の予約確認