<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Home', [
        'authUser' => Auth::user(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/task_statuses', [TaskStatusController::class, 'index'])->name('statuses');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('task_statuses')->group(function () {
        Route::get('/create', [TaskStatusController::class, 'create'])->name('statuses.create');
        Route::post('/create', [TaskStatusController::class, 'store'])->name('statuses.store');
        Route::get('/{id}/edit', [TaskStatusController::class, 'edit'])->name('statuses.edit');
        Route::get('/{id}', [TaskStatusController::class, 'show'])->name('statuses.show');
        Route::patch('/{id}', [TaskStatusController::class, 'update'])->name('statuses.update');
    });
});

require __DIR__.'/auth.php';
