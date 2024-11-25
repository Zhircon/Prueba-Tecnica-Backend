<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\ProductType;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductTypeController;
//Product CRUD
Route::get('/holaMundo', function(){
    return response()->json('{title:holamundo}',200);
});
Route::get('/products', [ProductController::class,'all']);
Route::get('/product/{id}', [ProductController::class,'show']);
Route::post('/product', [ProductController::class,'store']);
Route::put('/product/{id}', [ProductController::class,'update']);
Route::delete('/product/{id}',[ProductController::class,'delete']);
//ProductType CRUD
Route::get('/producttypes',[ProductTypeController::class,'index']);
Route::get('/producttype/{id}',[ProductTypeController::class,'show']);
Route::post('/producttype',[ProductTypeController::class,'store']);
Route::put('/producttype/{id}', [ProductTypeController::class,'update']);
Route::delete('/producttype/{id}',[ProductTypeController::class,'delete']);
//Cuestiones de seguridad
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/