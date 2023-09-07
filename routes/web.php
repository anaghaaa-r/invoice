<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/invoice', function () {
    return view('invoice');
})->middleware(['auth', 'verified'])->name('invoice');

Route::get('/invoice-list', [InvoiceController::class, 'viewInvoice'])->middleware('auth')->name('invoice.list');

Route::post('/save', [InvoiceController::class, 'save'])->middleware('auth')->name('invoice.save');
Route::post('/edit/{id}', [InvoiceController::class, 'edit'])->middleware('auth')->name('invoice.edit');
Route::delete('/delete/{id}', [InvoiceController::class, 'delete'])->middleware('auth')->name('invoice.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
