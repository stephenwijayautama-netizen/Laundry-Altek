@extends('layouts.app')

@section('title', 'Laporan Transaksi | Laundry Altek')
@section('page_title', 'Laporan')

@section('content')
<div class="space-y-8">
    <!-- Filter Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
        <form action="{{ route('laporan.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Date Range -->
                <div class="flex items-center space-x-3 col-span-2">
                    <input type="date" name="from" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-bold w-full focus:outline-none focus:ring-2 focus:ring-teal-100" value="{{ request('from', date('Y-m-01')) }}">
                    <span class="text-gray-400 font-bold">-</span>
                    <input type="date" name="to" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-bold w-full focus:outline-none focus:ring-2 focus:ring-teal-100" value="{{ request('to', date('Y-m-d')) }}">
                </div>
                
                <!-- Status -->
                <select name="status" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-100">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="relative flex-1 w-full">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                    <input type="text" name="search" placeholder="Cari Nama / Invoice" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-100" value="{{ request('search') }}">
                </div>
                
                <button type="submit" class="bg-[#99F6E4] text-[#0F172A] px-10 py-3 rounded-xl text-sm font-black hover:scale-105 transition-transform shadow-lg shadow-teal-100">
                    Terapkan
                </button>
            </div>
        </form>

        <!-- Export Buttons -->
        <div class="flex flex-wrap gap-3  pt-6 border-t border-gray-50">
            <a href="{{ route('laporan.export.csv', request()->all()) }}" class="bg-white border border-gray-200 px-6 py-2 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition shadow-sm">Ekspor CSV</a>
            <a href="{{ route('laporan.export.csv', request()->all()) }}" class="bg-white border border-gray-200 px-6 py-2 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition shadow-sm">Ekspor Excel</a>
            <a href="{{ route('laporan.export.pdf', request()->all()) }}" class="bg-white border border-gray-200 px-6 py-2 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition shadow-sm">Ekspor PDF (Cetak)</a>
        </div>
    </div>

    @if(isset($print) && $print)
    <style>
        @media print {
            .sidebar, header, .bg-white.rounded-\[2\.5rem\].shadow-sm.border.border-gray-100.p-10:first-of-type {
                display: none !important;
            }
            main {
                margin: 0 !important;
                padding: 0 !important;
            }
            .p-8 {
                padding: 0 !important;
            }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.location.href = "{{ route('laporan.index') }}";
            }, 1000);
        }
    </script>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Pendapatan</p>
            <h3 class="text-3xl font-black text-teal-600">Rp {{ number_format($transaksi->sum('total_harga'), 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Pengeluaran</p>
            <h3 class="text-3xl font-black text-gray-800">Rp {{ number_format($pengeluaran->sum('jumlah'), 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Laba Bersih</p>
            <h3 class="text-3xl font-black text-gray-900">Rp {{ number_format($transaksi->sum('total_harga') - $pengeluaran->sum('jumlah'), 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Expenses Table Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
        <h3 class="text-lg font-black text-gray-800 mb-6 uppercase tracking-widest">Detail Pengeluaran</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400">
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Tanggal</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Keterangan</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Kategori</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pengeluaran as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-6 px-2 text-gray-500 font-medium">{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                        <td class="py-6 px-2 font-bold text-gray-800">{{ $p->keterangan }}</td>
                        <td class="py-6 px-2"><span class="px-2 py-1 bg-gray-100 rounded text-[10px] font-bold uppercase">{{ $p->kategori }}</span></td>
                        <td class="py-6 px-2 font-black text-gray-900 text-lg">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-gray-300 font-bold italic">Tidak ada data pengeluaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction Table Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 mt-10">
        <h3 class="text-lg font-black text-gray-800 mb-8 uppercase tracking-widest">Detail Pendapatan (Transaksi)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400">
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Kode</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Tanggal</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Pelanggan</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Layanan</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Jumlah</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Total</th>
                        <th class="py-6 px-2 font-bold uppercase tracking-widest text-[10px]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transaksi as $t)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-6 px-2 font-black text-gray-900">{{ $t->kode_transaksi }}</td>
                        <td class="py-6 px-2 text-gray-500 font-medium">{{ \Carbon\Carbon::parse($t->tanggal_masuk)->format('d-m-Y') }}</td>
                        <td class="py-6 px-2 font-bold text-gray-800">{{ $t->pelanggan->nama ?? '-' }}</td>
                        <td class="py-6 px-2 text-gray-600">
                            @foreach($t->detailTransaksi as $detail)
                                {{ $detail->layanan->nama_layanan }}{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        </td>
                        <td class="py-6 px-2 font-bold text-gray-800 text-center">{{ $t->detailTransaksi->sum('qty') }} Pcs</td>
                        <td class="py-6 px-2 font-black text-teal-600 text-lg">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="py-6 px-2">
                            @php
                                $laundryStatus = $t->pelanggan->status ?? $t->status;
                            @endphp
                            @if($laundryStatus == 'selesai')
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-teal-50 text-teal-600">
                                    Selesai
                                </span>
                            @elseif(in_array($laundryStatus, ['dicuci', 'siap diambil', 'proses']))
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-amber-50 text-amber-600">
                                    Proses
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-gray-50 text-gray-500">
                                    Pending
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-300 font-bold italic">Tidak ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
