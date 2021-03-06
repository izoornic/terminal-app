<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\SendEmailController;
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

Route::any('/', function () {
    return view('welcome');
});

Route::get('/prijava', function () {
    return view('prijava');
});

//Route::get('send-email', [SendEmailController::class, 'index']);
/* Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); */

Route::group(['middleware' => [
    'auth:sanctum',
    'verified',
    'accessrole'
]], function(){

    Route::get('/dashboard', function(){
        return view('admin.dashboard');
        })->name('dashboard');

    Route::get('/pages', function(){
        return view('admin.pages');
        })->name('pages');

    Route::get('/users', function(){
        return view('admin.users');
        })->name('users');

    Route::get('/user-permissions', function(){
        return view('admin.user-permissions');
        })->name('user-permissions');

    Route::get('/lokacije', function(){
        return view('admin.lokacije');
        })->name('lokacije');
    
    Route::get('/terminal', function(){
        return view('admin.terminal');
        })->name('terminal');

    Route::get('/tiket', function(){
        return view('admin.tiket');
        })->name('tiket');
    
    Route::get('/tiketview', function(){
        return view('admin.tiketview');
        })->name('tiketview');

});
