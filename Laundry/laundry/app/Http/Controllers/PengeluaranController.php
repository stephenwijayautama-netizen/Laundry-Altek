<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('keterangan', 'like', "%{$request->search}%");
        }

        $pengeluaran = $query->latest('tanggal')->get();
        return view('pengeluaran', compact('pengeluaran'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required',
            'keterangan' => 'nullable',
            'jumlah' => 'required|numeric',
        ]);

        Pengeluaran::create([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'user_id' => Auth::id() ?? 1,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dicatat');
    }

    public function show(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('pengeluaran.show', compact('pengeluaran'));
    }

    public function edit(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_pengeluaran' => 'required|date',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($request->all());

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus');
    }
}
