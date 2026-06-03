@extends('layouts.app')

@section('title', 'Edit Pelanggan | Laundry Altek')
@section('page_title', 'Edit Pelanggan')

@section('content')
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('pelanggan.index') }}" class="flex items-center text-sm text-gray-500 hover:text-teal-600 mb-6 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Daftar Pelanggan
        </a>

        <div class="card-premium p-8">
            <div class="flex items-center space-x-4 mb-8">
                <div class="p-3 bg-teal-50 rounded-xl text-teal-600">
                    <i data-lucide="user-cog" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Ubah Data Pelanggan</h3>
                    <p class="text-sm text-gray-500">Perbarui informasi kontak atau alamat pelanggan</p>
                </div>
            </div>

            <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ $pelanggan->nama }}" class="input-standard w-full px-4 py-3 rounded-xl" required>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nomor Telepon</label>
                        <input type="text" name="telepon" value="{{ $pelanggan->telepon }}" class="input-standard w-full px-4 py-3 rounded-xl" required>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Alamat</label>
                        <textarea name="alamat" class="input-standard w-full px-4 py-3 rounded-xl h-32">{{ $pelanggan->alamat }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <select name="status" class="input-standard w-full px-4 py-3 rounded-xl">
                            <option value="antrean" {{ $pelanggan->status == 'antrean' ? 'selected' : '' }}>Antrean</option>
                            <option value="dicuci" {{ $pelanggan->status == 'dicuci' ? 'selected' : '' }}>Dicuci</option>
                            <option value="siap diambil" {{ $pelanggan->status == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
                            <option value="selesai" {{ $pelanggan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('pelanggan.index') }}" class="btn-white">Batal</a>
                    <button type="submit" class="btn-premium px-8">Update Pelanggan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
