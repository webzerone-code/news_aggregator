<?php

use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\Auth\API\APIAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('register', [APIAuthController::class, 'register']);
Route::post('login', [APIAuthController::class, 'login']);


Route::middleware('auth:api')->group( function () {
    Route::get('/',[NewsController::class, 'getNews']);
    //Route::get('logout', [APIAuthController::class, 'logout']);
});
