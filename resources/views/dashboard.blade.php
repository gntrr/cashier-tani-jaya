<x-app-layout>
    @if(\App\Helpers\RoleHelper::isAdmin(auth()->user()))
        <!-- Admin Dashboard -->
        <div class="px-4 sm:px-6 md:px-10 py-6">
            <!-- Breadcrumb -->
            <div class="text-zinc-400 text-xs mb-6">Home > Dashboard</div>
            
            <!-- Stats Cards -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold">Statistik Penjualan Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-10">
                <!-- Total Penjualan -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-32">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="text-slate-700 text-sm font-semibold">Total Penjualan</div>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</div>
                </div>

                <!-- Total Pembelian -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-32">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="text-slate-700 text-sm font-semibold">Total Pembelian</div>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalModal ?? 0, 0, ',', '.') }}</div>
                </div>

                <!-- Stok -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-32">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="text-slate-700 text-sm font-semibold">Stok</div>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $totalTransaksi ?? 0 }} <span class="text-sm font-normal text-gray-500">item</span></div>
                </div>

                <!-- Profit -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-32">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="text-slate-700 text-sm font-semibold">Profit</div>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($profit ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mt-5">
                <!-- Monthly Sales Chart -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-80 lg:col-span-1">
                    <h3 class="text-slate-700 text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Penjualan Bulanan
                    </h3>
                    <div class="h-60">
                        <canvas id="monthlyChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Yearly Sales Chart -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-80 lg:col-span-1">
                    <h3 class="text-slate-700 text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Penjualan Tahunan
                    </h3>
                    <div class="h-60">
                        <canvas id="yearlyChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Top Products (Pie) -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-80 lg:col-span-1">
                    <h3 class="text-slate-700 text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 text-rose-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        Produk Terlaris (Qty)
                    </h3>
                    <div class="h-60">
                        <canvas id="topProductsChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Kasir Dashboard -->
        <div class="px-4 sm:px-6 md:px-10 py-6">
            <!-- Breadcrumb -->
            <div class="text-zinc-400 text-xs mb-6">Home > Dashboard</div>
            
            <!-- Main Transaction Panel -->
            <div class="bg-slate-700 rounded-lg p-4 md:p-6 mb-6 md:mb-8 h-16 md:h-20 flex items-center justify-end">
                <div class="text-white text-2xl md:text-4xl font-medium">Rp.</div>
            </div>

            <!-- Simple Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-6 md:mb-8">
                <div>
                    <div class="text-slate-700 text-sm md:text-base font-bold mb-2">Kode Pupuk</div>
                    <div class="bg-white rounded-2xl border border-slate-700 h-10 md:h-11 flex items-center px-3 md:px-4">
                        <input type="text" class="w-full outline-none text-slate-700 text-sm md:text-base">
                    </div>
                </div>
                <div>
                    <div class="text-slate-700 text-sm md:text-base font-bold mb-2">No. Transaksi</div>
                    <div class="bg-white rounded-2xl border border-slate-700 h-10 md:h-11 flex items-center px-3 md:px-4">
                        <div class="text-zinc-400 text-xs">(otomatis transaksi baru)</div>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="bg-green-500 rounded-lg h-10 md:h-12 flex items-center justify-center cursor-pointer">
                <div class="text-white text-base md:text-lg font-medium">Tambah Data</div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        // Register datalabels plugin globally (we'll disable it per-chart when not needed)
        if (window.Chart && window.ChartDataLabels) {
            Chart.register(window.ChartDataLabels);
        }
    let monthlyChart = null;
    let yearlyChart = null;
    let topProductsChart = null;

        // Load chart data via AJAX
        async function loadChartData() {
            try {
                const response = await fetch('{{ route("dashboard.chart-data") }}');
                const data = await response.json();
                
                // Initialize Monthly Chart
                const monthlyCtx = document.getElementById('monthlyChart');
                if (monthlyCtx && !monthlyChart) {
                    monthlyChart = new Chart(monthlyCtx, {
                        type: 'bar',
                        data: {
                            labels: data.monthly.labels,
                            datasets: [{
                                label: 'Penjualan Bulanan',
                                data: data.monthly.data,
                                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                datalabels: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#f1f5f9'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value + 'M';
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // Initialize Yearly Chart
                const yearlyCtx = document.getElementById('yearlyChart');
                if (yearlyCtx && !yearlyChart) {
                    yearlyChart = new Chart(yearlyCtx, {
                        type: 'line',
                        data: {
                            labels: data.yearly.labels,
                            datasets: [{
                                label: 'Penjualan Tahunan',
                                data: data.yearly.data,
                                borderColor: 'rgba(34, 197, 94, 1)',
                                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 3,
                                pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                datalabels: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#f1f5f9'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value + 'M';
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // Initialize Top Products (Doughnut)
                const topCtx = document.getElementById('topProductsChart');
                if (topCtx && !topProductsChart && Array.isArray(data.topProducts?.labels)) {
                    const colors = [
                        '#60a5fa','#34d399','#f87171','#fbbf24','#a78bfa','#fb7185','#22d3ee','#f59e0b','#10b981','#ef4444'
                    ];
                    topProductsChart = new Chart(topCtx, {
                        type: 'doughnut',
                        data: {
                            labels: data.topProducts.labels,
                            datasets: [{
                                data: data.topProducts.data,
                                backgroundColor: data.topProducts.labels.map((_, i) => colors[i % colors.length]),
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: {
                                    callbacks: {
                                        label: function(ctx) {
                                            const dataset = ctx.chart.data.datasets[0];
                                            const total = (dataset.data || []).reduce((a, b) => a + (Number(b) || 0), 0);
                                            const val = Number(ctx.parsed) || 0;
                                            const pct = total > 0 ? (val / total * 100) : 0;
                                            const label = ctx.label || '';
                                            return `${label}: ${val} (${pct.toFixed(1)}%)`;
                                        }
                                    }
                                },
                                datalabels: {
                                    color: '#fff',
                                    font: { weight: '700', size: 11 },
                                    formatter: function(value, ctx) {
                                        const dataArr = ctx.chart.data.datasets[0].data || [];
                                        const total = dataArr.reduce((a, b) => a + (Number(b) || 0), 0);
                                        if (!total) return '';
                                        const pct = value / total * 100;
                                        // Sembunyikan label terlalu kecil agar tidak bertumpuk
                                        return pct >= 4 ? pct.toFixed(1) + '%' : '';
                                    },
                                    clamp: true,
                                    anchor: 'center',
                                    align: 'center'
                                }
                            },
                            cutout: '60%'
                        }
                    });
                }
            } catch (error) {
                console.error('Error loading chart data:', error);
            }
        }

        // Load charts when page is ready
        document.addEventListener('DOMContentLoaded', function() {
            loadChartData();
        });
    </script>
    @endpush
</x-app-layout>
