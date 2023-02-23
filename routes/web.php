<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\ProfileController;

// Admin
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

    
    Route::group(['prefix' => 'agent', 'as' => 'agent.', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', function () {
            return view('agent.dashboard');
        })->name('dashboard');
        
        // Leads
        Route::post('leads/check', [LeadsController::class, 'check'])->name('leads.check');
        Route::get('leads/prospects', [LeadsController::class, 'prospects'])->name('leads.prospects');
        Route::get('leads/all', [LeadsController::class, 'all'])->name('leads.all');
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

        // Permissions
        Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
        Route::resource('permissions', PermissionsController::class);

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
    });
    
    Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

    require __DIR__.'/auth.php';
});
