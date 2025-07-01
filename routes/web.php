<?php

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function (Request $request) {
    $search = $request->get('search');

    $query = Mahasiswa::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'LIKE', '%' . $search . '%')
                ->orWhere('nim', 'LIKE', '%' . $search . '%')
                ->orWhere('jurusan', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        });
    }

    $mahasiswa = $query->get();

    $allMahasiswa = $search ? Mahasiswa::all() : $mahasiswa;
    $totalMahasiswa = $allMahasiswa->count();
    $totalAktif = $allMahasiswa->where('status', 'Aktif')->count();
    $mahasiswaBaru = $allMahasiswa->where('angkatan', date('Y'))->count();

    return view('index', compact(
        'mahasiswa',
        'totalMahasiswa',
        'totalAktif',
        'mahasiswaBaru',
        'search'
    ));
})->name('home');

Route::get('/reset', function () {
    return redirect()->route('home');
})->name('reset.search');

Route::controller(MahasiswaController::class)->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/destroy', 'destroy')->name('destroy');
});
