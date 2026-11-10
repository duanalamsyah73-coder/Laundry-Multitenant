
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public tenant routes
Route::get('/tenants', [TenantController::class, 'index']);
Route::get('/tenants/{id}', [TenantController::class, 'show']);

// Tenant creation is disabled until admin authentication is implemented.

// Order routes
Route::post('/orders', [OrderController::class, 'store'])
    ->middleware('tenant.context');

Route::get('/orders/{id}', [OrderController::class, 'showLegacy']);

Route::get('/tenants/{tenant}/orders/{order}', [OrderController::class, 'show'])
    ->middleware('tenant.context')
    ->scopeBindings();
