<?php

// Route::apiResource('users', \App\Http\Controllers\UserController::class);

use Illuminate\Support\Facades\Route;

Route::middleware([
  // 'auth',
  // \App\Http\Middleware\RedirectIfAuthenticated::class,
])
  ->prefix('heyaa')
  ->name('users.')
  ->group(function(){
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])
      ->name('index')
      ->withoutMiddleware('auth');

    Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])
      ->name('show')
      ->whereNumber('user');
    
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
    
    Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
    
    Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
  });

