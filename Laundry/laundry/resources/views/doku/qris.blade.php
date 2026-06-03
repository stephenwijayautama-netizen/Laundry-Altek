@extends('layouts.app')

@section('title', 'Pembayaran DOKU Checkout | Laundry Altek')
@section('page_title', 'DOKU Payment Gateway')

@push('styles')
<style>
    /* Iframe modal override for Jokul Checkout JS to ensure beautiful integration */
    #jokul-checkout-iframe {
        border-radius: 24px !important;
        box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25) !important;
    }
</style>
@endpush

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 text-center relative overflow-hidden">
        <!-- Accent Glow background effect -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-teal-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-teal-50 rounded-full blur-3xl opacity-50"></div>

        <!-- Header Logos -->
        <div class="flex justify-between items-center mb-8 relative z-10">
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">DOKU JOKUL API</span>
            <div class="flex items-center space-x-2">
                <span class="text-lg font-black text-teal-600">Checkout</span>
                <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="mb-8 relative z-10">
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">TOTAL TAGIHAN</p>
            <h2 class="text-3xl font-black text-gray-900 mb-2">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h2>
            <div class="inline-flex items-center bg-gray-50 border border-gray-100 rounded-full px-4 py-1.5 text-xs text-gray-500 font-medium">
                <span class="w-2 h-2 rounded-full bg-orange-400 mr-2 animate-pulse"></span>
                {{ $transaksi->kode_transaksi }}
            </div>
        </div>

        <!-- Checkout Card wrapper with Premium Glassmorphism effect -->
        <div class="bg-gray-50 rounded-[2rem] p-6 border border-gray-100 inline-block w-full mb-8 relative z-10 shadow-sm">
            <div class="bg-white rounded-2xl p-6 shadow-sm mb-4">
                <div class="w-16 h-16 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                </div>
                <h4 class="font-extrabold text-gray-800 text-sm mb-1">Secure Checkout</h4>
                <p class="text-[11px] text-gray-400">Metode pembayaran QRIS, E-Wallet, VA, dan Kartu Kredit didukung secara aman.</p>
            </div>
            
            <!-- Pay Button -->
            <button id="pay-button" class="w-full bg-[#14B8A6] text-white py-4 rounded-xl text-xs font-black hover:bg-teal-600 transition-all uppercase tracking-widest flex items-center justify-center space-x-2 shadow-lg shadow-teal-100">
                <i data-lucide="credit-card" class="w-4 h-4 animate-pulse"></i>
                <span>Bayar Sekarang</span>
            </button>
        </div>

        <!-- Customer info details -->
        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 text-left text-xs mb-8 relative z-10">
            <div class="flex justify-between py-1">
                <span class="text-gray-400 font-semibold">Pelanggan</span>
                <span class="font-bold text-gray-800">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-gray-400 font-semibold">Telepon</span>
                <span class="font-bold text-gray-800">{{ $transaksi->pelanggan->telepon ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-gray-400 font-semibold">Metode Gateway</span>
                <span class="font-bold text-teal-600">DOKU Jokul Checkout</span>
            </div>
        </div>

        <!-- Action / Demo Helper Buttons -->
        <div class="space-y-3 relative z-10">
            @if(isset($checkoutResponse['is_mock']) && $checkoutResponse['is_mock'])
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-left text-[11px] text-amber-700 mb-2">
                <p class="font-bold mb-1"><i data-lucide="alert-triangle" class="w-3.5 h-3.5 inline mr-1"></i> Mode Presentasi / Demo</p>
                Kredensial DOKU belum diatur di file <code>.env</code>. Anda dapat menguji alur sistem dengan tombol simulasi di bawah ini.
            </div>
            @endif

            <form action="{{ route('doku.simulate', $transaksi->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-[#1E293B] text-white py-3.5 rounded-xl text-xs font-black hover:bg-slate-800 transition-all uppercase tracking-widest flex items-center justify-center space-x-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Simulasi Sukses Pembayaran</span>
                </button>
            </form>

            <a href="{{ route('transaksi.index') }}" class="block w-full bg-white border border-gray-200 text-gray-500 py-3 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors uppercase tracking-widest">
                Kembali ke Histori
            </a>
        </div>
    </div>
</div>

@push('scripts')
<!-- Load DOKU Jokul Checkout JS library dynamically based on environment -->
<script src="{{ env('DOKU_IS_PRODUCTION', false) ? 'https://jokul.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js' : 'https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js' }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        const paymentUrl = "{{ $checkoutResponse['payment_url'] ?? '' }}";
        const isMock = {{ ($checkoutResponse['is_mock'] ?? false) ? 'true' : 'false' }};

        payButton.addEventListener('click', function (e) {
            e.preventDefault();

            if (isMock) {
                // If mock mode, present a beautiful overlay mockup
                alert("Demo Mode: Link checkout Anda adalah \n" + paymentUrl + "\n\nSilahkan gunakan tombol 'Simulasi Sukses Pembayaran' untuk menyelesaikan transaksi.");
            } else {
                // In production or sandbox with real credentials, trigger DOKU Jokul Checkout Overlay Modal
                try {
                    loadJokulCheckout(paymentUrl);
                } catch (error) {
                    console.error("DOKU JS Error: ", error);
                    // Fallback redirect if iframe pop up fails
                    window.location.href = paymentUrl;
                }
            }
        });
    });
</script>
@endpush
@endsection
