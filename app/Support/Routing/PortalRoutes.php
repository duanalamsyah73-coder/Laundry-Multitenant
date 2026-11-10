<?php
namespace App\Support\Routing;
use Closure;
use Illuminate\Support\Facades\Route;
final class PortalRoutes {
 public static function customer(Closure|string $routes): void {
  Route::middleware('web')->name('customer.')->group($routes);
 }
 public static function tenant(Closure|string $routes): void {
  Route::middleware(['web','auth','role:tenant'])->prefix('tenant')->name('tenant.')->group($routes);
 }
 public static function admin(Closure|string $routes): void {
  Route::middleware(['web','auth','role:admin'])->prefix('admin')->name('admin.')->group($routes);
 }
}
