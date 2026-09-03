@extends('layouts.app')

@section('title', 'Kelola Pengembalian')

@section('header-title', 'Manajemen Transaksi Pengembalian')

@section('content')

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header Card -->
        <div class="p-5 border-b border-gray-200 flex items-center justify-between gap-4">

            <h2 class="text-xl font-bold text-gray-800">
                Daftar Transaksi Pengembalian
            </h2>

            <div class="flex items-center gap-3">

                <!-- Search -->
                <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="flex">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama peminjam..."
                        class="w-80 px-4 py-2.5 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-gray-800 text-white font-semibold rounded-r-lg hover:bg-gray-700">
                        Cari
                    </button>

                </form>

                <!-- Tambah -->
                <a
                    href="{{ route('admin.pengembalian.create') }}"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    + Tambah Pengembalian
                </a>

            </div>

        </div>


        <!-- Tabel -->
        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-5 py-4 text-sm font-bold text-gray-600">
                            PEMINJAM
                        </th>

                        <th class="px-5 py-4 text-sm font-bold text-gray-600">
                            ALAT YANG DIKEMBALIKAN
                        </th>

                        <th class="px-5 py-4 text-sm font-bold text-gray-600">
                            TGL KEMBALI
                        </th>

                        <th class="px-5 py-4 text-sm font-bold text-gray-600">
                            KONDISI
                        </th>

                        <th class="px-5 py-4 text-sm font-bold text-gray-600">
                            DENDA
                        </th>

                        <th class="px-5 py-4 text-sm font-bold text-gray-600">
                            PETUGAS
                        </th>

                        <th class="px-5 py-4 text-sm font-bold text-gray-600">
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($pengembalians as $pengembalian)

                        <tr class="border-t border-gray-200">

                            <!-- Peminjam -->
                            <td class="px-5 py-5 align-top">

                                <div class="font-semibold text-gray-800">
                                    {{ $pengembalian->peminjaman->user->name ?? '-' }}
                                </div>

                            </td>


                            <!-- Alat -->
                            <td class="px-5 py-5 align-top">

                                <ul class="list-disc pl-5 space-y-2">

                                    @foreach($pengembalian->peminjaman->detailPinjam as $detail)

                                        <li class="text-gray-700">

                                            {{ $detail->alat->nama_alat ?? '-' }}

                                            <span class="ml-1 px-2 py-1 text-xs bg-gray-200 text-gray-600 rounded">
                                                {{ $detail->jumlah }} pcs
                                            </span>

                                        </li>

                                    @endforeach

                                </ul>

                            </td>


                            <!-- Tanggal -->
                            <td class="px-5 py-5 align-top text-gray-600">

                                {{ $pengembalian->tgl_kembali?->format('Y-m-d') ?? '-' }}

                            </td>


                            <!-- Kondisi -->
                            <td class="px-5 py-5 align-top">

                                <span class="inline-block px-3 py-2 rounded-full text-sm font-semibold
                                    bg-green-100 text-green-700">

                                    {{ $pengembalian->kondisi_kembali }}

                                </span>

                            </td>


                            <!-- Denda -->
                            <td class="px-5 py-5 align-top font-semibold text-gray-700">

                                Rp {{ number_format($pengembalian->denda ?? 0, 0, ',', '.') }}

                            </td>


                            <!-- Petugas -->
                            <td class="px-5 py-5 align-top text-gray-700">

                                {{ $pengembalian->petugas->name ?? '-' }}

                            </td>


                            <!-- Aksi -->
                            <td class="px-5 py-5 align-top">

                                <div class="flex flex-col gap-2">

                                    <!-- Detail -->
                                    <a
                                        href="{{ route('admin.pengembalian.show', $pengembalian) }}"
                                        class="px-3 py-2 text-center text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">
                                        Detail
                                    </a>

                                    <!-- Edit -->
                                    <a
                                        href="{{ route('admin.pengembalian.edit', $pengembalian) }}"
                                        class="px-3 py-2 text-center text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                                        Edit
                                    </a>

                                    <!-- Hapus -->
                                    <form
                                        action="{{ route('admin.pengembalian.destroy', $pengembalian) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data pengembalian ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="w-full px-3 py-2 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-5 py-10 text-center text-gray-500">

                                Belum ada data pengembalian.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->
        @if($pengembalians->hasPages())

            <div class="p-5 border-t border-gray-200">
                {{ $pengembalians->links() }}
            </div>

        @endif

    </div>

@endsection