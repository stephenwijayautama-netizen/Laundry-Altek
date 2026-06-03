@extends('layouts.app')

@section('title', 'Detail Transaksi | Laundry Altek')
@section('page_title', 'History & Dashboard Detail Transaction')

@push('styles')
<style>
@media print {
    /* Hide all layout elements (sidebar, top bar, background etc) */
    body {
        background-color: white !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    /* Hide layouts but keep content wrapper */
    .sidebar, header, nav, footer, .back-btn, .action-buttons {
        display: none !important;
    }
    /* Expand main content area to full page width */
    main, .max-w-4xl {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .printable-card {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('transaksi.index') }}" class="flex items-center text-sm text-gray-500 hover:text-teal-600 mb-6 transition-colors back-btn">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Histori
    </a>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 printable-card">
        <!-- Header Detail -->
        <div class="flex justify-between items-start mb-10">
            <div>
                <img src="{{ asset('photo/logo.png') }}" alt="Logo" class="w-32 mb-6">
                <h3 class="text-3xl font-black text-gray-900">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</h3>
                <p class="text-gray-400 font-medium">{{ $transaksi->kode_transaksi }} | {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d F Y H:i') }}</p>
            </div>
            <div class="text-right">
                <span class="px-4 py-2 rounded-xl font-bold text-sm {{ $transaksi->status_pembayaran == 'lunas' ? 'bg-teal-50 text-teal-600' : 'bg-orange-50 text-orange-600' }}">
                    {{ strtoupper($transaksi->status_pembayaran) }}
                </span>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-10">
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Rincian Layanan</h4>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-50 text-gray-400 text-xs">
                        <th class="py-4 font-bold uppercase">Layanan</th>
                        <th class="py-4 font-bold uppercase">Harga Satuan</th>
                        <th class="py-4 font-bold uppercase text-center">Jumlah</th>
                        <th class="py-4 font-bold uppercase text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($transaksi->detailTransaksi as $item)
                    <tr>
                        <td class="py-6">
                            <p class="font-extrabold text-gray-800">{{ $item->layanan->nama_layanan }}</p>
                            <p class="text-xs text-gray-400">{{ $item->layanan->satuan }}</p>
                        </td>
                        <td class="py-6 text-gray-600 font-medium text-sm">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td class="py-6 text-center font-bold text-gray-800">{{ $item->qty }}</td>
                        <td class="py-6 text-right font-black text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-100">
                        <td colspan="3" class="py-6 text-right text-gray-400 font-bold uppercase text-xs">Total Pembayaran</td>
                        <td class="py-6 text-right text-2xl font-black text-teal-600">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Info Tambahan -->
        <div class="grid grid-cols-2 gap-8 pt-8 border-t border-gray-50">
            <div>
                <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status Pengerjaan</h5>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full {{ ($transaksi->pelanggan->status ?? 'antrean') == 'selesai' || ($transaksi->pelanggan->status ?? '') == 'siap diambil' ? 'bg-teal-500' : 'bg-orange-400' }} mr-2"></div>
                    <span class="font-bold text-gray-800">{{ ucfirst($transaksi->pelanggan->status ?? 'antrean') }}</span>
                </div>
            </div>
            <div>
                <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Metode Pembayaran</h5>
                <p class="font-bold text-gray-800 uppercase">{{ $transaksi->metode_pembayaran }}</p>
            </div>
        </div>

        <!-- Action -->
        <div class="mt-12 flex justify-end space-x-4 action-buttons">
            <button onclick="window.print()" class="bg-gray-100 text-gray-600 px-8 py-3 rounded-xl font-bold text-sm hover:bg-gray-200 transition">Print Invoice</button>
            <button class="bg-[#99F6E4] text-[#0F172A] px-8 py-3 rounded-xl font-bold text-sm hover:scale-105 transition-transform">Update Status</button>
        </div>
    </div>
</div>

@if(request('print'))
<script>
    function triggerPrint() {
        setTimeout(() => {
            window.print();
        }, 600); // 600ms delay to ensure all assets and Lucide icons are fully loaded
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        triggerPrint();
    } else {
        window.addEventListener('DOMContentLoaded', triggerPrint);
    }
</script>
@endif
@endsection
