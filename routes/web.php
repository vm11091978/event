<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/**
 * @description Show the home page of laravel framework
 */
Route::get('/home', function () {
    return view('welcome');
});

/**
 * @description Show the home page of the site
 */
Route::get('/', [IndexController::class, 'index'])->name('index');

Route::middleware(['auth', 'verified'])->group(function () {
    /**
     * @description Show the event registration page for the user
     */
    Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');
    /**
     * @update Save the event for a specific user in the database
     * @destroy Delete the event for a specific user in the database
     */
    Route::resource('dashboard', EventController::class)->only(['update', 'destroy']);
});

Route::middleware('auth')->group(function () {
    /**
     * @description Show the user's profile page
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    /**
     * @description Update the user's profile in database
     */
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    /**
     * @description Delete the user's profile in database
     */
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
