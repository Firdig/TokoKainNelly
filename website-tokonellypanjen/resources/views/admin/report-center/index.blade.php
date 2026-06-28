@extends('layouts.admin')

@section('title', 'Pusat Laporan')

@section('content')
<div x-data="reportCenter()" class="max-w-7xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="font-outfit text-3xl font-bold text-brand-900">Pusat Laporan</h2>
            <p class="mt-1 text-sm text-slate-500">Ringkasan lengkap semua laporan toko dalam satu halaman.</p>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 p-1.5">
        <nav class="flex flex-wrap gap-1" role="tablist">
            <template x-for="tab in tabs" :key="tab.key">
                <button
                    @click="setTab(tab.key)"
                    :class="activeTab === tab.key
                        ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20'
                        : 'text-brand-600 hover:bg-brand-50'"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-200"
                    role="tab"
                    :aria-selected="activeTab === tab.key"
                >
                    <span x-html="tab.icon" class="w-4 h-4 flex-shrink-0"></span>
                    <span x-text="tab.label" class="hidden sm:inline"></span>
                </button>
            </template>
        </nav>
    </div>

    {{-- Tab Content --}}
    <div>
        {{-- Tab 1: Penjualan & Pembayaran --}}
        <div x-show="activeTab === 'sales'" x-cloak>
            @include('admin.report-center._tab-sales')
        </div>

        {{-- Tab 2: Penjualan Per Produk --}}
        <div x-show="activeTab === 'product-sales'" x-cloak>
            @include('admin.report-center._tab-product-sales')
        </div>

        {{-- Tab 3: Pergerakan Stok --}}
        <div x-show="activeTab === 'stock'" x-cloak>
            @include('admin.report-center._tab-stock')
        </div>

        {{-- Tab 4: Nilai Aset --}}
        <div x-show="activeTab === 'asset'" x-cloak>
            @include('admin.report-center._tab-asset')
        </div>
    </div>

</div>

<script>
function reportCenter() {
    return {
        activeTab: '{{ $activeTab }}',
        tabs: [
            {
                key: 'sales',
                label: 'Penjualan & Pembayaran',
                icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            },
            {
                key: 'product-sales',
                label: 'Per Produk',
                icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'
            },
            {
                key: 'stock',
                label: 'Stok',
                icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'
            },
            {
                key: 'asset',
                label: 'Aset',
                icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'
            },
        ],

        setTab(tab) {
            this.activeTab = tab;
            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.replaceState({}, '', url);
        },

        init() {
            // Initialize charts when tab becomes visible
            this.$watch('activeTab', (val) => {
                this.$nextTick(() => {
                    if (val === 'sales' && !this._salesChartInit) {
                        this.initSalesChart();
                        this._salesChartInit = true;
                    }
                    if (val === 'product-sales' && !this._psChartInit) {
                        this.initProductSalesChart();
                        this._psChartInit = true;
                    }
                });
            });

            // Init chart for default tab
            this.$nextTick(() => {
                if (this.activeTab === 'sales') {
                    this.initSalesChart();
                    this._salesChartInit = true;
                }
                if (this.activeTab === 'product-sales') {
                    this.initProductSalesChart();
                    this._psChartInit = true;
                }
            });
        },

        initSalesChart() {
            const el = document.getElementById('salesChart');
            if (!el) return;
            const ctx = el.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesChartLabels) !!},
                    datasets: [{
                        label: 'Omzet Harian (Rp)',
                        data: {!! json_encode($salesChartData) !!},
                        borderColor: '#1e3a8a',
                        backgroundColor: 'rgba(30, 58, 138, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#1e3a8a',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) label += ': ';
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp' + (value / 1000000) + ' Jt';
                                    else if (value >= 1000) return 'Rp' + (value / 1000) + ' Rb';
                                    return 'Rp' + value;
                                }
                            },
                            grid: { color: '#f1f5f9', drawBorder: false }
                        },
                        x: { grid: { display: false, drawBorder: false } }
                    },
                    interaction: { intersect: false, mode: 'index' }
                }
            });
        },

        initProductSalesChart() {
            const el = document.getElementById('topProductsChart');
            if (!el) return;
            const labels = {!! json_encode($psChartLabels) !!};
            if (labels.length === 0) return;
            const ctx = el.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Terjual (meter)',
                        data: {!! json_encode($psChartData) !!},
                        backgroundColor: 'rgba(154, 121, 37, 0.2)',
                        borderColor: 'rgba(154, 121, 37, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { callback: v => v + 'm' } },
                        x: { ticks: { maxRotation: 45, font: { size: 11 } } }
                    }
                }
            });
        }
    };
}
</script>
@endsection
