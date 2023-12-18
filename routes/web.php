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
    Route::get('/kriteria-all', [PageController::class, 'kriteria'])->name('kriteria');
    Route::get('/kriteria-all/create', [PageController::class, 'kriteriaCreate'])->name('kriteria.create');
    Route::get('/kriteria-all/{kriteria_id}/edit', [PageController::class, 'kriteriaEdit'])->name('kriteria.edit');
    Route::post('/kriteria-all/create', [CRUDController::class, 'kriteriaStore'])->name('kriteria.store');
    Route::put('/kriteria-all/{kriteria_id}/upated', [CRUDController::class, 'kriteriaUpdate'])->name('kriteria.update');
    Route::delete('/kriteria-all/{kriteria_id}/delete', [CRUDController::class, 'kriteriaDelete'])->name('kriteria.delete');
    Route::get('/kriteria-nilai-bobot', [PageController::class, 'kriteriaNilaiBobot'])->name('kriteria.nilai.bobot');
    Route::put('/kriteria-nilai-bobot/upated', [CRUDController::class, 'kriteriaNilaiBobotUpdate'])->name('kriteria.nilai.bobot.update');
    Route::get('/alternatif-all', [PageController::class, 'alternatif'])->name('alternatif');
    Route::get('/alternatif-all/create', [PageController::class, 'alternatifCreate'])->name('alternatif.create');
    Route::get('/alternatif-all/{alternatif_id}/edit', [PageController::class, 'alternatifEdit'])->name('alternatif.edit');
    Route::post('/alternatif-all/create', [CRUDController::class, 'alternatifStore'])->name('alternatif.store');
    Route::put('/alternatif-all/{alternatif_id}/upated', [CRUDController::class, 'alternatifUpdate'])->name('alternatif.update');
    Route::delete('/alternatif-all/{alternatif_id}/delete', [CRUDController::class, 'alternatifDelete'])->name('alternatif.delete');
    Route::get('/alternatif-nilai-bobot', [PageController::class, 'alternatifNilaiBobot'])->name('alternatif.nilai.bobot');
    Route::get('/alternatif-nilai-bobot/{id}/edit', [PageController::class, 'alternatifNilaiBobotEdit'])
    ->name('alternatif.nilai.bobot.edit');
    Route::put('/alternatif-nilai-bobot/{id}', [CRUDController::class, 'alternatifNilaiBobotUpdate'])
    ->name('alternatif.nilai.bobot.update');
    Route::get('/perhitungan/{selected_periode?}', [PageController::class, 'perhitungan'])->name('perhitungan');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
