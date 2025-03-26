<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/users/{id}/permission/{idPermission}', [UserPermissionController::class, 'detachUserPermission'])->name('user.permissions.detach');
    Route::post('/users/{id}/permissions', [UserPermissionController::class, 'attachUserPermission'])->name('user.permissions.attach');
    Route::get('/users/{id}/permissions/create', [UserPermissionController::class, 'permissionsAvailable'])->name('user.permissions.available');
    Route::get('/users/{id}/permissions', [UserPermissionController::class, 'permissions'])->name('user.permissions');


    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
