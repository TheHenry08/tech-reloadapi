<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
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

Route::get('/productos',[ProductoController::class, 'index']);

Route::get('/productos/search',[ProductoController::class, 'indexFilter']);

Route::get('/productos/{id}', [ProductoController::class, 'show']);

Route::post('/productos',[ProductoController::class, 'store']);

Route::put('/productos/{id}',[ProductoController::class, 'update']);

Route::patch('/productos/{id}',[ProductoController::class, 'updatePartial']);

Route::delete('/productos/{id}',[ProductoController::class, 'destroy']);