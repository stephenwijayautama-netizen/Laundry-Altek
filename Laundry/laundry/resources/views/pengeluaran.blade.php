@extends('layouts.app')

@section('title', 'Pengeluaran | Laundry Altek')
@section('page_title', 'Pengeluaran')

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    <!-- Left Column: List & Filter -->
    <div class="flex-1 space-y-6">
        <!-- Filter Box -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 p-8">
            <form action="{{ route('pengeluaran.index') }}" method="GET" class="space-y-6">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="relative flex-1">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300"></i>
                        <input type="text" name="search" placeholder="Cari Keterangan..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all" value="{{ request('search') }}">
                    </div>
                    <div class="flex gap-2">
                        <input type="date" name="from" class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold focus:outline-none" value="{{ request('from') }}">
                        <input type="date" name="to" class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold focus:outline-none" value="{{ request('to') }}">
                    </div>
                    <button type="submit" class="bg-[#99F6E4] text-[#0F172A] px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:scale-105 transition-all">Filter</button>
                </div>
            </form>
        </div>

        <!-- Table Box -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 p-8 overflow-hidden">
            <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Daftar Biaya Operasional</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-50 text-gray-400">
                            <th class="py-3 font-bold uppercase text-[10px] tracking-widest">Tanggal</th>
                            <th class="py-3 font-bold uppercase text-[10px] tracking-widest">Keterangan</th>
                            <th class="py-3 font-bold uppercase text-[10px] tracking-widest">Jumlah</th>
                            <th class="py-3 font-bold uppercase text-[10px] tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pengeluaran as $p)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="py-3 text-gray-500 font-medium text-xs">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                            <td class="py-3">
                                <span class="font-bold text-gray-800">{{ $p->keterangan }}</span>
                                <span class="block text-[10px] text-gray-400 uppercase font-black">{{ $p->kategori }}</span>
                            </td>
                            <td class="py-3 font-black text-gray-900 text-base">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                            <td class="py-3">
                                <form action="{{ route('pengeluaran.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus data?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center text-gray-300 font-bold italic">Belum ada pengeluaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($pengeluaran->count() > 0)
                    <tfoot>
                        <tr>
                            <td colspan="2" class="py-4 text-right font-black text-gray-300 uppercase tracking-widest text-[10px] pr-10">Total Periode Ini</td>
                            <td class="py-4 font-black text-gray-800 text-2xl">Rp {{ number_format($pengeluaran->sum('jumlah'), 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Input Form -->
    <div class="w-full lg:w-[350px]">
        <div class="bg-white rounded-[2.5rem] p-8 flex flex-col shadow-sm border border-gray-50 sticky top-10">
            <h3 class="text-xl font-black text-gray-900 mb-6">Catat Biaya</h3>
            
            <form action="{{ route('pengeluaran.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Pengeluaran</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 rounded-xl px-4 py-4 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Keterangan / Deskripsi</label>
                    <input type="text" name="keterangan" class="w-full border-b-2 border-gray-100 py-3 text-base focus:outline-none focus:border-teal-500 font-bold text-gray-800 placeholder-gray-300" placeholder="Contoh: Listrik Bulanan" required>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kategori Biaya</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['Bahan Baku', 'Operasional', 'Gaji', 'Lainnya'] as $cat)
                        <label class="cursor-pointer">
                            <input type="radio" name="kategori" value="{{ $cat }}" class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                            <div class="p-3 text-center border-2 border-gray-50 rounded-xl text-[10px] font-black uppercase tracking-wider text-gray-400 peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-600 transition-all">
                                {{ $cat }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Jumlah Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 text-gray-300 font-black text-xl">Rp</span>
                        <input type="number" name="jumlah" class="w-full border-b-2 border-gray-100 pl-10 py-3 text-3xl focus:outline-none focus:border-teal-500 font-black text-gray-800 placeholder-gray-100" placeholder="0" required>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-[#99F6E4] text-[#0F172A] py-5 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-teal-100">
                        Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
