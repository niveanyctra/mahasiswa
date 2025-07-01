<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Mahasiswa</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-graduation-cap"></i> Sistem Manajemen Mahasiswa</h1>
            <p>Platform modern untuk mengelola data mahasiswa dengan mudah dan efisien</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3 id="totalStudents">{{ $totalMahasiswa }}</h3>
                <p>Total Mahasiswa</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-user-check"></i>
                <h3 id="activeStudents">{{ $totalAktif }}</h3>
                <p>Mahasiswa Aktif</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-chart-line"></i>
                <h3 id="newStudents">{{ $mahasiswaBaru }}</h3>
                <p>Mahasiswa Baru</p>
            </div>
        </div>

        <div class="main-content">
            <div class="controls">
                <div class="search-box">
                    <form method="GET" action="{{ route('home') }}" id="searchForm"
                        class="d-flex align-items-center gap-2">
                        <div class="search-box position-relative">
                            <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}"
                                placeholder="Ketik untuk mencari (nama, NIM, jurusan, email)..." class="form-control"
                                autocomplete="off">
                            <i class="fas fa-search position-absolute"
                                style="right: 20px; top: 50%; transform: translateY(-50%); color: #666;"></i>
                        </div>
                        @if ($search)
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                                &times; Reset
                            </a>
                        @endif
                    </form>
                </div>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Mahasiswa
                </button>
            </div>

            @if ($search)
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i>
                    Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong>
                    - Ditemukan {{ $mahasiswa->count() }} data
                </div>
            @endif

            <div id="loadingIndicator" class="text-center py-2" style="display: none;">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span class="ms-2">Mencari...</span>
            </div>

            @if ($mahasiswa->count() > 0)
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $data)
                                <tr>
                                    <td>{{ $data->nim }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->jurusan }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->telepon }}</td>
                                    <td>
                                        @if ($data->status == 'Aktif')
                                            <span class="badge bg-success">{{ $data->status }}</span>
                                        @elseif ($data->status == 'Tidak Aktif')
                                            <span class="badge bg-danger">{{ $data->status }}</span>
                                        @elseif ($data->status == 'Cuti')
                                            <span class="badge bg-info">{{ $data->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $data->status }}</span>
                                        @endif
                                    </td>
                                    <td class="d-flex gap-1">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $data->id }}">
                                            <i class="fas fa-pencil"></i> Edit
                                        </button>
                                        <form action="{{ route('mahasiswa.destroy', $data->id) }}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-user-graduate fa-5x text-muted mb-3"></i>
                    @if ($search)
                        <h3>Tidak ada hasil pencarian</h3>
                        <p>Tidak ditemukan mahasiswa dengan kata kunci "<strong>{{ $search }}</strong>"</p>
                        <p>Coba gunakan kata kunci yang berbeda atau <a href="{{ route('home') }}">lihat semua data</a>
                        </p>
                    @else
                        <h3>Belum ada data mahasiswa</h3>
                        <p>Klik tombol "Tambah Mahasiswa" untuk menambah data pertama</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @include('mahasiswa.create')
    @include('mahasiswa.edit')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            const loadingIndicator = document.getElementById('loadingIndicator');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                loadingIndicator.style.display = 'block';

                searchTimeout = setTimeout(function() {
                    searchForm.submit();
                }, 500);
            });

            window.addEventListener('load', function() {
                loadingIndicator.style.display = 'none';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
