<?php

use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('resep.index');
});

Route::resource('resep', ResepController::class)->except(['edit', 'update', 'destroy']);
Route::get('resep/{resep}/print', [ResepController::class, 'print'])->name('resep.print');
// Tambahan route untuk hapus satu resep
Route::delete('resep/{resep}', [ResepController::class, 'destroy'])->name('resep.destroy');

// Tambahan route untuk hapus semua resep
Route::delete('resep', [ResepController::class, 'hapusSemua'])->name('resep.hapusSemua');
