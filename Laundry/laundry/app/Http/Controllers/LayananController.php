<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all();
        return view('layanan', compact('layanan'));
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
        ]);

        Layanan::create($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('layanan.show', compact('layanan'));
    }

    public function edit(string $id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('layanan_edit', compact('layanan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'estimasi' => 'nullable|numeric',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus');
    }
}
