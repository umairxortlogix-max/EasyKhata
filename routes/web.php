<?php

use App\Http\Controllers\ClientControllers;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/cache', function () {
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    return '<h3>Caches have been cleared successfully!</h3>';
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    route::get('customer', [ClientControllers::class, 'custm']);
    route::get('customer2', [ClientControllers::class, 'custm2']);
});
route::get('user', [ClientControllers::class, 'index'])->name('user');

Route::middleware(['auth', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('clients', ClientControllers::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{customer}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{customer}/export-pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export-pdf');
    Route::post('/transactions/{customer}/send-whatsapp', [TransactionController::class, 'sendWhatsAppPdf'])->name('transactions.send-whatsapp');

    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::put('/customers/{id}/update-ajax', [CustomerController::class, 'update'])
        ->name('customers.update.ajax');

    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});
require __DIR__ . '/auth.php';
