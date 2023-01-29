<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CashoutController;
use App\Http\Controllers\API\ServicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// AUTH ROUTES
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('auth/verify', [AuthController::class, 'verify']);
Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('auth/reset-password', [AuthController::class, 'resetPassword']);

// ADMIN ROUTES
Route::get('admin/all-user', [AdminController::class, 'getAllUser']);
Route::post('admin/deactivate-user/{id}', [AdminController::class, 'deactivateUser']);
Route::post('admin/activate-user/{id}', [AdminController::class, 'activateUser']);
Route::post('admin/set-admin/{id}', [AdminController::class, 'setAdmin']);
Route::post('admin/unset-admin/{id}', [AdminController::class, 'unsetAdmin']);
Route::post('admin/delete-user/{id}', [AdminController::class, 'deleteUser']);

// SERVICES ROUTES
Route::get('services', [ServicesController::class, 'index']);
Route::get('services/amount', [ServicesController::class, 'getServiceAmount']);
Route::get('services/count', [ServicesController::class, 'getServiceCount']);
Route::get('services/show/{id}', [ServicesController::class, 'show']);
Route::post('services/store', [ServicesController::class, 'store']);
Route::post('services/update/{id}', [ServicesController::class, 'update']);
Route::get('services/destroy/{id}', [ServicesController::class, 'destroy']);

// Unit categories routes
Route::get('category', [CategoryController::class, 'index']);
Route::get('category/show/{id}', [CategoryController::class, 'show']);
Route::post('category/store/', [CategoryController::class, 'store']);
Route::post('category/update/{id}', [CategoryController::class, 'update']);
Route::post('category/destroy/{id}', [CategoryController::class, 'destroy']);
Route::post('category/activate/{id}', [CategoryController::class, 'activate']);
Route::post('category/deactivate/{id}', [CategoryController::class, 'deactivate']);

// Products routes
Route::get('product/', [ProductController::class, 'index']);
Route::get('product/show/{id}', [ProductController::class, 'show']);
Route::post('product/store/', [ProductController::class, 'store']);
Route::post('product/update/{id}', [ProductController::class, 'update']);
Route::post('product/destroy/{id}', [ProductController::class, 'destroy']);
Route::post('product/activate/{id}', [ProductController::class, 'activate']);
Route::post('product/deactivate/{id}', [ProductController::class, 'deactivate']);

// Cashout routes
Route::get('cashout', [CashoutController::class, 'index']);
Route::get('cashout/show/{id}', [CashoutController::class, 'show']);
Route::post('cashout/store/', [CashoutController::class, 'store']);
Route::post('cashout/update/{id}', [CashoutController::class, 'update']);
Route::post('cashout/destroy/{id}', [CashoutController::class, 'destroy']);
Route::post('cashout/approve/{id}', [CashoutController::class, 'approve']);
Route::post('cashout/reject/{id}', [CashoutController::class, 'reject']);

// Promo/Discounts routes

// Logistics
// -- Material management
// --- Create material
// --- Show material
// --- Update material
// --- Delete material

// -- Supplier management
// --- Create supplier
// --- Show supplier
// --- Update supplier
// --- Delete supplier

// Expenses routes
// -- Fixed Expenses
// -- Variable Expenses
// -- Others Expenses

// Report routes
// -- Operational report
// -- Monthly report
// -- Weekly report

// Invesment routes
// -- Investment categories

// Graph routes



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
