<?php

use App\Http\Controllers\CRUDController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.user');
Route::resource('/register', RegisterController::class);

Route::middleware(['authuser', 'admin'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/periode', [PageController::class, 'periode'])->name('periode');
    Route::get('/periode/create', [PageController::class, 'periodeCreate'])->name('periode.create');
    Route::get('/periode/{periode_id}/edit', [PageController::class, 'periodeEdit'])->name('periode.edit');
    Route::post('/periode/create', [CRUDController::class, 'periodeStore'])->name('periode.store');
    Route::put('/periode/{periode_id}/upated', [CRUDController::class, 'periodeUpdate'])->name('periode.update');
    Route::delete('/periode/{periode_id}/delete', [CRUDController::class, 'periodeDelete'])->name('periode.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';