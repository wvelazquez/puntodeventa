<?php

use Illuminate\Support\Facades\Route;
use App\http\Livewire\Categories;
use App\Http\Livewire\Coins;
use App\Http\Livewire\Pos;
use App\Http\Livewire\Products;
use App\Models\Denomination;

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
Route::get('categories', Categories::class);
Route::get('products', Products::class);
Route::get('denominations', Coins::class);
Route::get('pos', Pos::class);