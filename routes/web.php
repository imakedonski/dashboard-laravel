<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use App\Models\Link;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    Link::withPosition();
    return view('dashboard',
        ['links' => Link::withPosition()]
    );
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/link/create/{position}', [LinkController::class, 'create'])->name('link.create');
    Route::post('/link/store', [LinkController::class, 'store'])->name('link.store');
    Route::get('/link/edit/{id}', [LinkController::class, 'edit'])->name('link.edit');
    Route::post('/link/update', [LinkController::class, 'update'])->name('link.update');
    Route::post('/link/destroy', [LinkController::class, 'destroy'])->name('link.destroy');
});

require __DIR__.'/auth.php';
