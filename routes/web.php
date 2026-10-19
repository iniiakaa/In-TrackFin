<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tracking Resi
    Route::resource('resi', ResiController::class);
    Route::patch('/resi/{resi}/status', [ResiController::class, 'updateStatus'])->name('resi.updateStatus');
    Route::get('/resi/export/csv', [ResiController::class, 'exportCsv'])->name('resi.exportCsv');
    Route::get('/resi/export/pdf', [ResiController::class, 'exportPdf'])->name('resi.exportPdf');


    // Keuangan
    Route::resource('expenses', ExpenseController::class)->except(['show']);
    Route::resource('incomes', IncomeController::class)->except(['show']);

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');

    // Manajemen Akun (hanya Kepala Cabang)
    Route::resource('users', UserController::class)->except(['show']);

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
