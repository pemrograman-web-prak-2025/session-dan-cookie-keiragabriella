<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaterLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // ✅ Diperlukan untuk Auth::check()

// ✅ MODIFIKASI: Mengarahkan rute utama ('/')
Route::get('/', function () {
    // Cek apakah pengguna sudah login
    if (Auth::check()) {
        // Jika sudah login, arahkan ke Dashboard
        return redirect()->route('dashboard');
    }
    // Jika belum login, arahkan ke halaman Login
    return redirect()->route('login');
});

// Rute Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rute Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute CRUD Water Log (sudah ada)
    Route::resource('water-logs', WaterLogController::class); 

});

require __DIR__.'/auth.php';
