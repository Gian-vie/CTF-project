<?php

use App\Http\Controllers\JudgeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/judge', [JudgeController::class, 'index'])->name('judge');
Route::post('/judge', [JudgeController::class, 'submit'])->name('judge.submit');

// DAADS Bank
use App\Http\Controllers\Bank\BankAuthController;
use App\Http\Controllers\Bank\BankDashboardController;
use App\Http\Controllers\Bank\BankProfileController;
use App\Http\Controllers\Bank\BankCaixinhaController;

Route::prefix('bank')->group(function () {
    // Auth (sem middleware)
    Route::get('/login', [BankAuthController::class, 'showLogin'])->name('bank.login');
    Route::post('/login', [BankAuthController::class, 'login'])->name('bank.login.submit');
    Route::post('/logout', [BankAuthController::class, 'logout'])->name('bank.logout');

    // Rotas protegidas
    Route::middleware('bank.auth')->group(function () {
        Route::get('/', [BankDashboardController::class, 'index'])->name('bank.dashboard');
        Route::get('/profile', [BankProfileController::class, 'index'])->name('bank.profile');
        Route::post('/profile', [BankProfileController::class, 'update'])->name('bank.profile.update');
        Route::post('/profile/password-request', [BankProfileController::class, 'passwordRequest'])->name('bank.profile.password.request');
        Route::post('/profile/password-confirm', [BankProfileController::class, 'passwordConfirm'])->name('bank.profile.password.confirm');
        Route::post('/profile/password-resend', [BankProfileController::class, 'passwordResend'])->name('bank.profile.password.resend');
        Route::post('/profile/password-cancel', [BankProfileController::class, 'passwordCancel'])->name('bank.profile.password.cancel');
        Route::get('/caixinha', [BankCaixinhaController::class, 'index'])->name('bank.caixinha');
        Route::post('/caixinha/depositar', [BankCaixinhaController::class, 'deposit'])->name('bank.caixinha.deposit');
        Route::post('/caixinha/resgatar', [BankCaixinhaController::class, 'withdraw'])->name('bank.caixinha.withdraw');
    });
});
