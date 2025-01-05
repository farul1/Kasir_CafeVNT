<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogUserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::controller(LoginController::class)->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('/', 'index')->name('login');
        Route::post('/login', 'authenticate');
    });
    Route::get('/logout', 'logout')->middleware('auth');
});

// Dashboard & Profile Routes
Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.index');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/dashboard/profile', 'index')->name('dashboard.profile');
    });

    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::resource('/dashboard/users', UserController::class);
            Route::get('/users/export/excel', 'exportExcel')->name('users.export.excel');
            Route::get('/users/export/pdf', 'exportPDF')->name('users.export.pdf');
        });

        Route::controller(LogUserController::class)->group(function () {
            Route::get('/dashboard/log-users', 'index')->name('log-users.index');
        });
    });

    // Manager Routes
    Route::middleware('manager')->group(function () {
        // Menu Routes
        Route::controller(MenuController::class)->group(function () {
            Route::resource('/dashboard/menu', MenuController::class);
            Route::get('/menu/export/excel', 'exportExcel')->name('menu.export.excel');
            Route::get('/menu/export/pdf', 'exportPDF')->name('menu.export.pdf');
        });

        // Manager's Transaction Routes
        Route::controller(TransaksiController::class)->group(function () {
            Route::get('/dashboard/transaksi', 'index')->name('dashboard.transaksi');
            Route::get('/transaksi/export/excel', 'exportExcel')->name('transaksi.export.excel');
            Route::get('/transaksi/export/pdf', 'exportPDF')->name('transaksi.export.pdf');
        });
    });

    // Cashier Routes
    Route::controller(TransaksiController::class)->group(function () {
        Route::middleware('cashier')->group(function () {
            Route::resource('/dashboard/cashier', TransaksiController::class)->names([
                'index' => 'dashboard.cashier.index',
                'create' => 'dashboard.cashier.create',
                'store' => 'dashboard.cashier.store',
                'show' => 'dashboard.cashier.show',
                'edit' => 'dashboard.cashier.edit',
                'update' => 'dashboard.cashier.update',
                'destroy' => 'dashboard.cashier.destroy',
            ]);

            Route::get('/cashier/export/excel', 'exportExcel')->name('cashier.export.excel');
            Route::get('/cashier/export/pdf', 'exportPDF')->name('cashier.export.pdf');
        });

        // General transaction routes
        Route::get('/transactions', 'index')->name('transactions.index');
        Route::get('/transaction/{transaksi}/pay', 'qrPayment')->name('transaction.pay');
        Route::get('/transaction/qr/{transaksi}', 'generateQR')->name('transaction.qr');
    });

    // API Routes
    Route::prefix('api')->group(function () {
        Route::post('/create-transaction', [TransaksiController::class, 'createTransaction'])
            ->name('api.create-transaction');
    });
});

// Midtrans Callback
Route::post('/midtrans/callback', [PaymentController::class, 'midtransCallback'])
    ->name('midtrans.callback');

    Route::get('/transaksi/{transaksi_id}', [TransaksiController::class, 'showTransaksi']);
    Route::delete('/dashboard/cashier/{id}', [TransaksiController::class, 'destroy'])->name('cashier.destroy');
    Route::get('/dashboard/cashier/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/dashboard/cashier/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
