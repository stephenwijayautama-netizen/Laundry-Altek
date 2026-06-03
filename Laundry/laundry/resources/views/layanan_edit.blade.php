@extends('layouts.app')

@section('title', 'Edit Layanan | Laundry Altek')
@section('page_title', 'Edit Layanan')

@section('content')
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('layanan.index') }}" class="flex items-center text-sm text-gray-500 hover:text-teal-600 mb-6 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Daftar Layanan
        </a>

        <div class="card-premium p-8">
            <div class="flex items-center space-x-4 mb-8">
                <div class="p-3 bg-teal-50 rounded-xl text-teal-600">
                    <i data-lucide="edit-3" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Ubah Data Layanan</h3>
                    <p class="text-sm text-gray-500">Perbarui informasi harga atau estimasi waktu</p>
                </div>
            </div>

            <form action="{{ route('layanan.update', $layanan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nama Layanan</label>
                        <input type="text" name="nama_layanan" value="{{ $layanan->nama_layanan }}" class="input-standard w-full px-4 py-3 rounded-xl" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Harga (Rp)</label>
                            <input type="number" name="harga" value="{{ number_format($layanan->harga, 0, '', '') }}" class="input-standard w-full px-4 py-3 rounded-xl" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Satuan</label>
                            <select name="satuan" class="input-standard w-full px-4 py-3 rounded-xl">
                                <option value="kg" {{ $layanan->satuan == 'kg' ? 'selected' : '' }}>Per Kg</option>
                                <option value="pcs" {{ $layanan->satuan == 'pcs' ? 'selected' : '' }}>Per Pcs</option>
                                <option value="m2" {{ $layanan->satuan == 'm2' ? 'selected' : '' }}>Per M2</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Estimasi Selesai (Hari)</label>
                        <input type="number" name="estimasi" value="{{ $layanan->estimasi }}" class="input-standard w-full px-4 py-3 rounded-xl">
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('layanan.index') }}" class="btn-white">Batal</a>
                    <button type="submit" class="btn-premium px-8">Update Layanan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
