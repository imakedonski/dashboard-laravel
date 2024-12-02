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
});

Route::get('/link/create/{position}', [LinkController::class, 'create'])
    ->middleware('auth')
    ->name('link.create');
Route::resource('link', LinkController::class)
    ->except(['index', 'create'])
    ->middleware('auth');

require __DIR__.'/auth.php';
