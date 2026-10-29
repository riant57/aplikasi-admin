<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
    return view('home');
    })
        ->middleware('permission:dashboard.view')
        ->name('home');

    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:users.view')
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('permission:users.create')
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission:users.create')
        ->name('users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission:users.edit')
        ->name('users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('permission:users.edit')
        ->name('users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission.delete')
        ->name('users.destroy');

    Route::get('/roles', [RoleController::class, 'index'])
        ->middleware('permission:roles.view')
        ->name('roles.index');
    
    Route::post('/roles', [RoleController::class, 'store'])
        ->middleware('permission:roles.create')
        ->name('roles.store');

    Route::get('/roles/{role}/permissions', [
        RoleController::class,
        'editPermissions'
    ])
        ->middleware('permission:roles.edit')
        ->name('roles.permissions.edit');

    Route::put('/roles/{role}/permissions', [
        RoleController::class,
        'updatePermissions'
    ])
        ->middleware('permission:roles.edit')
        ->name('roles.permissions.update');

    Route::get('/permissions', [
        PermissionController::class,
        'index'
    ])
        ->middleware('permission:permissions.view')
        ->name('permissions.index');

    Route::post('/permissions', [
        PermissionController::class,
        'store'
    ])
        ->middleware('permission:permissions.manage')
        ->name('permissions.store');

    Route::get('/branches', [
        BranchController::class,
         'index'
    ])
        ->middleware('permission:branches.view')
        ->name('branches.index');
    
    Route::post('/branches', [BranchController::class, 'store'])
        ->middleware('permission:branches.create')
        ->name('branches.store');

    Route::get('/branches/{branch}/edit', [BranchController::class, 'edit'])
        ->middleware('permission:branches.edit')
        ->name('branches.edit');

    Route::put('/branches/{branch}', [BranchController::class, 'update'])
        ->middleware('permission:branches.edit')
        ->name('branches.update');

    Route::patch('/branches/{branch}/toggle-status', [BranchController::class, 'toggleStatus'])
        ->middleware('permission:branches.edit')
        ->name('branches.toggle-status');

});