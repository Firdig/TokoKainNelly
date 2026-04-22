<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir (POS) - Toko Kain Nelly</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 h-screen overflow-hidden font-sans flex flex-col">

    <!-- Top Navigation -->
    <nav class="bg-white border-b border-brand-100 flex-shrink-0 z-10 shadow-sm relative">
        <div class="px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-8 w-8 rounded object-cover shadow-sm">
                <h1 class="font-outfit font-bold text-lg text-brand-900">Toko Kain Nelly <span class="text-brand-400 font-normal ml-2">| Point of Sale</span></h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-brand-900">Kasir Utama</p>
                    <p class="text-xs text-brand-500">{{ date('d M Y') }}</p>
                </div>
                <a href="/" class="px-4 py-2 border border-brand-200 text-brand-600 hover:bg-brand-50 rounded-lg text-sm font-medium transition-colors">Ke Katalog Web</a>
            </div>
        </div>
    </nav>

    <!-- Main Workspace -->
    <div class="flex flex-1 overflow-hidden">
        
        <!-- Left Side: Product Grid -->
        <main class="flex-1 flex flex-col bg-brand-50">
            <div class="p-6 pb-2">
                <h2 class="font-outfit text-2xl font-bold text-brand-900">Daftar Produk</h2>
                <p class="text-sm text-slate-500">Klik produk untuk menambahkan ke keranjang.</p>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 pt-2 custom-scrollbar">
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($products as $product)
                        @foreach($product->variants as $variant)
                        <div class="bg-white rounded-xl border border-brand-100 shadow-sm hover:shadow-md transition-all cursor-pointer group flex flex-col h-full overflow-hidden {{ $variant->stock == 0 ? 'opacity-60 grayscale' : '' }}"
                             onclick="{{ $variant->stock > 0 ? "tambahKeKeranjang({$variant->id}, '" . addslashes($product->name . ' - ' . $variant->color_name) . "', {$product->price}, {$variant->stock})" : "alert('Stok Habis!')" }}">
                            <div class="p-4 flex-1 flex flex-col items-center text-center justify-center relative">
                                <!-- Quick add indication overlay -->
                                <div class="absolute inset-0 bg-brand-600/5 items-center justify-center hidden group-active:flex transition-opacity z-20">
                                    <svg class="w-8 h-8 text-brand-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                
                                @if($variant->image_path)
                                    <img src="{{ Storage::url($variant->image_path) }}" class="w-16 h-16 object-cover rounded-md mb-3 shadow-sm border border-slate-100" alt="{{ $variant->color_name }}">
                                @else
                                    <div class="w-16 h-16 rounded-md mb-3 shadow-sm border border-slate-200" style="background-color: {{ $variant->hex_code ?? '#ccc' }}"></div>
                                @endif
                                
                                <h3 class="font-outfit font-bold text-brand-900 mb-1 leading-tight text-sm">{{ $product->name }}</h3>
                                <p class="text-xs text-brand-600 font-bold mb-2">{{ $variant->color_name }}</p>
                                <p class="text-brand-900 font-semibold mb-3 text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}<span class="text-[10px] font-normal text-slate-400">/m</span></p>
                                
                                <div class="mt-auto w-full pt-3 border-t border-brand-50 flex justify-between items-center text-xs relative z-10">
                                    <span class="text-slate-500 font-medium">Stok: <strong class="{{ $variant->stock < 10 ? 'text-red-500' : 'text-brand-900' }}">{{ $variant->stock }}m</strong></span>
                                    <span class="bg-brand-50 text-brand-600 px-2 py-1 rounded {{ $variant->stock == 0 ? 'hidden' : '' }} font-bold text-[10px] uppercase">+ Tambah</span>
                                    <span class="bg-red-50 text-red-600 px-2 py-1 rounded font-bold text-[10px] {{ $variant->stock > 0 ? 'hidden' : '' }}">HABIS</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Right Side: Cart / Checkout Panel -->
        <aside class="w-96 bg-white border-l border-brand-200 flex flex-col shadow-[-4px_0_15px_-3px_rgba(0,0,0,0.05)] z-20">
            <!-- Header Cart -->
            <div class="p-5 border-b border-brand-100 bg-brand-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center text-brand-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-outfit font-bold text-brand-900 text-lg">Keranjang Kasir</h2>
                        <p class="text-xs text-brand-500" id="itemCount">0 Item</p>
                    </div>
                </div>
            </div>

            <!-- Cart Items List -->
            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar bg-slate-50/50" id="daftarKeranjang">
                <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-60">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="font-medium text-sm">Belum ada barang di keranjang</p>
                </div>
            </div>

            <!-- Footer Checkout -->
            <div class="p-5 bg-white border-t border-brand-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-end mb-4">
                    <span class="text-slate-500 font-semibold text-sm">Total Belanja</span>
                    <span class="font-outfit font-bold text-3xl text-brand-900" id="totalHarga">Rp0</span>
                </div>
                <button class="w-full bg-brand-600 hover:bg-accent-500 text-white font-bold text-lg py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2 transform active:scale-[0.98]" id="btnCheckout" onclick="prosesCheckoutPOS()" disabled>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Bayar Sekarang
                </button>
            </div>
        </aside>
    </div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<script>
    let keranjang = [];

    function tambahKeKeranjang(id, nama, harga, stok) {
        let itemIndex = keranjang.findIndex(item => item.product_variant_id === id);
        
        if (itemIndex > -1) {
            if (keranjang[itemIndex].quantity + 0.5 <= stok) {
                keranjang[itemIndex].quantity += 0.5;
            } else { alert('Stok tidak mencukupi!'); return; }
        } else {
            if (stok >= 0.5) keranjang.push({ product_variant_id: id, name: nama, price: harga, quantity: 1, stock: stok });
            else { alert('Stok tidak cukup untuk pembelian minimal (0.5m).'); return; }
        }
        renderKeranjang();
    }

    function kurangItem(index) {
        if(keranjang[index].quantity > 0.5) {
            keranjang[index].quantity -= 0.5;
        } else {
            hapusItem(index); return;
        }
        renderKeranjang();
    }
    
    function tambahItemQuantity(index) {
        if(keranjang[index].quantity + 0.5 <= keranjang[index].stock) {
            keranjang[index].quantity += 0.5;
            renderKeranjang();
        } else {
            alert('Maksimal stok tercapai!');
        }
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    function renderKeranjang() {
        let listContainer = document.getElementById('daftarKeranjang');
        let total = 0; let totalItems = 0;

        if (keranjang.length === 0) {
            listContainer.innerHTML = `
                <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-60">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="font-medium text-sm">Belum ada barang di keranjang</p>
                </div>`;
            document.getElementById('btnCheckout').disabled = true;
            document.getElementById('btnCheckout').classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            let listHTML = '<div class="space-y-3">';
            keranjang.forEach((item, index) => {
                let subtotal = item.price * item.quantity;
                total += subtotal; totalItems += item.quantity;
                
                listHTML += `
                    <div class="bg-white p-3 rounded-xl shadow-sm border border-brand-100 flex flex-col animate-fade-in">
                        <div class="flex justify-between items-start mb-2">
                            <h6 class="font-bold text-brand-900 text-sm pe-2 truncate">${item.name}</h6>
                            <button onclick="hapusItem(${index})" class="text-red-400 hover:text-red-600 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        <div class="text-brand-600 font-semibold text-sm mb-2">Rp${item.price.toLocaleString('id-ID')}</div>
                        <div class="flex justify-between items-center mt-auto border-t border-brand-50 pt-2">
                            <div class="flex items-center bg-brand-50 rounded-lg h-8">
                                <button onclick="kurangItem(${index})" class="w-8 h-full flex items-center justify-center text-brand-600 hover:bg-brand-200 rounded-l-lg font-bold">-</button>
                                <span class="w-8 text-center text-xs font-bold text-brand-900">${item.quantity}</span>
                                <button onclick="tambahItemQuantity(${index})" class="w-8 h-full flex items-center justify-center text-brand-600 hover:bg-brand-200 rounded-r-lg font-bold">+</button>
                            </div>
                            <span class="font-bold text-brand-900">Rp${subtotal.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                `;
            });
            listHTML += '</div>';
            listContainer.innerHTML = listHTML;
            document.getElementById('btnCheckout').disabled = false;
            document.getElementById('btnCheckout').classList.remove('opacity-50', 'cursor-not-allowed');
        }

        document.getElementById('itemCount').innerText = totalItems + ' Item' + (totalItems > 1 ? 's' : '');
        document.getElementById('totalHarga').innerText = 'Rp' + total.toLocaleString('id-ID');
        
        // Scroll to bottom of cart when adding new items
        listContainer.scrollTop = listContainer.scrollHeight;
    }

    function prosesCheckoutPOS() {
        if (keranjang.length === 0) return;
        
        let btn = document.getElementById('btnCheckout');
        btn.disabled = true; btn.innerHTML = "Memproses...";

        let dataPesanan = {
            transaction_type: 'pos',
            items: keranjang.map(item => ({ product_variant_id: item.product_variant_id, quantity: item.quantity }))
        };

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(dataPesanan)
        })
        .then(response => response.json())
        .then(data => {
            if(data.message) {
                alert('Transaksi Kasir Berhasil!\nNomor Nota: ' + data.order.invoice_number);
                keranjang = []; 
                location.reload(); 
            } else { alert('Terjadi kesalahan.'); btn.disabled = false; btn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Bayar Sekarang'; }
        }).catch(error => { alert('Gagal terhubung ke server.'); btn.disabled = false; btn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Bayar Sekarang'; });
    }
</script>

</body>
</html>