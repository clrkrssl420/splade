<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PermissionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'agent', 'as' => 'agent.', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        
        // Leads
        Route::post('leads/check', [LeadsController::class, 'check'])->name('leads.check');
        Route::get('leads/prospects', [LeadsController::class, 'prospects'])->name('leads.prospects');
        Route::get('leads/all', [LeadsController::class, 'all'])->name('leads.all');
        Route::resource('leads', LeadsController::class);
    });

    // Admin
    
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', function () {
                    return view('admin.dashboard');
                })->name('dashboard');

        Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
        Route::resource('permissions', PermissionsController::class);
    });
    
    Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

    require __DIR__.'/auth.php';
});
