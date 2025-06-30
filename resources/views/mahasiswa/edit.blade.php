@foreach ($mahasiswa as $data)
    <!-- Modal tambah -->
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-labelledby="studentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Mahasiswa</h1>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('mahasiswa.update', $data->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label">NIM *</label>
                                <input type="text" class="form-control" id="nim" name="nim" required
                                    placeholder="202X0XXXXX" value="{{ old('nim', $data->nim) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" name="nama" required
                                    placeholder="Nama lengkap mahasiswa" value="{{ old('nama', $data->nama) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jurusan" class="form-label">Jurusan *</label>
                                <select class="form-select" id="jurusan" name="jurusan" required>
                                    <option value="Teknik Informatika" {{ old('jurusan', $data->jurusan) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                    <option value="Sistem Informasi" {{ old('jurusan', $data->jurusan) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                    <option value="Teknik Komputer" {{ old('jurusan', $data->jurusan) == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                                    <option value="Manajemen Informatika" {{ old('jurusan', $data->jurusan) == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen Informatika</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="angkatan" class="form-label">Angkatan *</label>
                                <input type="number" class="form-control" id="angkatan" name="angkatan" required
                                    placeholder="2024" min="2015" max="2030"
                                    value="{{ old('angkatan', $data->angkatan) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="mahasiswa@email.com" value="{{ old('email', $data->email) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="tel" class="form-control" id="telepon" name="telepon"
                                    placeholder="08xxxxxxxxxx" value="{{ old('telepon', $data->telepon) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                placeholder="Alamat lengkap mahasiswa">{{ old('alamat', $data->alamat) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Aktif" {{ old('status', $data->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status', $data->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="Cuti" {{ old('status', $data->status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="Lulus" {{ old('status', $data->status) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ipk" class="form-label">IPK</label>
                                <input type="number" step="0.01" min="0" max="4" class="form-control" id="ipk"
                                    name="ipk" placeholder="3.50" value="{{ old('ipk', $data->ipk) }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
