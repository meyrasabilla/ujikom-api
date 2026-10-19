
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a href="{{ route('peminjam.katalog') }}" class="navbar-brand">Panel Peminjam</a>
        <div>
            <a href="{{ route('peminjam.katalog') }}" class="btn btn-outline-light btn-sm">Katalog Alat</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-light btn-sm text-primary">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h3 class="mb-3">Riwayat Peminjaman Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tgl_pinjam }}</td>
                            <td>{{ $item->tgl_kembali_plan }}</td>
                            <td>
                                @forelse($item->detailPinjams as $detail)
                                    {{ $detail->alat->nama_alat ?? '-' }}<br>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>
                                @forelse($item->detailPinjams as $detail)
                                    {{ $detail->jumlah }}<br>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>{{ ucfirst($item->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
x</html>
