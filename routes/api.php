<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StampController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



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
Route::post('admin/login', [AdminController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('send/{siswa_id}', [StampController::class, 'sendStamp']);
    Route::get('/siswa/{siswa_id}', [AuthController::class, 'siswaProfile']);
    Route::get('/company/{company_id}', [AuthController::class, 'companyProfile']);
    Route::get('/stamp/{siswa_id}', [StampController::class, 'seeStamp']);
    Route::prefix('/admin')->group(function() {
        Route::post('/status/{company_id}/{status}', [AdminController::class, 'setStatus']);
        Route::get('/companies', [AdminController::class, 'seeAllCompany']);
    });
});
