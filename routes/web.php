<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDataController;
//use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\PredracunPdfControler;
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

Route::get('/blacklist', function () {
    return (view('blacklist'));
});

Route::get('/apitest', [ApiDataController::class, 'index']);

Route::get('pdf-predracun', [PredracunPdfControler::class, 'index']);

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

    Route::get('/licenca-lokacije', function(){
        return view('admin.licenca-lokacije');
        })->name('licenca-lokacije');

    Route::get('/licenca-terminali', function(){
        return view('admin.licenca-terminali');
        })->name('licenca-terminali');
    
    Route::get('/distributeri', function(){
        return view('admin.distributer');
        })->name('distributeri');

    Route::get('/distributer-licenca', function(){
        return view('admin.distributer-licence');
        })->name('distributer-licenca');

    Route::get('/distributer-treminal', function(){
        return view('admin.distributer-treminali');
        })->name('distributer-treminal');

    Route::get('/zaduzenje', function(){
        return view('admin.zaduzenja');
        })->name('zaduzenje');

    Route::get('/zaduzenje-kurs', function(){
        return view('admin.zaduzenje-srednji_kurs');
        })->name('zaduzenje-kurs');

    Route::get('/zaduzenje-distributeri', function(){
        return view('admin.zaduzenje-distributeri');
        })->name('zaduzenje-distributeri');

    Route::get('/zaduzenje-distributer-mesec', function(){
        return view('admin.zaduzenje-distributer-mesec');
        })->name('zaduzenje-distributer-mesec');
    
    Route::get('/zaduzenje-pregled', function(){
        return view('admin.zaduzenje-pregled');
        })->name('zaduzenje-pregled');

});
