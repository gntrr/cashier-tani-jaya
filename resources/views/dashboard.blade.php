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

                <!-- Total Pembelian (dari tabel pembelian) -->
                <div class="bg-white rounded-3xl shadow-lg p-6 h-32">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="text-slate-700 text-sm font-semibold">Total Pembelian</div>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalPembelian ?? 0, 0, ',', '.') }}</div>
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
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-zinc-400 text-xs mb-6">Home > Dashboard</div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <!-- Header Panel Display Total Real-time -->
                <div class="bg-slate-800 text-white px-6 py-5 flex items-center justify-between">
                    <div class="text-sm font-medium tracking-wide">Total Saat Ini</div>
                    <div id="kasir-total-display" class="text-3xl font-semibold">Rp 0</div>
                </div>
                <div class="p-5 flex flex-col lg:flex-row gap-8">
                    <!-- Left: Item Entry -->
                    <div class="flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="flex flex-col gap-1 md:col-span-1">
                                <label class="text-xs font-medium text-slate-500">Cari / Kode Pupuk</label>
                                <div class="relative">
                                    <input id="inp-search-pupuk" type="text" placeholder="Ketik nama / kode" class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm pl-3 pr-9" autocomplete="off" />
                                    <span class="pointer-events-none absolute right-3 top-2.5 text-slate-400">
                                        <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path d="M21 21l-4-4" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    </span>
                                </div>
                                <div id="dropdown-pupuk" class="hidden absolute z-20 mt-1 w-72 max-h-64 overflow-auto rounded-xl border border-slate-200 bg-white shadow-lg text-sm"></div>
                            </div>
                            <div class="flex flex-col gap-1 md:col-span-1">
                                <label class="text-xs font-medium text-slate-500">No. Transaksi</label>
                                <input type="text" readonly value="(otomatis)" class="rounded-xl bg-slate-50 border-slate-200 text-sm" />
                            </div>
                            <div class="flex items-end md:col-span-1">
                                <button id="btn-add-selected" class="w-full inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 disabled:opacity-40" disabled>Tambah ke Tabel</button>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr class="text-left text-slate-600 border-b border-slate-200">
                                        <th class="px-4 py-2">Kode</th>
                                        <th class="px-4 py-2">Nama Pupuk</th>
                                        <th class="px-4 py-2 text-right">Harga</th>
                                        <th class="px-4 py-2 text-center">Qty</th>
                                        <th class="px-4 py-2 text-right">Subtotal</th>
                                        <th class="px-4 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kasir-item-body" class="divide-y divide-slate-100"></tbody>
                            </table>
                            <div class="px-4 py-3 text-xs text-slate-500" id="kasir-empty-note">Belum ada item.</div>
                        </div>
                    </div>
                    <!-- Right: Payment Panel -->
                    <div class="w-full lg:w-80">
                        <div class="space-y-4 bg-slate-50 border border-slate-200 rounded-2xl p-5">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Total</label>
                                <input id="inp-total" type="text" readonly class="w-full rounded-xl border-slate-300 bg-white text-sm" value="0" />
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Dibayar</label>
                                <input id="inp-bayar" type="number" min="0" class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Kembalian</label>
                                <input id="inp-kembalian" type="text" readonly class="w-full rounded-xl border-slate-300 bg-white text-sm" value="0" />
                            </div>
                            <div class="pt-2">
                                <button id="btn-save-transaksi" class="w-full inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-40" disabled>Simpan</button>
                                <div id="kasir-error" class="mt-3 hidden text-xs text-red-600"></div>
                                <div id="kasir-success" class="mt-3 hidden text-xs text-emerald-600"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Konfirmasi Setelah Transaksi -->
        <div id="modal-after-sale" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 relative">
                <button id="close-modal-sale" class="absolute top-2 right-2 text-slate-400 hover:text-slate-600">&times;</button>
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Transaksi Berhasil</h3>
                <p class="text-sm text-slate-600 mb-4">Kode: <span id="after-sale-kode" class="font-semibold"></span></p>
                <div class="space-y-3">
                    <button id="btn-goto-riwayat" class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Lihat Detail / Riwayat</button>
                    <button id="btn-print-receipt" class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Cetak Struk</button>
                    <button id="btn-new-transaction" class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-300">Transaksi Baru</button>
                </div>
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
            initKasir();
        });

        // ============== Kasir Frontend Logic ==============
        function initKasir(){
            const searchInput = document.getElementById('inp-search-pupuk');
            if(!searchInput) return; // not kasir
            const dropdown = document.getElementById('dropdown-pupuk');
            const addBtn = document.getElementById('btn-add-selected');
            const tbody = document.getElementById('kasir-item-body');
            const totalDisplay = document.getElementById('kasir-total-display');
            const emptyNote = document.getElementById('kasir-empty-note');
            const inpTotal = document.getElementById('inp-total');
            const inpBayar = document.getElementById('inp-bayar');
            const inpKembalian = document.getElementById('inp-kembalian');
            const btnSave = document.getElementById('btn-save-transaksi');
            const errBox = document.getElementById('kasir-error');
            const okBox = document.getElementById('kasir-success');
            let picked = null;
            let items = [];
            let searchTimeout = null;

            function fmt(n){ return 'Rp '+Number(n||0).toLocaleString('id-ID'); }
            function recalc(){
                let total=0; items.forEach(i=> total += i.harga * i.qty);
                totalDisplay.textContent = fmt(total);
                inpTotal.value = total;
                const bayar = parseFloat(inpBayar.value||0);
                const kemb = bayar - total;
                inpKembalian.value = kemb > 0 ? fmt(kemb) : 'Rp 0';
                btnSave.disabled = !(items.length && bayar >= total && total>0);
            }
            function render(){
                tbody.innerHTML='';
                if(!items.length){ emptyNote.classList.remove('hidden'); return; }
                emptyNote.classList.add('hidden');
                items.forEach((it,idx)=>{
                    const tr=document.createElement('tr');
                    tr.className='hover:bg-slate-50';
                    tr.innerHTML=`<td class="px-4 py-2 text-slate-700">${it.kode}</td>
                        <td class="px-4 py-2 text-slate-700">${it.nama}</td>
                        <td class="px-4 py-2 text-right text-slate-700">${fmt(it.harga)}</td>
                        <td class="px-4 py-2 text-center"><input type="number" min="1" value="${it.qty}" data-idx="${idx}" class="kasir-qty w-16 rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500" /></td>
                        <td class="px-4 py-2 text-right text-slate-700">${fmt(it.harga*it.qty)}</td>
                        <td class="px-4 py-2 text-center"><button data-del="${idx}" class="text-xs text-red-600 hover:underline">Hapus</button></td>`;
                    tbody.appendChild(tr);
                });
                recalc();
            }
            function hideDropdown(){ dropdown.classList.add('hidden'); }
            function showDropdown(){ dropdown.classList.remove('hidden'); }
            function searchPupuk(){
                const q=searchInput.value.trim();
                if(!q){ dropdown.innerHTML='<div class="p-3 text-xs text-slate-500">Ketik untuk mencari...</div>'; showDropdown(); return; }
                fetch(`{{ route('ajax.pupuk.search') }}?q=${encodeURIComponent(q)}`)
                    .then(r=>r.json())
                    .then(rows=>{
                        if(!rows.length){ dropdown.innerHTML='<div class="p-3 text-xs text-slate-500">Tidak ditemukan</div>'; showDropdown(); return; }
                        dropdown.innerHTML = rows.map(r=>`<button type="button" data-pupuk='${JSON.stringify(r)}' class="w-full text-left px-3 py-2 hover:bg-slate-50">
                            <div class="font-medium text-slate-700 text-xs">${r.kode_pupuk} - ${r.nama_pupuk}</div>
                            <div class="text-[10px] text-slate-500">Harga: ${Number(r.harga_jual).toLocaleString('id-ID')} | Stok: ${r.stok_pupuk}</div>
                        </button>`).join('');
                        showDropdown();
                    });
            }
            searchInput.addEventListener('input', ()=>{
                clearTimeout(searchTimeout);
                searchTimeout=setTimeout(searchPupuk,300);
            });
            dropdown.addEventListener('click', e=>{
                const btn=e.target.closest('button[data-pupuk]');
                if(!btn) return; picked = JSON.parse(btn.dataset.pupuk); addBtn.disabled=false; hideDropdown(); searchInput.value=`${picked.kode_pupuk} - ${picked.nama_pupuk}`;
            });
            addBtn.addEventListener('click', ()=>{
                if(!picked) return; const exist=items.find(i=>i.id===picked.id_pupuk); if(exist){ exist.qty++; } else { items.push({id:picked.id_pupuk,kode:picked.kode_pupuk,nama:picked.nama_pupuk,harga:parseFloat(picked.harga_jual),qty:1}); }
                picked=null; addBtn.disabled=true; render();
            });
            tbody.addEventListener('input', e=>{
                if(e.target.classList.contains('kasir-qty')){ const idx=e.target.dataset.idx; let v=parseInt(e.target.value)||1; if(v<1) v=1; items[idx].qty=v; render(); }
            });
            tbody.addEventListener('click', e=>{
                const del=e.target.closest('button[data-del]'); if(del){ items.splice(parseInt(del.dataset.del),1); render(); }
            });
            inpBayar.addEventListener('input', recalc);
            document.addEventListener('click', e=>{ if(!e.target.closest('#dropdown-pupuk') && e.target!==searchInput){ hideDropdown(); }});
            btnSave.addEventListener('click', ()=>{
                errBox.classList.add('hidden'); okBox.classList.add('hidden');
                btnSave.disabled=true; btnSave.textContent='Menyimpan...';
                fetch(`{{ route('ajax.penjualan.quick-store') }}`, {
                    method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                    body: JSON.stringify({
                        bayar: parseFloat(inpBayar.value||0),
                        items: items.map(i=>({id:i.id, qty:i.qty, harga:i.harga}))
                    })
                }).then(r=>r.json()).then(res=>{
                    if(!res.success){ throw new Error(res.message||'Gagal'); }
                    okBox.textContent = res.message + ' | Kode: '+res.kode; okBox.classList.remove('hidden');
                    // Tampilkan modal opsi
                    const modal = document.getElementById('modal-after-sale');
                    document.getElementById('after-sale-kode').textContent = res.kode;
                    modal.classList.remove('hidden');
                    // Simpan URL untuk actions
                    modal.dataset.showUrl = res.show_url;
                    modal.dataset.receiptUrl = res.receipt_url;
                    // Bind tombol
                    document.getElementById('btn-goto-riwayat').onclick = () => { window.location = res.show_url; };
                    document.getElementById('btn-print-receipt').onclick = () => { window.open(res.receipt_url,'_blank'); };
                    document.getElementById('btn-new-transaction').onclick = () => { modal.classList.add('hidden'); resetKasir(); };
                    document.getElementById('close-modal-sale').onclick = () => { modal.classList.add('hidden'); };
                }).catch(err=>{
                    errBox.textContent=err.message; errBox.classList.remove('hidden');
                }).finally(()=>{ btnSave.disabled=false; btnSave.textContent='Simpan'; recalc(); });
            });

            function resetKasir(){
                items = []; render(); searchInput.value=''; inpBayar.value=''; inpKembalian.value='Rp 0'; picked=null; addBtn.disabled=true; errBox.classList.add('hidden'); okBox.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-app-layout>
