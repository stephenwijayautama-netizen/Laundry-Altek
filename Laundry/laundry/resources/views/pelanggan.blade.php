@extends('layouts.app')

@section('title', 'Pelanggan | Laundry Altek')
@section('page_title', 'Pelanggan')

@section('content')
<div class="flex flex-col lg:flex-row gap-10">
    <!-- Left Column: Search & Table -->
    <div class="flex-1 space-y-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 p-10 h-full">
            <!-- Search Area -->
            <div class="flex items-center space-x-4 mb-10">
                <span class="text-sm font-bold text-gray-800">Pelanggan</span>
                <div class="flex-1 relative">
                    <input type="text" id="searchInput" placeholder="" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all">
                </div>
                <button class="bg-[#99F6E4] text-[#0F172A] px-8 py-2 rounded-lg text-xs font-black uppercase tracking-widest hover:scale-105 transition-transform">Cari</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400">
                            <th class="py-4 font-bold uppercase tracking-widest text-[10px]">Nama</th>
                            <th class="py-4 font-bold uppercase tracking-widest text-[10px]">Telephone</th>
                            <th class="py-4 font-bold uppercase tracking-widest text-[10px]">Alamat</th>
                            <th class="py-4 font-bold uppercase tracking-widest text-[10px] ">Status</th>
                            <th class="py-4 font-bold uppercase tracking-widest text-[10px] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pelanggan as $p)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="py-6 font-extrabold text-gray-800">{{ $p->nama }}</td>
                            <td class="py-6 text-gray-500 font-medium">{{ $p->telepon }}</td>
                            <td class="py-6">
                                <div class="max-w-[200px] text-gray-400 text-[11px] font-medium leading-relaxed truncate" title="{{ $p->alamat }}">
                                    {{ $p->alamat }}
                                </div>
                            </td>
                            <td class="py-6 text-center">
                                @if($p->status == 'antrean')
                                    <span class="inline-flex items-center text-gray-500 font-bold text-[10px] uppercase bg-gray-100 px-2 py-1 rounded">Antrean</span>
                                @elseif($p->status == 'dicuci')
                                    <span class="inline-flex items-center text-blue-500 font-bold text-[10px] uppercase bg-blue-50 px-2 py-1 rounded">Dicuci</span>
                                @elseif($p->status == 'siap diambil')
                                    <span class="inline-flex items-center text-teal-600 font-bold text-[10px] uppercase bg-teal-50 px-2 py-1 rounded">Siap Diambil</span>
                                @else
                                    <span class="inline-flex items-center text-green-600 font-bold text-[10px] uppercase bg-green-50 px-2 py-1 rounded">Selesai</span>
                                @endif
                            </td>
                            <td class="py-6 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('pelanggan.edit', $p->id) }}" class="p-2 text-gray-400 hover:text-teal-600 transition-colors">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center text-gray-300 font-bold italic">Belum ada data pelanggan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Form Tambah -->
    <div class="w-full lg:w-[400px]">
        <div class="bg-white rounded-[2.5rem] p-10 flex flex-col shadow-sm border border-gray-50 sticky top-10">
            <h3 class="text-xl font-black text-gray-900 mb-8">Tambah Pelanggan</h3>
            
            <form action="{{ route('pelanggan.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama</label>
                    <input type="text" name="nama" class="w-full border-b-2 border-gray-100 py-3 text-sm focus:outline-none focus:border-teal-500 font-bold text-gray-800 placeholder-gray-200" placeholder="Nama Lengkap" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Telephone</label>
                    <input type="text" name="telepon" class="w-full border-b-2 border-gray-100 py-3 text-sm focus:outline-none focus:border-teal-500 font-bold text-gray-800 placeholder-gray-200" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</label>
                    <input type="text" name="alamat" class="w-full border-b-2 border-gray-100 py-3 text-sm focus:outline-none focus:border-teal-500 font-bold text-gray-800 placeholder-gray-200" placeholder="Alamat Lengkap" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</label>
                    <select name="status" class="w-full bg-gray-50 rounded-xl px-4 py-4 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all">
                        <option value="antrean">Antrean</option>
                        <option value="dicuci">Dicuci</option>
                        <option value="siap diambil">Siap Diambil</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-[#99F6E4] text-[#0F172A] py-5 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-teal-100">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Simple Search logic
    document.getElementById('searchInput').addEventListener('input', function(e) {
        let val = e.target.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            let name = row.cells[0].innerText.toLowerCase();
            row.style.display = name.includes(val) ? '' : 'none';
        });
    });
</script>
@endsection