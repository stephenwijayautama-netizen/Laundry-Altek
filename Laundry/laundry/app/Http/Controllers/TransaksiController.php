<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Detail_Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['pelanggan', 'detailTransaksi.layanan'])->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $layanan = Layanan::all();
        return view('pos', compact('pelanggan', 'layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'metode_pembayaran' => 'required',
            'items' => 'required|array',
            'items.*.layanan_id' => 'required',
            'items.*.qty' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $kode = 'TRX-' . strtoupper(uniqid());

            $transaksi = Transaksi::create([
                'pelanggan_id' => $request->pelanggan_id,
                'user_id' => Auth::id() ?? 1,
                'kode_transaksi' => $kode,
                'tanggal_masuk' => now(),
                'total_harga' => 0, // Akan diupdate setelah hitung item
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => $request->status_pembayaran ?? 'belum_lunas',
                'tipe_transaksi' => $request->tipe_transaksi ?? 'regular',
                'status' => 'pending',
                'catatan' => $request->catatan,
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $layanan = Layanan::findOrFail($item['layanan_id']);
                $subtotal = $layanan->harga * $item['qty'];
                
                Detail_Transaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'layanan_id' => $layanan->id,
                    'qty' => $item['qty'],
                    'harga_satuan' => $layanan->harga,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $transaksi->update(['total_harga' => $total]);

            DB::commit();
            
            if ($request->metode_pembayaran === 'qris') {
                return redirect()->route('doku.qris', $transaksi->id);
            }
            
            return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Transaksi berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'detailTransaksi.layanan'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($request->only(['status', 'status_pembayaran', 'tanggal_selesai']));

        return redirect()->route('transaksi.index')->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
