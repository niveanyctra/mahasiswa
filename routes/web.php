<?php

use App\Http\Controllers\MahasiswaController;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $mahasiswa = Mahasiswa::all();
    return view('index', compact('mahasiswa'));
});

Route::controller(MahasiswaController::class)->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/destroy', 'destroy')->name('destroy');
});
