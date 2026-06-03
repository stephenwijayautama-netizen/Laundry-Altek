@extends('layouts.app')

@section('title', 'POS | Kasir Laundry Altek')
@section('page_title', 'POS | Kasir')

@section('content')
<div class="flex flex-col lg:flex-row gap-10">
    <!-- Left Column -->
    <div class="flex-1 space-y-10">
        <!-- Logo inside content -->
        <div class="mb-6">
            <img src="{{ asset('photo/logo.png') }}" alt="Logo" class="w-32">
        </div>

        <!-- Pelanggan Section -->
        <section>
            <h3 class="text-gray-400 font-medium mb-3">Pelanggan</h3>
            <div class="relative flex items-center group">
                <i data-lucide="search" class="absolute left-4 w-5 h-5 text-gray-300"></i>
                <input type="text" id="customerSearch" class="w-full pl-12 pr-28 py-4 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all bg-white" placeholder="">
                <button class="absolute right-3 bg-white border border-gray-200 px-6 py-2 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 shadow-sm transition">Search</button>
                
                <div id="customerResults" class="absolute z-10 left-0 right-0 top-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 hidden max-h-64 overflow-y-auto overflow-x-hidden">
                    @foreach($pelanggan as $p)
                    <div class="customer-opt p-4 hover:bg-teal-50 cursor-pointer flex justify-between items-center transition-colors" data-id="{{ $p->id }}" data-name="{{ $p->nama }}">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center font-bold mr-3 text-xs">{{ substr($p->nama, 0, 1) }}</div>
                            <span class="font-bold text-gray-800 text-sm">{{ $p->nama }}</span>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">{{ $p->telepon }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div id="selectedCustomerDisplay" class="mt-3 hidden">
                <div class="bg-teal-600 text-white px-4 py-2 rounded-xl inline-flex items-center text-sm font-bold shadow-md shadow-teal-200">
                    <span id="selectedCustomerName"></span>
                    <button onclick="clearCustomer()" class="ml-3 hover:scale-110 transition-transform"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            </div>
        </section>

        <!-- Pilih Layanan Section -->
        <section>
            <h3 class="text-gray-400 font-medium mb-3">Pilih Layanan</h3>
            <div class="relative flex items-center mb-8 group">
                <i data-lucide="search" class="absolute left-4 w-5 h-5 text-gray-300"></i>
                <input type="text" id="serviceSearch" class="w-full pl-12 pr-28 py-4 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-100 transition-all bg-white" placeholder="">
                <button class="absolute right-3 bg-white border border-gray-200 px-6 py-2 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 shadow-sm transition">Search</button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="serviceGrid">
                @foreach($layanan as $l)
                <div class="service-card bg-white border border-transparent rounded-2xl p-8 cursor-pointer hover:border-teal-500 hover:shadow-xl hover:shadow-teal-100 transition-all flex flex-col items-center text-center group" 
                     data-id="{{ $l->id }}" data-name="{{ $l->nama_layanan }}" data-price="{{ $l->harga }}" data-unit="{{ $l->satuan }}">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-teal-50 transition-colors">
                        <i data-lucide="washing-machine" class="text-gray-300 w-10 h-10 group-hover:text-teal-400 transition-colors"></i>
                    </div>
                    <h4 class="font-extrabold text-gray-900 text-lg mb-2">{{ $l->nama_layanan }}</h4>
                    <p class="text-sm text-gray-400 font-medium">Rp {{ number_format($l->harga, 0, ',', '.') }} / {{ strtoupper($l->satuan) }}</p>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- Right Column (Order Sidebar) -->
    <div class="w-full lg:w-[450px]">
        <div class="bg-white rounded-[2.5rem] p-10 flex flex-col shadow-sm border border-gray-50 h-full min-h-[700px]">
            <h3 class="text-2xl font-black text-gray-900 mb-8">Input Pesanan</h3>
            
            <!-- Summary Box -->
            <div class="w-full h-40 bg-gray-50 rounded-3xl border border-gray-100 mb-8 flex flex-col items-center justify-center space-y-2">
                <i data-lucide="receipt" class="w-10 h-10 text-gray-200"></i>
                <p class="text-xs text-gray-400 font-bold tracking-widest uppercase">Detail Transaksi</p>
            </div>

            <!-- Shopping List -->
            <h4 class="text-sm font-extrabold text-gray-800 mb-4 flex justify-between items-center">
                <span>Daftar Belanja</span>
                <span id="cartCount" class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-[10px]">0</span>
            </h4>
            
            <div class="flex-1 space-y-4 mb-8 overflow-y-auto" id="cartItems">
                <div class="h-32 border-2 border-dashed border-gray-100 rounded-3xl flex items-center justify-center">
                    <p class="text-xs text-gray-300 font-medium italic">Pesanan akan muncul di sini</p>
                </div>
            </div>

            <!-- Error alerts if any -->
            @if(session('error'))
            <div class="bg-red-50 border border-red-100 text-red-600 rounded-2xl p-4 text-xs font-bold mb-6 flex items-center">
                <i data-lucide="alert-circle" class="w-4 h-4 mr-2 flex-shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif
            @if($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 rounded-2xl p-4 text-xs font-bold mb-6">
                <div class="flex items-center mb-2 font-black uppercase tracking-wider">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-2 flex-shrink-0 text-red-500"></i>
                    <span>Kesalahan Validasi:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form -->
            <form id="orderForm" action="{{ route('transaksi.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="pelanggan_id" id="formCustomerId">
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Catatan Pelanggan</label>
                    <input type="text" name="catatan" class="w-full border-b border-gray-200 py-3 text-sm focus:outline-none focus:border-teal-500 transition-colors font-medium" placeholder="Tulis catatan khusus...">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pengambilan</label>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <span class="block text-[10px] text-gray-400 font-bold mb-2">Tanggal</span>
                            <input type="date" name="tanggal_pengambilan" class="w-full bg-gray-50 rounded-xl px-4 py-3 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-100">
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-400 font-bold mb-2">Jam</span>
                            <input type="time" name="jam_pengambilan" class="w-full bg-gray-50 rounded-xl px-4 py-3 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-100">
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="space-y-2 py-4 border-t border-gray-50">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metodePembayaran" class="w-full bg-gray-50 rounded-xl px-4 py-3.5 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-100 border border-gray-100 text-gray-700">
                        <option value="tunai">💵 Tunai / Cash</option>
                        <option value="qris">📱 QRIS (DOKU)</option>
                    </select>
                </div>

                <!-- Total -->
                <div class="flex justify-between items-end pt-4">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Bayar</p>
                        <span class="text-3xl font-black text-teal-600" id="totalDisplay">Rp 0</span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="grid grid-cols-2 gap-4 pt-6">
                    <button type="button" onclick="submitOrder('belum_lunas')" class="bg-white border-2 border-gray-100 text-gray-600 py-4 rounded-2xl text-xs font-black hover:bg-gray-50 transition-all uppercase tracking-widest">Bayar Nanti</button>
                    <button type="button" onclick="submitOrder('lunas')" class="bg-[#99F6E4] text-[#0F172A] py-4 rounded-2xl text-xs font-black hover:scale-[1.02] active:scale-95 transition-all shadow-lg shadow-teal-100 uppercase tracking-widest">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cart = [];

    // Customer Search
    const customerInput = document.getElementById('customerSearch');
    const customerResults = document.getElementById('customerResults');
    
    customerInput.addEventListener('focus', () => customerResults.classList.remove('hidden'));
    customerInput.addEventListener('input', (e) => {
        const val = e.target.value.toLowerCase();
        customerResults.classList.remove('hidden');
        document.querySelectorAll('.customer-opt').forEach(opt => {
            const name = opt.dataset.name.toLowerCase();
            opt.style.display = name.includes(val) ? 'flex' : 'none';
        });
    });

    document.querySelectorAll('.customer-opt').forEach(opt => {
        opt.addEventListener('click', () => {
            document.getElementById('formCustomerId').value = opt.dataset.id;
            document.getElementById('selectedCustomerName').innerText = opt.dataset.name;
            document.getElementById('selectedCustomerDisplay').classList.remove('hidden');
            customerResults.classList.add('hidden');
            customerInput.value = '';
        });
    });

    function clearCustomer() {
        document.getElementById('formCustomerId').value = '';
        document.getElementById('selectedCustomerDisplay').classList.add('hidden');
    }

    // Service Selection
    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('click', () => {
            const id = card.dataset.id;
            const existing = cart.find(i => i.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({
                    id: id,
                    name: card.dataset.name,
                    price: parseFloat(card.dataset.price),
                    qty: 1
                });
            }
            renderCart();
        });
    });

    function renderCart() {
        const container = document.getElementById('cartItems');
        const cartCount = document.getElementById('cartCount');
        
        if (cart.length === 0) {
            container.innerHTML = `<div class="h-32 border-2 border-dashed border-gray-100 rounded-3xl flex items-center justify-center"><p class="text-xs text-gray-300 font-medium italic">Pesanan akan muncul di sini</p></div>`;
            cartCount.innerText = '0';
            document.getElementById('totalDisplay').innerText = 'Rp 0';
            return;
        }

        container.innerHTML = '';
        let total = 0;
        let count = 0;
        
        cart.forEach((item, index) => {
            total += item.price * item.qty;
            count += item.qty;
            
            const div = document.createElement('div');
            div.className = 'bg-gray-50 rounded-2xl p-5 flex justify-between items-center group animate-in slide-in-from-right duration-300';
            div.innerHTML = `
                <div>
                    <h5 class="font-bold text-gray-900 text-sm">${item.name}</h5>
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Rp ${item.price.toLocaleString('id-ID')} / unit</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center bg-white rounded-lg border border-gray-100 p-1">
                        <button type="button" onclick="updateQty(${index}, -1)" class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-red-500">-</button>
                        <span class="px-3 text-xs font-black text-gray-800">${item.qty}</span>
                        <button type="button" onclick="updateQty(${index}, 1)" class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-teal-500">+</button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });
        
        cartCount.innerText = count;
        document.getElementById('totalDisplay').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    function updateQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        renderCart();
    }

    function submitOrder(status) {
        if (!document.getElementById('formCustomerId').value) {
            alert('Silakan pilih pelanggan terlebih dahulu!');
            return;
        }
        if (cart.length === 0) {
            alert('Belum ada layanan yang dipilih!');
            return;
        }
        const form = document.getElementById('orderForm');
        
        // Remove existing temp inputs
        form.querySelectorAll('.temp-input').forEach(el => el.remove());

        // Add Items
        cart.forEach((item, index) => {
            const id = document.createElement('input'); id.type='hidden'; id.name=`items[${index}][layanan_id]`; id.value=item.id; id.className='temp-input';
            const qty = document.createElement('input'); qty.type='hidden'; qty.name=`items[${index}][qty]`; qty.value=item.qty; qty.className='temp-input';
            form.appendChild(id); form.appendChild(qty);
        });
        
        const paymentMethod = document.getElementById('metodePembayaran').value;
        const finalStatus = (paymentMethod === 'qris') ? 'belum_lunas' : status;

        const s = document.createElement('input'); s.type='hidden'; s.name='status_pembayaran'; s.value=finalStatus; s.className='temp-input';
        form.appendChild(s);
        
        form.submit();
    }

    // Close results when clicking outside
    document.addEventListener('click', (e) => {
        if (!customerInput.contains(e.target) && !customerResults.contains(e.target)) {
            customerResults.classList.add('hidden');
        }
    });

    // Service Search
    document.getElementById('serviceSearch').addEventListener('input', (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll('.service-card').forEach(card => {
            const name = card.dataset.name.toLowerCase();
            card.style.display = name.includes(val) ? 'flex' : 'none';
        });
    });
</script>
@endpush
@endsection
