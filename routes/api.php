<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apis_controller;

Route::get("/sort",[apis_controller::class,"sortString"]);
Route::get("/split",[apis_controller::class,"splitValues"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
