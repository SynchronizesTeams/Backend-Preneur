<?php

use App\Http\Controllers\StampController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'RegisterStudent']);
Route::post('/login', [AuthController::class, 'LoginStudent']);
Route::post('/company/register', [AuthController::class, 'RegisterCompany']);
Route::post('/company/login', [AuthController::class, 'CompanyLogin']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('send/{siswa_id}', [StampController::class, 'sendStamp']);
});
