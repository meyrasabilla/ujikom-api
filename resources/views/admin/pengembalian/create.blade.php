@extends('layouts.app')

@section('title', 'Tambah Pengembalian')

@section('header-title', 'Tambah Data Pengembalian')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Form Pengembalian
        </h2>

        @if(session('error'))
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pengembalian.store') }}" method="POST">
            @csrf

            <!-- Peminjaman -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Peminjaman
                </label>

                <select
                    name="peminjaman_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-gray-400 focus:outline-none"
                    required
                >
                    <option value="">-- Pilih Peminjaman --</option>

                    @foreach($peminjamans as $peminjaman)
                        <option
                            value="{{ $peminjaman->id }}"
                            {{ old('peminjaman_id') == $peminjaman->id ? 'selected' : '' }}
                        >
                            #{{ $peminjaman->id }}
                            - {{ $peminjaman->user->name ?? '-' }}
                            -
                            {{ $peminjaman->tgl_pinjam?->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Kondisi Kembali -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kondisi Barang Kembali
                </label>

                <input
                    type="text"
                    name="kondisi_kembali"
                    value="{{ old('kondisi_kembali') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-gray-400 focus:outline-none"
                    placeholder="Contoh: Baik, Rusak Ringan, Rusak Berat"
                    required
                >
            </div>

            <!-- Denda -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Denda
                </label>

                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500">
                        Rp
                    </span>

                    <input
                        type="number"
                        name="denda"
                        value="{{ old('denda', 50000) }}"
                        min="0"
                        class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2.5 focus:ring-2 focus:ring-gray-400 focus:outline-none"
                        placeholder="50000"
                    >
                </div>

                <p class="text-xs text-gray-500 mt-1">
                    Masukkan nominal denda tanpa titik.
                </p>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('admin.pengembalian.index') }}"
                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-gray-800 hover:bg-gray-900 text-white rounded-lg transition"
                >
                    Simpan Pengembalian
                </button>

            </div>

        </form>

    </div>

</div>

@endsection