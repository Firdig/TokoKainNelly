@extends('layouts.admin')

@section('title', 'Verifikasi Pengambilan BOPS')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="font-outfit text-3xl font-bold text-brand-900">Modul Verifikasi Pengambilan (BOPS)</h2>
        <p class="mt-1 text-sm text-slate-500">Masukkan kode verifikasi (Pickup Code) pelanggan untuk menyelesaikan pesanan.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-sm text-red-700 font-bold">{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Input Section -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 flex flex-col items-center justify-center min-h-[300px]">
            <div class="w-16 h-16 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <h3 class="font-outfit font-bold text-xl text-brand-900 mb-2">Input Kode Pengambilan</h3>
            <p class="text-sm text-center text-slate-500 mb-6">Ketik kode yang diberikan oleh pelanggan.</p>
            
            <div class="w-full max-w-sm">
                <div class="flex gap-2">
                    <input type="text" id="pickup_code" name="pickup_code" placeholder="Cth: X7F9KQ" class="block w-full px-4 py-3 uppercase font-bold text-center tracking-widest text-lg border border-slate-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 rounded-xl bg-slate-50 text-brand-900 placeholder-slate-300 transition-colors" autocomplete="off" autofocus>
                    <button type="button" id="btnVerify" class="bg-brand-600 hover:bg-brand-900 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md transition-colors flex items-center gap-2">
                        <span>Cek</span>
                    </button>
                </div>
                <div id="verifyMessage" class="mt-3 text-sm text-center font-medium hidden"></div>
            </div>
        </div>

        <!-- Result Section -->
        <div id="resultSection" class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 flex flex-col items-center justify-center min-h-[300px] text-center opacity-50 grayscale transition-all duration-300 pointer-events-none">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-6" id="resultIcon">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <div id="orderInfo" class="hidden w-full">
                <h3 class="font-outfit font-bold text-2xl text-brand-900 mb-1" id="resInvoice">INV-XXXXX</h3>
                <p class="text-sm text-slate-500 mb-6" id="resCustomer">Nama Pelanggan</p>
                
                <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100 text-left">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-500">Jumlah Barang</span>
                        <span class="font-bold text-brand-900" id="resItemsCount">0 Item</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Total Nominal</span>
                        <span class="font-bold text-brand-600" id="resTotal">Rp0</span>
                    </div>
                </div>

                <form id="handoverForm" method="POST" action="">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-600/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Selesaikan Pesanan
                    </button>
                </form>
            </div>
            
            <div id="emptyState" class="block">
                <h3 class="font-outfit font-bold text-xl text-slate-400 mb-2">Belum Ada Data</h3>
                <p class="text-sm text-slate-400">Silakan input dan cek kode pengambilan di sebelah kiri untuk melihat detail pesanan.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnVerify = document.getElementById('btnVerify');
        const inputCode = document.getElementById('pickup_code');
        const messageBox = document.getElementById('verifyMessage');
        const resultSection = document.getElementById('resultSection');
        const resultIcon = document.getElementById('resultIcon');
        const orderInfo = document.getElementById('orderInfo');
        const emptyState = document.getElementById('emptyState');
        const handoverForm = document.getElementById('handoverForm');
        
        inputCode.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnVerify.click();
            }
        });

        btnVerify.addEventListener('click', function() {
            const code = inputCode.value.trim();
            if (!code) {
                showMessage('Silakan masukkan kode.', 'text-red-500');
                return;
            }

            // Reset UI
            btnVerify.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            btnVerify.disabled = true;
            showMessage('Mengecek...', 'text-slate-500');

            fetch('{{ route("admin.scanner.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ pickup_code: code })
            })
            .then(response => response.json())
            .then(data => {
                btnVerify.innerHTML = '<span>Cek</span>';
                btnVerify.disabled = false;

                if (data.success) {
                    showMessage('Kode Ditemukan!', 'text-green-600');
                    showOrderData(data.order);
                } else {
                    showMessage(data.message || 'Kode tidak ditemukan atau tidak valid.', 'text-red-500');
                    hideOrderData();
                }
            })
            .catch(error => {
                btnVerify.innerHTML = '<span>Cek</span>';
                btnVerify.disabled = false;
                showMessage('Terjadi kesalahan jaringan.', 'text-red-500');
                hideOrderData();
            });
        });

        function showMessage(msg, colorClass) {
            messageBox.className = 'mt-3 text-sm text-center font-bold ' + colorClass;
            messageBox.innerText = msg;
            messageBox.classList.remove('hidden');
        }

        function showOrderData(order) {
            // Update Data
            document.getElementById('resInvoice').innerText = order.invoice_number;
            document.getElementById('resCustomer').innerText = order.customer_name;
            document.getElementById('resItemsCount').innerText = order.items_count + ' Barang';
            document.getElementById('resTotal').innerText = 'Rp' + order.total_amount;
            
            // Set Form Action
            handoverForm.action = '/admin/scanner/handover/' + order.id;

            // Toggle Visibility
            emptyState.classList.add('hidden');
            orderInfo.classList.remove('hidden');
            
            // Highlight Section
            resultSection.classList.remove('opacity-50', 'grayscale', 'pointer-events-none');
            resultSection.classList.add('ring-4', 'ring-green-100', 'border-green-200');
            
            resultIcon.className = 'w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-6 shadow-sm';
            resultIcon.innerHTML = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        }

        function hideOrderData() {
            emptyState.classList.remove('hidden');
            orderInfo.classList.add('hidden');
            
            resultSection.classList.add('opacity-50', 'grayscale', 'pointer-events-none');
            resultSection.classList.remove('ring-4', 'ring-green-100', 'border-green-200');
            
            resultIcon.className = 'w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-6';
            resultIcon.innerHTML = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        }
    });
</script>
@endsection
