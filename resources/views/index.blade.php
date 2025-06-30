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
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-graduation-cap"></i> Sistem Manajemen Mahasiswa</h1>
            <p>Platform modern untuk mengelola data mahasiswa dengan mudah dan efisien</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3 id="totalStudents">0</h3>
                <p>Total Mahasiswa</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-user-check"></i>
                <h3 id="activeStudents">0</h3>
                <p>Mahasiswa Aktif</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-building"></i>
                <h3 id="totalJurusan">0</h3>
                <p>Total Jurusan</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-chart-line"></i>
                <h3 id="newStudents">0</h3>
                <p>Mahasiswa Baru</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Controls -->
            <div class="controls">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari mahasiswa berdasarkan nama atau NIM...">
                    <i class="fas fa-search"></i>
                </div>
                <select id="jurusanFilter" class="filter-select">
                    <option value="">Semua Jurusan</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Teknik Komputer">Teknik Komputer</option>
                    <option value="Manajemen Informatika">Manajemen Informatika</option>
                </select>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"
                    id="addStudentButton">
                    <i class="fas fa-plus"></i> Tambah Mahasiswa
                </button>
            </div>

            <!-- Table -->
            <div class="table-container" id="tableContainer">
                <table id="studentsTable">
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

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <i class="fas fa-user-graduate"></i>
                <h3>Belum ada data mahasiswa</h3>
                <p>Klik tombol "Tambah Mahasiswa" untuk menambah data pertama</p>
            </div>
        </div>
    </div>

    @include('mahasiswa.create')
    @include('mahasiswa.edit')

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
