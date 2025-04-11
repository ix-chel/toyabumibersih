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

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User profile
    Route::get('/user', function (Request $request) {
        return $request->user()->load('roles');
    });
    
    // Dashboard data
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/maintenance-stats', [DashboardController::class, 'maintenanceStats']);
    Route::get('/dashboard/inventory-stats', [DashboardController::class, 'inventoryStats']);
    Route::get('/dashboard/financial-stats', [DashboardController::class, 'financialStats']);
    
    // User management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('/users/{user}/roles', [UserController::class, 'assignRole']);
        Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole']);
    });
    
    // Client management
    Route::apiResource('clients', ClientController::class);
    
    // Site management
    Route::apiResource('sites', SiteController::class);
    Route::get('/clients/{client}/sites', [SiteController::class, 'getClientSites']);
    
    // Filter management
    Route::apiResource('filters', FilterController::class);
    Route::get('/sites/{site}/filters', [FilterController::class, 'getSiteFilters']);
    
    // Maintenance management
    Route::apiResource('maintenance-schedules', MaintenanceScheduleController::class);
    Route::get('/filters/{filter}/maintenance-schedules', [MaintenanceScheduleController::class, 'getFilterSchedules']);
    Route::apiResource('maintenance-reports', MaintenanceReportController::class);
    
    // Technician management
    Route::apiResource('technicians', TechnicianController::class);
    Route::get('/technicians/{technician}/schedules', [TechnicianController::class, 'getTechnicianSchedules']);
    Route::get('/technicians/{technician}/reports', [TechnicianController::class, 'getTechnicianReports']);
    
    // Inventory management
    Route::apiResource('inventory', InventoryController::class);
    Route::post('/inventory/{inventory}/adjust', [InventoryController::class, 'adjustStock']);
    Route::get('/inventory/low-stock', [InventoryController::class, 'getLowStock']);
    
    // Invoice management
    Route::apiResource('invoices', InvoiceController::class);
    Route::get('/clients/{client}/invoices', [InvoiceController::class, 'getClientInvoices']);
    Route::post('/invoices/{invoice}/send', [InvoiceController::class, 'sendInvoice']);
    Route::post('/invoices/{invoice}/mark-paid', [InvoiceController::class, 'markAsPaid']);
    
    // Logistics management
    Route::apiResource('logistics-requests', LogisticsRequestController::class);
    Route::post('/logistics-requests/{request}/approve', [LogisticsRequestController::class, 'approveRequest']);
    Route::post('/logistics-requests/{request}/reject', [LogisticsRequestController::class, 'rejectRequest']);
    
    // Forum
    Route::apiResource('forum-posts', ForumController::class);
    Route::post('/forum-posts/{post}/comments', [ForumController::class, 'addComment']);
    Route::get('/forum-posts/{post}/comments', [ForumController::class, 'getComments']);
    
    // Water usage reports
    Route::apiResource('water-usage-reports', WaterUsageReportController::class);
    Route::get('/clients/{client}/water-usage-reports', [WaterUsageReportController::class, 'getClientReports']);
});

