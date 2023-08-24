<?php

use App\Http\Controllers\assignmentsController;
use App\Http\Controllers\hotelsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('hotels',[hotelsController::class,'get_hotels']);
Route::post('newHotel',[hotelsController::class,'create_hotel'])->name('newHotel');
Route::get('hotel/{id}',[hotelsController::class,'get_hotel_by_id']);


Route::post('assignments',[assignmentsController::class,'get_assignment']);
Route::post('newAssignment',[assignmentsController::class,'create_assigment']);
