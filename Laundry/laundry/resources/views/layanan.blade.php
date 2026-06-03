@extends('layouts.app')

@section('title', 'Layanan | Laundry Altek')
@section('page_title', 'Layanan')

@section('content')
<div class="flex flex-col lg:flex-row gap-10">
    <!-- Left Column: Table List -->
    <div class="flex-1">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 p-10 h-full">
            <h3 class="text-xl font-black text-gray-900 mb-8">Layanan</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400">
                            <th class="py-6 font-bold uppercase tracking-widest text-[10px]">Nama Layanan</th>
                            <th class="py-6 font-bold uppercase tracking-widest text-[10px] text-center">Satuan</th>
                            <th class="py-6 font-bold uppercase tracking-widest text-[10px] text-center">Harga</th>
                            <th class="py-6 font-bold uppercase tracking-widest text-[10px] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($layanan as $l)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="py-6 font-extrabold text-gray-800">{{ $l->nama_layanan }}</td>
                            <td class="py-6 text-center text-gray-500 font-bold uppercase text-[10px] tracking-widest">{{ $l->satuan }}</td>
                            <td class="py-6 text-center font-black text-gray-900">Rp {{ number_format($l->harga, 0, ',', '.') }}</td>
                            <td class="py-6 text-right">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('layanan.edit', $l->id) }}" class="p-2 text-gray-400 hover:text-teal-600 transition-colors">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('layanan.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
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
                            <td colspan="4" class="py-20 text-center text-gray-300 font-bold italic">Belum ada data layanan.</td>
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
            <h3 class="text-xl font-black text-gray-900 mb-8">Tambah Layanan</h3>
            
            <form action="{{ route('layanan.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Layanan</label>
                    <input type="text" name="nama_layanan" class="w-full border-b-2 border-gray-100 py-3 text-sm focus:outline-none focus:border-teal-500 font-bold text-gray-800 placeholder-gray-200" placeholder="Contoh: Bed Cover" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Satuan</label>
                    <select name="satuan" class="w-full bg-gray-50 rounded-xl px-4 py-4 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all">
                        <option value="kg">KG</option>
                        <option value="pcs">PCS</option>
                        <option value="m2">M2</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga (Rp)</label>
                    <input type="number" name="harga" class="w-full border-b-2 border-gray-100 py-3 text-2xl focus:outline-none focus:border-teal-500 font-black text-gray-800 placeholder-gray-100" placeholder="15000" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Estimasi (Hari)</label>
                    <input type="number" name="estimasi" class="w-full bg-gray-50 rounded-xl px-4 py-4 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all" value="2" required>
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
@endsection
