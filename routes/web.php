<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
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

Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\Auth\ThirdPartyLoginController::class, 'redirect'])
    ->where('provider', 'mailru')
    ->name('third.party.redirect');
Route::get('/auth/{provider}/callback', [\App\Http\Controllers\Auth\ThirdPartyLoginController::class, 'callback'])
    ->where('provider', 'mailru');

Route::get('/', function () {
    return Inertia::render('Home', [
        'authUser' => Auth::user(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/task_statuses', [TaskStatusController::class, 'index'])->name('statuses.index');
Route::get('/labels', [LabelController::class, 'index'])->name('labels.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('task_statuses')->group(function () {
        Route::get('/create', [TaskStatusController::class, 'create'])->name('statuses.create');
        Route::post('/create', [TaskStatusController::class, 'store'])->name('statuses.store');
        Route::get('/{status}/edit', [TaskStatusController::class, 'edit'])->name('statuses.edit');
        Route::get('/{status}', [TaskStatusController::class, 'show'])->name('statuses.show');
        Route::patch('/{status}', [TaskStatusController::class, 'update'])->name('statuses.update');
        Route::delete('/{status}', [TaskStatusController::class, 'destroy'])->name('statuses.destroy');
    });

    Route::prefix('labels')->group(function () {
        Route::get('/create', [LabelController::class, 'create'])->name('labels.create');
        Route::post('/create', [LabelController::class, 'store'])->name('labels.store');
        Route::get('/{label}/edit', [LabelController::class, 'edit'])->name('labels.edit');
        Route::get('/{label}', [LabelController::class, 'show'])->name('labels.show');
        Route::patch('/{label}', [LabelController::class, 'update'])->name('labels.update');
        Route::delete('/{label}', [LabelController::class, 'destroy'])->name('labels.destroy');
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/create', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::get('/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::patch('/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });
});

require __DIR__.'/auth.php';
