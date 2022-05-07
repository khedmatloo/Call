<?php

use App\Http\Controllers\CallController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/call', [CallController::class, 'index'])->middleware('auth:sanctum');
Route::post('/call', [CallController::class, 'store'])->middleware('auth:sanctum');
Route::get('/call/{id}', [CallController::class, 'show'])->middleware('auth:sanctum');
Route::post('/comment', [CommentController::class, 'store'])->middleware('auth:sanctum');
