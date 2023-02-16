<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\UserController;
use  App\Http\Controllers\Api\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
 
Route::group(['middleware' => 'auth:api'], function(){
 Route::get('profile', [UserController::class, 'userDetails']);
});


//PROJECT
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('projects', [ProjectController::class, 'index']);
   });

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('projects/{id}', [ProjectController::class, 'show']);
   });

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('projects/new', [ProjectController::class, 'store']);
   });

Route::group(['middleware' => 'auth:api'], function(){
    Route::put('projects/edit/{id}', [ProjectController::class, 'update']);
   });
   
Route::group(['middleware' => 'auth:api'], function(){
    Route::delete('projects/delete/{id}', [ProjectController::class, 'destroy']);
   });
