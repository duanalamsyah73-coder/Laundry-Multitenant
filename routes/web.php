<?php
use App\Support\Routing\PortalRoutes;
use App\Modules\Account\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
PortalRoutes::customer(function (): void {
 Route::get('/', fn () => view('laundry.home'))->name('home');
 Route::view('/layanan', 'laundry.services')->name('services');
 Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class,'showLogin'])->name('login');
  Route::post('/login', [AuthController::class,'login'])->name('login.submit');
  Route::get('/register', [AuthController::class,'showRegister'])->name('register');
  Route::post('/register', [AuthController::class,'register'])->name('register.submit');
 });
 Route::post('/logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');
});
PortalRoutes::tenant(function (): void { Route::view('/dashboard','portals.tenant')->name('dashboard'); });
PortalRoutes::admin(function (): void { Route::view('/dashboard','portals.admin')->name('dashboard'); });
