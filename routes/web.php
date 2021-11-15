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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('agreements', [\App\Http\Controllers\Admin\AgreementController::class, 'index']);
Route::get('test', [\App\Http\Controllers\Admin\AgreementController::class, 'test']);
Route::get('suspend', [\App\Http\Controllers\Admin\AgreementController::class, 'suspend']);



Route::post('select-plan/{id}', [\App\Http\Controllers\Content\UserPlanController::class, 'select']);
Route::get('test', [\App\Http\Controllers\Content\UserPlanController::class, 'test']);


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('listings', [\App\Http\Controllers\HomeController::class, 'listings']);



Route::group(['middleware' => 'auth'], function () {

    Route::get('checkout', [\App\Http\Controllers\Content\CheckoutController::class, 'checkout']);
    Route::post('submit', [\App\Http\Controllers\Content\CheckoutController::class, 'submit']);
    Route::resource('listing', \App\Http\Controllers\Content\ListingController::class);

});