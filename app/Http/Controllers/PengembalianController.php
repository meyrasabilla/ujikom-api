<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Http\Requests\Pengembalian\StorePengembalianRequest;
use App\Http\Requests\Pengembalian\UpdatePengembalianRequest;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detailPinjam.alat',
            'petugas'
        ])->latest();

        // Pencarian berdasarkan nama peminjam
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('peminjaman.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        //ubah denda
        Pengembalian::where('denda', 0)->update([
            'denda' => 50000,
        ]);

        $pengembalians = $query->paginate(10)->withQueryString();

        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        // Hanya menampilkan peminjaman yang masih dipinjam
        // dan belum memiliki data pengembalian
        $peminjamans = Peminjaman::with([
            'user',
            'detailPinjam.alat'
        ])
        ->where('status', 'dipinjam')
        ->whereDoesntHave('pengembalian')
        ->latest()
        ->get();

        return view('admin.pengembalian.create', compact('peminjamans'));
    }

    public function store(StorePengembalianRequest $request)
    {
        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        // Cek apakah peminjaman sudah memiliki pengembalian
        if ($peminjaman->pengembalian) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Peminjaman ini sudah memiliki data pengembalian.'
                );
        }

        // Simpan data pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_kembali' => now(),
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda' => $request->denda ?? 0,
            'petugas_id' => auth()->id(),
        ]);

        // Ubah status peminjaman menjadi dikembalikan
        $peminjaman->update([
            'status' => 'dikembalikan',
        ]);

        return redirect()
            ->route('admin.pengembalian.index')
            ->with(
                'success',
                'Data pengembalian berhasil ditambahkan.'
            );
    }

    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load([
            'peminjaman.user',
            'peminjaman.detailPinjam.alat',
            'petugas'
        ]);

        return view(
            'admin.pengembalian.show',
            compact('pengembalian')
        );
    }

    public function edit(Pengembalian $pengembalian)
    {
        $pengembalian->load([
            'peminjaman.user',
            'peminjaman.detailPinjam.alat'
        ]);

        return view(
            'admin.pengembalian.edit',
            compact('pengembalian')
        );
    }

    public function update(
        UpdatePengembalianRequest $request,
        Pengembalian $pengembalian
    ) {
        $pengembalian->update([
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda' => $request->denda ?? 0,
        ]);

        return redirect()
            ->route('admin.pengembalian.index')
            ->with(
                'success',
                'Data pengembalian berhasil diperbarui.'
            );
    }

    public function destroy(Pengembalian $pengembalian)
    {
        // Ambil data peminjaman sebelum pengembalian dihapus
        $peminjaman = $pengembalian->peminjaman;

        // Hapus data pengembalian
        $pengembalian->delete();

        // Kembalikan status peminjaman menjadi dipinjam
        if ($peminjaman) {
            $peminjaman->update([
                'status' => 'dipinjam',
            ]);
        }

        return redirect()
            ->route('admin.pengembalian.index')
            ->with(
                'success',
                'Data pengembalian berhasil dihapus.'
            );
    }
}