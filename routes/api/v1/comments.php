<?php

// Route::apiResource('comments', \App\Http\Controllers\CommentController::class);

use Illuminate\Support\Facades\Route;

Route::middleware([
  // 'auth',
  // \App\Http\Middleware\RedirectIfAuthenticated::class,
])
  ->name('comments.')
  ->group(function(){
    Route::get('/comments', [\App\Http\Controllers\CommentController::class, 'index'])
      ->name('index')
      ->withoutMiddleware('auth');

    Route::get('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'show'])
      ->name('show')
      ->whereNumber('comment');
    
    Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('store');
    
    Route::patch('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])->name('update');
    
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('destroy');
  });

