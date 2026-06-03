@extends('layouts.app')

@section('title', 'Dashboard | Laundry Altek')
@section('page_title', 'Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-8">
    <!-- Top Filter Buttons -->
    <div class="flex space-x-3">
        <a href="{{ route('dashboard', ['range' => 'today']) }}" class="px-6 py-2 rounded-lg text-xs font-bold transition {{ ($stats['range'] ?? 'today') === 'today' ? 'bg-[#99F6E4] text-[#0F172A] shadow-sm' : 'bg-white border border-gray-200 text-gray-400 hover:bg-gray-50' }}">Hari Ini</a>
        <a href="{{ route('dashboard', ['range' => 'weekly']) }}" class="px-6 py-2 rounded-lg text-xs font-bold transition {{ ($stats['range'] ?? 'today') === 'weekly' ? 'bg-[#99F6E4] text-[#0F172A] shadow-sm' : 'bg-white border border-gray-200 text-gray-400 hover:bg-gray-50' }}">Minggu Ini</a>
        <a href="{{ route('dashboard', ['range' => 'monthly']) }}" class="px-6 py-2 rounded-lg text-xs font-bold transition {{ ($stats['range'] ?? 'today') === 'monthly' ? 'bg-[#99F6E4] text-[#0F172A] shadow-sm' : 'bg-white border border-gray-200 text-gray-400 hover:bg-gray-50' }}">Bulan Ini</a>
    </div>

    <!-- Stats Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Transaksi Periode Ini -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between h-32">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Transaksi</p>
            <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['active_count']) }}</h3>
            <p class="text-[10px] text-teal-600 font-bold uppercase">{{ $stats['active_label'] }}</p>
        </div>
        <!-- Pendapatan Periode Ini -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between h-32">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendapatan</p>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($stats['active_revenue'], 0, ',', '.') }}</h3>
            <p class="text-[10px] text-teal-600 font-bold uppercase">{{ $stats['active_label'] }}</p>
        </div>
        <!-- Transaksi Bulan Ini -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between h-32">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Transaksi</p>
            <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['month_count']) }}</h3>
            <p class="text-[10px] text-gray-400 font-bold uppercase">Bulan Ini</p>
        </div>
        <!-- Pendapatan Bulan Ini -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between h-32">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendapatan</p>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($stats['month_revenue'], 0, ',', '.') }}</h3>
            <p class="text-[10px] text-gray-400 font-bold uppercase">Bulan Ini</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 text-center">Grafik Pendapatan Hari Ini</h4>
            <div class="h-48">
                <canvas id="todayChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 text-center">Grafik Pendapatan Bulan Ini</h4>
            <div class="h-48">
                <canvas id="monthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Middle Info Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Service Usage -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest mb-6">Jumlah transaksi per Layanan</h4>
            <div class="space-y-4">
                @foreach($service_stats as $stat)
                <div class="flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-600">{{ $stat->layanan->nama_layanan }}</span>
                    <span class="text-sm font-black text-gray-900">{{ $stat->total }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Ready for Pickup -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest mb-6">Pelanggan Siap Pick Up</h4>
            <div class="space-y-4">
                @forelse($pelanggan_ready as $pr)
                <div class="flex justify-between items-center group">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-800">{{ $pr->nama }}</span>
                        <span class="text-xs font-semibold text-gray-400">{{ $pr->telepon }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $pr->telepon)) }}" target="_blank" title="Hubungi via WhatsApp" class="p-2 bg-green-50 rounded-lg text-green-500 hover:bg-green-500 hover:text-white transition-all">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                        </a>
                        <span class="p-2 bg-teal-50 rounded-lg text-teal-500">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-xs text-gray-400 font-bold italic text-center py-4">Belum ada pelanggan siap pick up.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="space-y-8">
        <!-- Unified Latest Transactions -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest">Transaksi Terbaru</h4>
                <a href="{{ route('transaksi.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 transition">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px]">
                    <thead>
                        <tr class="border-b border-gray-50 text-gray-400">
                            <th class="py-4 px-2 font-bold uppercase">Kode</th>
                            <th class="py-4 px-2 font-bold uppercase">Tanggal</th>
                            <th class="py-4 px-2 font-bold uppercase">Pelanggan</th>
                            <th class="py-4 px-2 font-bold uppercase">Layanan</th>
                            <th class="py-4 px-2 font-bold uppercase text-center">Total</th>
                            <th class="py-4 px-2 font-bold uppercase">Status</th>
                            <th class="py-4 px-2 font-bold uppercase">Pembayaran</th>
                            <th class="py-4 px-2 font-bold uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($latest_trans as $t)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-2 font-bold text-gray-900">{{ $t->kode_transaksi }}</td>
                            <td class="py-4 px-2 text-gray-400">{{ $t->tanggal_masuk->format('d-m-Y') }}</td>
                            <td class="py-4 px-2 font-bold">{{ $t->pelanggan->nama ?? '-' }}</td>
                            <td class="py-4 px-2">
                                @foreach($t->detailTransaksi as $dt)
                                {{ $dt->layanan->nama_layanan }}{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </td>
                            <td class="py-4 px-2 font-black text-center">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                            <td class="py-4 px-2">
                                <span class="{{ ($t->pelanggan->status ?? '') == 'selesai' || ($t->pelanggan->status ?? '') == 'siap diambil' ? 'text-teal-600' : 'text-orange-500' }} font-bold">{{ ucfirst($t->pelanggan->status ?? 'antrean') }}</span>
                            </td>
                            <td class="py-4 px-2">
                                <span class="font-medium {{ $t->status_pembayaran == 'lunas' ? 'text-teal-600' : 'text-orange-500' }}">
                                    {{ $t->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </td>
                            <td class="py-4 px-2 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('transaksi.show', $t->id) }}" class="p-1.5 text-gray-400 hover:text-teal-600 transition" title="Lihat Detail">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </a>
                                    <a href="{{ route('transaksi.show', $t->id) }}?print=1" target="_blank" class="p-1.5 text-gray-400 hover:text-teal-600 transition" title="Print Receipt">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400 italic font-bold">
                                Belum ada data transaksi terbaru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Common Chart Options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { display: false } },
            y: { grid: { display: false }, ticks: { display: false }, beginAtZero: true }
        },
        elements: {
            line: { tension: 0.4, borderWidth: 3, borderColor: '#ef4444' },
            point: { radius: 0 }
        }
    };

    // Today Chart
    new Chart(document.getElementById('todayChart'), {
        type: 'line',
        data: {
            labels: ['', '', '', '', '', ''],
            datasets: [{
                data: {!! json_encode($today_chart) !!},
                fill: true,
                backgroundColor: 'rgba(239, 68, 68, 0.05)'
            }]
        },
        options: commonOptions
    });

    // Month Chart
    new Chart(document.getElementById('monthChart'), {
        type: 'line',
        data: {
            labels: ['', '', '', '', '', ''],
            datasets: [{
                data: {!! json_encode($month_chart) !!},
                fill: true,
                backgroundColor: 'rgba(239, 68, 68, 0.05)'
            }]
        },
        options: commonOptions
    });
</script>
@endpush
@endsection
