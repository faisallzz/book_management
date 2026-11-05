<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/books', [BookController::class, 'index'])
        ->middleware('permission:lihat buku')->name('books.index');

    // /books/create harus di atas /books/{book}/edit agar tidak bentrok
    Route::get('/books/create', [BookController::class, 'create'])
        ->middleware('permission:tambah buku')->name('books.create');

    Route::post('/books', [BookController::class, 'store'])
        ->middleware('permission:tambah buku')->name('books.store');

    Route::get('/books/{book}/edit', [BookController::class, 'edit'])
        ->middleware('permission:edit buku')->name('books.edit');

    Route::put('/books/{book}', [BookController::class, 'update'])
        ->middleware('permission:edit buku')->name('books.update');

    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->middleware('permission:hapus buku')->name('books.destroy');
});

// ===== Kelola role (hanya yang punya permission 'kelola role' = Admin) =====
Route::middleware(['auth', 'permission:kelola role'])->group(function () {
    Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role');
});

require __DIR__.'/auth.php';
