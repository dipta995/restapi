<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 

Route::resource('/user',AuthController::class);
//Route::get('/user/{id}',[AuthController::class,'show']);
