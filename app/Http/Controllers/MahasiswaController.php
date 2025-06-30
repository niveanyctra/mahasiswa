<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:'.date('Y'),
            'email' => 'required|email|unique:mahasiswas,email',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|string|in:Aktif,Tidak Aktif,Cuti,Lulus',
            'ipk' => 'nullable|numeric|min:0|max:4.0',
        ]);

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'ipk' => $request->ipk,
        ]);
        return redirect()->back()->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->nim);
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $id,
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:'.date('Y'),
            'email' => 'required|email|unique:mahasiswas,email,' . $id,
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|string|in:Aktif,Tidak Aktif,Cuti,Lulus',
            'ipk' => 'nullable|numeric|min:0|max:4.0',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->jurusan = $request->jurusan;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->email = $request->email;
        $mahasiswa->telepon = $request->telepon;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->status = $request->status;
        $mahasiswa->ipk = $request->ipk;
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        // Delete photo if exists
        if ($mahasiswa->foto) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }
        $mahasiswa->delete();
        return redirect()->back()->with('success', 'Post deleted successfully!');
    }
}
