<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'detailTransaksi.layanan']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_masuk', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'pending') {
                $query->where(function($q) {
                    $q->where('status', 'pending')
                      ->orWhereHas('pelanggan', function($pq) {
                          $pq->where('status', 'antrean');
                      });
                });
            } elseif ($status === 'proses') {
                $query->where(function($q) {
                    $q->where('status', 'proses')
                      ->orWhereHas('pelanggan', function($pq) {
                          $pq->whereIn('status', ['dicuci', 'siap diambil']);
                      });
                });
            } elseif ($status === 'selesai') {
                $query->where(function($q) {
                    $q->where('status', 'selesai')
                      ->orWhereHas('pelanggan', function($pq) {
                          $pq->where('status', 'selesai');
                      });
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%$search%")
                  ->orWhereHas('pelanggan', function($sq) use ($search) {
                      $sq->where('nama', 'like', "%$search%");
                  });
            });
        }

        $transaksi = $query->latest()->get();

        // Fetch Expenses
        $expenseQuery = Pengeluaran::query();
        if ($request->filled('from') && $request->filled('to')) {
            $expenseQuery->whereBetween('tanggal', [$request->from, $request->to]);
        }
        if ($request->filled('search')) {
            $expenseQuery->where('keterangan', 'like', "%{$request->search}%");
        }
        $pengeluaran = $expenseQuery->latest()->get();

        return view('laporan', compact('transaksi', 'pengeluaran'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $total_pendapatan = Transaksi::whereBetween('tanggal_masuk', [$request->tanggal_awal, $request->tanggal_akhir])
            ->where('status_pembayaran', 'lunas')
            ->sum('total_harga');

        $total_pengeluaran = Pengeluaran::whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
            ->sum('jumlah');

        $laba = $total_pendapatan - $total_pengeluaran;

        Laporan::create([
            'created_by' => Auth::id() ?? 1,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'total_pendapatan' => $total_pendapatan,
            'total_pengeluaran' => $total_pengeluaran,
            'laba' => $laba,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibuat');
    }

    public function show(string $id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }

    public function exportCSV(Request $request)
    {
        $fileName = 'laporan_laundry_' . date('Y-m-d') . '.csv';
        
        $query = Transaksi::with(['pelanggan', 'detailTransaksi.layanan']);
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_masuk', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }
        $transaksi = $query->latest()->get();

        $expenseQuery = Pengeluaran::query();
        if ($request->filled('from') && $request->filled('to')) {
            $expenseQuery->whereBetween('tanggal', [$request->from, $request->to]);
        }
        $pengeluaran = $expenseQuery->latest()->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($transaksi, $pengeluaran) {
            $file = fopen('php://output', 'w');
            
            // Pendapatan Header
            fputcsv($file, ['LAPORAN PENDAPATAN']);
            fputcsv($file, ['Kode', 'Tanggal', 'Pelanggan', 'Total']);
            foreach ($transaksi as $t) {
                fputcsv($file, [$t->kode_transaksi, $t->tanggal_masuk->format('d-m-Y'), $t->pelanggan->nama ?? '-', $t->total_harga]);
            }
            fputcsv($file, ['TOTAL PENDAPATAN', '', '', $transaksi->sum('total_harga')]);
            
            fputcsv($file, []); // Spacer
            
            // Pengeluaran Header
            fputcsv($file, ['LAPORAN PENGELUARAN']);
            fputcsv($file, ['Tanggal', 'Keterangan', 'Kategori', 'Jumlah']);
            foreach ($pengeluaran as $p) {
                fputcsv($file, [$p->tanggal, $p->keterangan, $p->kategori, $p->jumlah]);
            }
            fputcsv($file, ['TOTAL PENGELUARAN', '', '', $pengeluaran->sum('jumlah')]);
            
            fputcsv($file, []);
            fputcsv($file, ['LABA BERSIH', '', '', $transaksi->sum('total_harga') - $pengeluaran->sum('jumlah')]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF(Request $request)
    {
        // Simple Print view approach
        return $this->index($request)->with('print', true);
    }
}
