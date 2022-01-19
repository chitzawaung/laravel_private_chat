<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use Symfony\Component\Mime\MessageConverter;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('userList', [MessageController::class, 'user_list'])->name('user.list');
Route::get('usermessage/{id}', [MessageController::class, 'user_message'])->name('user.message');
Route::post('senemessage', [MessageController::class, 'send_message'])->name('user.message.send');
Route::get('/deletesinglemessage/{id}', [MessageController::class, 'delete_single_message'])->name('user.message.single.delete');
Route::get('/deleteallmessage/{id}', [MessageController::class, 'delete_all_message'])->name('user.message.all.delete');

