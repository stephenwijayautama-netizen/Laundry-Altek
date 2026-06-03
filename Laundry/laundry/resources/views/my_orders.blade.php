<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Laundry Altek</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {font-family: 'Outfit', sans-serif; background: #0f172a; color: #f1f5f9;}
        .glass-card {background: rgba(255,255,255,0.07); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15);}
        .btn-primary {background: #8cc63f; transition: transform .2s, background .2s;}
        .btn-primary:hover {background:#7bb334; transform:translateY(-2px);}
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-4xl rounded-3xl p-8 md:p-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Riwayat Pesanan Saya</h1>
            @if($myOrders->where('status', 'selesai')->count() > 0)
                <span class="bg-teal-600 text-white px-3 py-1 rounded text-sm">Anda memiliki {{ $myOrders->where('status', 'selesai')->count() }} pesanan selesai.</span>
            @endif
            <a href="{{ route('dashboard') }}" class="btn-primary text-white px-5 py-2 rounded-xl">Kembali ke Dashboard</a>
        </div>
<form method="GET" class="mb-4 flex items-center space-x-2">
    <label class="text-sm text-gray-300" for="status">Filter Status:</label>
    <select name="status" id="status" class="rounded px-2 py-1 bg-white/5 text-gray-200 border border-white/10 focus:outline-none">
        <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        <option value="siap diambil" {{ request('status') == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
        <option value="dicuci" {{ request('status') == 'dicuci' ? 'selected' : '' }}>Dicuci</option>
        <option value="antrean" {{ request('status') == 'antrean' ? 'selected' : '' }}>Antrean</option>
    </select>
    <button type="submit" class="btn-primary text-white px-3 py-1 rounded">Apply</button>
</form>
        @if($myOrders->isEmpty())
            <p class="text-gray-400 text-center py-8">Anda belum memiliki pesanan.</p>
        @else
            <div class="space-y-4">
                @foreach($myOrders as $order)
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div>
                                <h3 class="text-xl font-semibold text-[#8cc63f]">#{{ $order->kode_transaksi }}</h3>
                                <p class="text-sm text-gray-300">{{ $order->tanggal_masuk->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="mt-3 md:mt-0">
                                <span class="font-bold text-lg text-[#8cc63f]">Rp {{ number_format($order->total_harga,0,',','.') }}</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="font-medium text-gray-300">Layanan:</span>
                            <ul class="list-disc list-inside text-sm text-gray-200 ml-4">
                                @foreach($order->detailTransaksi as $detail)
                                    <li>{{ $detail->layanan->nama_layanan }} ({{ $detail->layanan->satuan }}) – Rp {{ number_format($detail->layanan->harga,0,',','.') }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-3 flex items-center space-x-4 text-sm">
                            <span class="px-2 py-1 rounded bg-{{ $order->status == 'selesai' || $order->status == 'siap diambil' ? 'teal-600' : 'orange-500' }} text-white">{{ ucfirst($order->status) }}</span>
                            <span class="px-2 py-1 rounded bg-{{ $order->status_pembayaran == 'lunas' ? 'teal-600' : 'orange-500' }} text-white">
                                {{ $order->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $myOrders->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</body>
</html>
