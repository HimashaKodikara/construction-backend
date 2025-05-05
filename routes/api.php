<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\TempImageController;

 Route :: post('authenticate',[AuthenticationController::class,'authenticate']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route :: get('dashbaord',[DashboardController::class,'index']);
    Route :: get('logout',[DashboardController::class,'index']);

    //Service Routes
    Route :: post('services',[ServiceController::class,'store']);
    Route :: get('services',[ServiceController::class,'index']);

    Route :: post('temp-images',[TempImageController::class,'store']);





});
