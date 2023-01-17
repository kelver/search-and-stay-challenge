<?php

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\StoreController;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['apiJwt'])->group(static function () {
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(StoreController::class)->prefix('stores')->group(function() {
        Route::get('/', 'index')->name('store.index');
        Route::get('/{identify}', 'show')->name('store.show');
        Route::post('/', 'store')->name('store.store');
        Route::put('/{identify}', 'update')->name('store.update');
        Route::delete('/{identify}', 'destroy')->name('store.delete');
    });
});
