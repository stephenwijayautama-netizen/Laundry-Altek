@extends('layouts.app')

@section('title', 'Histori Transaksi | Laundry Altek')
@section('page_title', 'Histori transaksi')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">History Transaction</h3>
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-3 mb-6" id="filterContainer">
            <button data-filter="all" class="filter-btn px-6 py-2 bg-[#99F6E4] text-[#0F172A] rounded-lg text-sm font-bold shadow-sm transition">Semua</button>
            <button data-filter="lunas" class="filter-btn px-6 py-2 bg-white border border-gray-200 text-gray-400 rounded-lg text-sm font-bold hover:bg-gray-50 transition">Lunas</button>
            <button data-filter="belum_lunas" class="filter-btn px-6 py-2 bg-white border border-gray-200 text-gray-400 rounded-lg text-sm font-bold hover:bg-gray-50 transition">Belum Lunas</button>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm" id="transactionTable">
            <thead>
                <tr class="border-y border-gray-100 text-gray-400">
                    <th class="py-4 px-2 font-semibold">Kode</th>
                    <th class="py-4 px-2 font-semibold">Tanggal</th>
                    <th class="py-4 px-2 font-semibold">Pelanggan</th>
                    <th class="py-4 px-2 font-semibold">Layanan</th>
                    <th class="py-4 px-2 font-semibold">Jumlah</th>
                    <th class="py-4 px-2 font-semibold">Total</th>
                    <th class="py-4 px-2 font-semibold">Status</th>
                    <th class="py-4 px-2 font-semibold">Pembayaran</th>
                    <th class="py-4 px-2 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transaksi as $t)
                <tr class="transaction-row hover:bg-gray-50 transition-colors" data-status="{{ $t->status_pembayaran }}">
                    <td class="py-4 px-2 font-medium text-gray-900">{{ $t->kode_transaksi }}</td>
                    <td class="py-4 px-2 text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal_masuk)->format('d-m-Y') }}</td>
                    <td class="py-4 px-2 font-semibold">{{ $t->pelanggan->nama ?? '-' }}</td>
                    <td class="py-4 px-2 text-gray-600">
                        @foreach($t->detailTransaksi as $detail)
                            {{ $detail->layanan->nama_layanan }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                    <td class="py-4 px-2 text-gray-600">
                        {{ $t->detailTransaksi->sum('qty') }} Pcs
                    </td>
                    <td class="py-4 px-2 font-bold text-gray-900">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td class="py-4 px-2">
                        <div class="flex items-center text-gray-700">
                            {{ ucfirst($t->pelanggan->status ?? 'antrean') }}
                            @if(($t->pelanggan->status ?? '') == 'selesai' || ($t->pelanggan->status ?? '') == 'siap diambil')
                                <i data-lucide="check" class="w-3 h-3 ml-1 text-teal-500"></i>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-2">
                        <span class="font-medium {{ $t->status_pembayaran == 'lunas' ? 'text-teal-600' : 'text-orange-500' }}">
                            {{ $t->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                        </span>
                        @if($t->status_pembayaran != 'lunas' && $t->metode_pembayaran == 'qris')
                            <div class="mt-1">
                                <a href="{{ route('doku.qris', $t->id) }}" class="inline-flex items-center text-[10px] font-black text-teal-600 bg-teal-50 px-2 py-1 rounded border border-teal-100 hover:bg-teal-100 transition-colors uppercase tracking-wider">
                                    <i data-lucide="qr-code" class="w-3 h-3 mr-1"></i> Bayar QRIS
                                </a>
                            </div>
                        @endif
                    </td>
                    <td class="py-4 px-2 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('transaksi.show', $t->id) }}" class="p-2 text-gray-400 hover:text-teal-600 transition" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('transaksi.show', $t->id) }}?print=1" target="_blank" class="p-2 text-gray-400 hover:text-teal-600 transition" title="Print Receipt">
                                <i data-lucide="printer" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="9" class="py-12 text-center text-gray-400 italic">
                        Belum ada data transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.filter-btn');
        const rows = document.querySelectorAll('.transaction-row');
        const emptyRow = document.getElementById('emptyRow');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                // Remove active classes from all buttons
                buttons.forEach(btn => {
                    btn.classList.remove('bg-[#99F6E4]', 'text-[#0F172A]', 'shadow-sm');
                    btn.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-400', 'hover:bg-gray-50');
                });

                // Add active classes to clicked button
                this.classList.add('bg-[#99F6E4]', 'text-[#0F172A]', 'shadow-sm');
                this.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-400', 'hover:bg-gray-50');

                const filter = this.getAttribute('data-filter');
                let visibleCount = 0;

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    if (filter === 'all' || status === filter) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show dynamic empty state if no visible rows
                if (visibleCount === 0) {
                    if (!document.getElementById('noResultsRow')) {
                        const tbody = document.querySelector('#transactionTable tbody');
                        const newEmptyRow = document.createElement('tr');
                        newEmptyRow.id = 'noResultsRow';
                        newEmptyRow.innerHTML = `
                            <td colspan="9" class="py-12 text-center text-gray-400 italic">
                                Tidak ada transaksi dengan status pembayaran ini.
                            </td>
                        `;
                        tbody.appendChild(newEmptyRow);
                    }
                } else {
                    const noResults = document.getElementById('noResultsRow');
                    if (noResults) noResults.remove();
                }
            });
        });
    });
</script>
@endpush
@endsection
