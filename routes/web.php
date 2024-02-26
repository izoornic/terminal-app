<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDataController;
//use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\PredracunPdfControler;
use App\Http\Controllers\Distributer\DistPredracunControler;
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
        return (auth()->user()->pozicija_tipId == 8) ?view('distributer.dashboard') : view('admin.dashboard');
        })->name('dashboard');

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

    //Rute za Menagera licenci
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
    
    Route::get('/razduzenje', function(){
        return view('admin.razduzenje');
        })->name('razduzenje');

    Route::get('/razduzenje-distributeri', function(){
        return view('admin.razduzenje-distributer');
        })->name('razduzenje-distributeri');
    
    Route::get('/razduzenje-distributer-mesec', function(){
        return view('admin.razduzenje-distributer-mesec');
        })->name('razduzenje-distributer-mesec');

    Route::get('/razduzenje-pregled', function(){
        return view('admin.razduzenje-pregled');
        })->name('razduzenje-pregled');

    Route::get('/licence', function(){
        return view('admin.licenca');
        })->name('licence');
    
    Route::get('/licenca-parametri', function(){
        return view('admin.licenca-parametri');
        })->name('licenca-parametri');
    
    Route::get('/licenca-lokacija', function(){
        return view('admin.distributer-lokacija');
        })->name('licenca-lokacija');

    //RUTE za logovanog ditributera 2
    Route::get('/dist-terminal', function(){
        return view('distributer.distr-terminal');
        })->name('dist-terminal');

    Route::get('/dist-lokacija', function(){
        return view('distributer.distr-lokacije');
        })->name('dist-lokacija');

    Route::get('/dist-licence', function(){
        return view('distributer.distr-licence');
        })->name('dist-licence');

    Route::get('/dist-poslovanje', function(){
        return view('distributer.distr-poslovanje');
        })->name('dist-poslovanje');

    Route::get('/dist-pdf-predracun', [DistPredracunControler::class, 'index'])->name('dist-pdf-predracun');

});
