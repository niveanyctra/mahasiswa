<!-- Modal tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Mahasiswa Baru</h1>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('mahasiswa.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nim">NIM *</label>
                            <input type="text" id="nim" name="nim" required placeholder="202X0XXXXX">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap *</label>
                            <input type="text" id="nama" name="nama" required
                                placeholder="Nama lengkap mahasiswa">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="jurusan">Jurusan *</label>
                            <select id="jurusan" name="jurusan" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                                <option value="Teknik Komputer">Teknik Komputer</option>
                                <option value="Manajemen Informatika">Manajemen Informatika</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="angkatan">Angkatan *</label>
                            <input type="number" id="angkatan" name="angkatan" required placeholder="2024"
                                min="2015" max="2030">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required
                                placeholder="mahasiswa@email.com">
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="tel" id="telepon" name="telepon" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap mahasiswa"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select id="status" name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Lulus">Lulus</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ipk">IPK</label>
                            <input type="number" id="ipk" name="ipk" step="0.01" min="0"
                                max="4" placeholder="3.50">
                        </div>
                    </div>

                    <div style="text-align: right; margin-top: 30px;">
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background: #6c757d; color: white; margin-right: 10px;">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
