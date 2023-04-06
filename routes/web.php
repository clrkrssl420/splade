<?php

use Illuminate\Support\Facades\Route;

// Agent
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\ProfileController;

// Admin
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\AdminProfileController;

Route::middleware('splade')->group(function () {
    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('/dashboard', function () {
        $prefix = auth()->user()->is_admin ? 'admin' : 'agent';
        return redirect()->route($prefix . '.dashboard');
    })->name('dashboard');

    
    Route::group(['prefix' => 'agent', 'as' => 'agent.', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', function () {
            return view('agent.dashboard');
        })->name('dashboard');
        
        // Leads
        Route::post('leads/check', [LeadsController::class, 'check'])->name('leads.check');
        Route::get('leads/recent', [LeadsController::class, 'recent'])->name('leads.recent');
        Route::get('leads/prospects', [LeadsController::class, 'prospects'])->name('leads.prospects');
        Route::get('leads/all', [LeadsController::class, 'all'])->name('leads.all');
        Route::get('leads/team', [LeadsController::class, 'team'])->name('leads.team');
        Route::resource('leads', LeadsController::class);

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Admin
    
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/dashboard', function () {
                    return view('admin.dashboard');
                })->name('dashboard');

        // Users
        Route::resource('users', UsersController::class);
        
        // Roles
        Route::resource('roles', RolesController::class);

        // Permissions
        Route::resource('permissions', PermissionsController::class);

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
});
