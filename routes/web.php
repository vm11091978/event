<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
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

Route::middleware(['auth', 'verified', 'isAdmin', 'isActive'])->group(function () {
    /**
     * @description Show the event management page for the admin
     */
    Route::get('/admin-events', [AdminEventController::class, 'index'])->name('admin.events');
    /**
     * @store Save an event in database
     * @update Update an event data in database
     * @destroy Delete an event in database
     */
    Route::resource('admin-events', AdminEventController::class)->only(['store', 'update', 'destroy']);
    /**
     * @description Show the category management page for the admin
     */
    Route::get('/admin-categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    /**
     * @store Save a category in database
     * @update Update category data in database
     * @destroy Delete a category in database
     */
    Route::resource('admin-categories', AdminCategoryController::class)->only(['store', 'update', 'destroy']);
    /**
     * @description Show the user management page for the admin
     */
    Route::get('/admin-users', [AdminUserController::class, 'index'])->name('admin.users');
    /**
     * @store Save an user in database
     * @update Update an user data in database
     * @destroy Delete an user in database
     */
    Route::resource('admin-users', AdminUserController::class)->only(['store', 'update', 'destroy']);
});

Route::middleware(['auth', 'verified', 'isActive'])->group(function () {
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

Route::middleware('auth', 'isActive')->group(function () {
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
