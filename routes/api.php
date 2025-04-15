<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\FilterController;
use App\Http\Controllers\API\MaintenanceScheduleController;
use App\Http\Controllers\API\MaintenanceReportController;
use App\Http\Controllers\API\TechnicianController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\LogisticsRequestController;
use App\Http\Controllers\API\ForumController;
use App\Http\Controllers\API\WaterUsageReportController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('stores', StoreController::class);
    Route::apiResource('maintenance-reports', MaintenanceReportController::class);
    Route::apiResource('equipment', EquipmentController::class);
    Route::apiResource('feedbacks', FeedbackComplaintController::class);
});

