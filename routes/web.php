<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelTypeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\user\PageController as UserPageController;
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
    return redirect()->route('view',['page'=>'home']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/administrator.php';


Route::middleware('auth:administrator')->prefix('administrator')->name('administrator.')->group(function(){

    //hotel
    Route::prefix('hotel')->name('hotel.')->group(function(){
        
        //type
        Route::prefix('/type')->name('type.')->group(function(){
            
            Route::get('/',[HotelTypeController::class , 'index'])->name('home');
            Route::post('/store',[HotelTypeController::class , 'store'])->name('store');

        });

        //property
        Route::prefix('/property')->name('property.')->group(function(){
            Route::get('/',[PropertyTypeController::class , 'index'])->name('home');
            Route::post('/store',[PropertyTypeController::class , 'store'])->name('store');
        });

        
        //hotel
        Route::get('/',[HotelController::class,'index'])->name('home');

    });


    //pages
    Route::prefix('pages')->name('pages.')->group(function(){

        Route::get('/',[PageController::class,'index'])->name('home');
        Route::post('/store',[PageController::class,'store'])->name('store');
        Route::put('/{page:slug}/update',[PageController::class,'update'])->name('update');

    });
});

Route::get('/{page:slug}',[UserPageController::class,'index'])->name('view');