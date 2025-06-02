<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ArticleController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\front\ArticleController as FrontArticleController;
use App\Http\Controllers\front\ProjectController as FrontProjectController;
use App\Http\Controllers\front\ServiceController as FrontServiceController;
use App\Http\Controllers\front\TestimonialController as FrontTestimonialController;


 Route :: post('authenticate',[AuthenticationController::class,'authenticate']);
 Route :: get('get-services',[FrontServiceController::class,'index']);
 Route :: get('get-latest-services',[FrontServiceController::class,'latestServices']);

 Route :: get('get-projects',[FrontProjectController::class,'index']);
 Route :: get('get-latest-projects',[FrontProjectController::class,'latestProjects']);

 Route :: get('get-articles',[FrontArticleController::class,'index']);
 Route :: get('get-latest-articles',[FrontArticleController::class,'latestArticles']);

 Route :: get('get-testimonials',[FrontTestimonialController::class,'index']);
 Route :: get('get-latest-testimonials',[FrontTestimonialController::class,'latestTestimonial']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route :: get('dashbaord',[DashboardController::class,'index']);
    Route :: get('logout',[DashboardController::class,'index']);

    //Service Routes
    Route :: post('services',[ServiceController::class,'store']);
    Route :: get('services',[ServiceController::class,'index']);
    Route :: put('services/{id}',[ServiceController::class,'update']);
    Route :: get('services/{id}',[ServiceController::class,'show']);
    Route :: delete('services/{id}',[ServiceController::class,'destroy']);


    // Project Routes
    Route::post('projects', [ProjectController::class, 'store']);
    Route::get('projects', [ProjectController::class, 'index']);
    Route::put('projects/{id}', [ProjectController::class, 'update']);
    Route::get('projects/{id}', [ProjectController::class, 'show']);
    Route::delete('projects/{id}', [ProjectController::class, 'destroy']);

    Route::post('articles', [ArticleController::class, 'store']);
    Route::get('articles', [ArticleController::class, 'index']);
    Route::get('articles/{id}', [ArticleController::class, 'show']);
    Route::put('articles/{id}', [ArticleController::class, 'update']);
    Route::delete('articles/{id}', [ArticleController::class, 'destroy']);


    //Testmonial
    Route::post('testimonials',[TestimonialController::class,'store']);
    Route::get('testimonials',[TestimonialController::class,'index']);
    Route::get('testimonials/{id}',[TestimonialController::class,'show']);
    Route::put('testimonials/{id}',[TestimonialController::class,'update']);
    Route::delete('testimonials/{id}',[TestimonialController::class,'destroy']);


    Route :: post('temp-images',[TempImageController::class,'store']);





});
