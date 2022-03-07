<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Front\Home;
use App\Http\Livewire\Back\Dashboard;
use App\Http\Livewire\Back\Usermanage;
use App\Http\Livewire\Back\Catmanage;
use App\Http\Livewire\Back\Othercat;
use App\Http\Livewire\Back\Myfileman;
use App\Http\Livewire\Back\Publicfile;
use App\Http\Livewire\Back\Otherfile;
use App\Http\Livewire\Back\Pinnedfile;
use App\Http\Livewire\Back\Filereceive;

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

Route::get('/', Home::class)->name('home');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard',Dashboard::class)->name('dashboard');
    Route::get('/mycatman', Catmanage::class)->name('mycatman');
    Route::get('/myfileman', Myfileman::class)->name('myfileman');
    Route::get('/publicfiles', Publicfile::class)->name('publicfiles');
    Route::get('/pinnedfiles', Pinnedfile::class)->name('pinnedfiles');
    Route::get('/receivedfiles', Filereceive::class)->name('receivedfiles');
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/userman', Usermanage::class)->name('userman');
        Route::get('/othercat', Othercat::class)->name('othercat');
        Route::get('/otherfile', Otherfile::class)->name('otherfile');
    });
});