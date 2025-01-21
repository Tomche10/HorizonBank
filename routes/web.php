<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankerController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\RedirectBasedOnRole;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/atms', function () {
    return view('atms');
})->name('atms');

Auth::routes();

Route::middleware(['auth' ])->group(function () {
    
    // User Dashboard
    Route::get('/user/dashboard', [DashboardController::class, 'index'])-> middleware(RedirectBasedOnRole::class)->name('dashboard');

    // Additional routes for all roles
    Route::get('/transfer', [TransferController::class, 'create'])->name('transfer.create');
    Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');

    Route::prefix('banker')->name('banker.')->group(function () {
        Route::get('/dashboard', [BankerController::class, 'index'])-> middleware(RedirectBasedOnRole::class)->name('dashboard');
        Route::get('/loans', [BankerController::class, 'viewLoans'])->name('loans');
        Route::post('/loans/{loan}/approve', [BankerController::class, 'approveLoan'])->name('loans.approve');
        Route::post('/loans/{loan}/reject', [BankerController::class, 'rejectLoan'])->name('loans.reject');
        Route::get('/transactions', [BankerController::class, 'viewTransactions'])->name('transactions');
        Route::get('/accounts', [BankerController::class, 'viewAccounts'])->name('accounts');
        Route::post('/transactions/{transaction}/undo', [BankerController::class, 'undoTransaction'])->name('transactions.undo');
        Route::post('/transactions/{transaction}/approve', [BankerController::class, 'approveTransaction'])->name('transactions.approve');
        Route::post('/transactions/{transaction}/reject', [BankerController::class, 'rejectTransaction'])->name('transactions.reject');


    });

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->middleware(RedirectBasedOnRole::class)->name('admin.dashboard');
    Route::delete('/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::post('/create-banker', [AdminController::class, 'createBanker'])->name('admin.createBanker');
});


});

