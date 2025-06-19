
<div class="space-y-6 p-4 sm:p-[2%] overflow-y-auto max-h-screen">

    <!-- Main Header -->
    <x-header-container 
        title="Dashboard Kas" 
        icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
    />

    <!-- Alert -->
    <x-alert-container 
        type="success" 
        :message="session('success')"
    />

    <!-- Saldo Kas Utama -->
    <div class="bg-theme-surface p-6 rounded-lg shadow-lg border border-theme-primary">
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-xl font-medium text-theme-black">Saldo Kas Utama: Rp {{ number_format($saldoKas ?? 0, 2, ',', '.') }}</h3>
        </div>
        <div class="flex items-center space-x-3 mt-2">
            <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <p class="text-sm text-theme-black">Kas Kembalian: Rp {{ number_format($saldoKembalian ?? 0, 2, ',', '.') }}</p>
            @if($saldoKembalian > 0)
                <button wire:click="transferKembalianToKeuntungan" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded ml-4 flex items-center space-x-2 border border-theme-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span>Transfer ke Keuntungan</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Saldo Kas Titipan -->
    <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary">
        <h3 class="text-xl font-medium text-theme-black bg-theme-light rounded-t-lg px-4 py-3 flex items-center space-x-3 border-b border-theme-primary">
            <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a4 4 0 00-4 4 4 4 0 008 0 4 4 0 00-4-4z"></path>
            </svg>
            <span>Saldo Kas Titipan</span>
        </h3>
        <div class="p-6 rounded-b-lg">
            @if($kasTitipans->isEmpty())
                <p class="text-center text-gray-500">Tidak ada barang titipan.</p>
            @else
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-theme-light">
                            <th class="px-4 py-2 text-theme-black border border-theme-primary">Nama Barang</th>
                            <th class="px-4 py-2 text-theme-black border border-theme-primary">Kode Barang</th>
                            <th class="px-4 py-2 text-theme-black border border-theme-primary">Saldo Kas</th>
                            <th class="px-4 py-2 text-theme-black border border-theme-primary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasTitipans as $kasTitipan)
                            <tr>
                                <td class="border px-4 py-2 border-theme-primary">{{ $kasTitipan->barang->nama ?? 'N/A' }}</td>
                                <td class="border px-4 py-2 border-theme-primary">{{ $kasTitipan->barang->kode_barang ?? 'N/A' }}</td>
                                <td class="border px-4 py-2 text-right border-theme-primary">Rp {{ number_format($kasTitipan->saldo_kas ?? 0, 2, ',', '.') }}</td>
                                <td class="border px-4 py-2 border-theme-primary">
                                    @if($kasTitipan->id && $kasTitipan->saldo_kas > 0)
                                        <button wire:click="startReduceSaldo({{ $kasTitipan->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded flex items-center space-x-2 border border-theme-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                            <span>Kurangi Saldo</span>
                                        </button>
                                    @else
                                        <button disabled class="bg-gray-400 text-white font-bold py-1 px-3 rounded flex items-center space-x-2 border border-theme-primary cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                            <span>Kurangi Saldo</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Period Selection for Charts -->
    <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary">
        <h3 class="text-2xl font-semibold text-theme-black bg-theme-light rounded-t-lg px-4 py-3 flex items-center space-x-3 border-b border-theme-primary">
            <svg class="w-6 h-6 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span>Statistik Penjualan dan Pembelian</span>
        </h3>
        <div class="p-6 rounded-b-lg">
            <h4 class="text-xl font-medium mb-4 text-theme-black flex items-center space-x-2 border-b border-theme-primary pb-2">
                <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Pilih Periode untuk Statistik</span>
            </h4>
            <div class="flex space-x-4">
                <div class="w-full md:w-1/2">
                    <label for="selectedPeriod" class="block text-base font-medium text-theme-black">Periode</label>
                    <select id="selectedPeriod" wire:model="selectedPeriod" class="block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-base h-12">
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                </div>
                <div class="w-full md:w-1/2" x-show="$wire.selectedPeriod === 'monthly'">
                    <label for="selectedMonth" class="block text-base font-medium text-theme-black">Bulan</label>
                    <input type="month" id="selectedMonth" wire:model="selectedMonth" class="block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-base h-12">
                </div>
                <div class="w-full md:w-1/2" x-show="$wire.selectedPeriod === 'yearly'">
                    <label for="selectedYear" class="block text-base font-medium text-theme-black">Tahun</label>
                    <input type="number" id="selectedYear" wire:model="selectedYear" min="2000" max="2100" class="block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-base h-12">
                </div>
                <div class="flex items-end">
                    <button wire:click="checkPeriod" class="px-6 py-3 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 border border-theme-primary text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Cek</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="space-y-6">
        <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary">
            <h3 class="text-2xl font-medium text-theme-black bg-theme-light rounded-t-lg px-6 py-4 flex items-center space-x-4 border-b border-theme-primary">
                <svg class="w-6 h-6 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>Distribusi Penjualan (Line)</span>
            </h3>
            <div class="p-6 h-96">
                @if(empty($penjualanData) || array_sum($penjualanData) == 0)
                    <p class="text-center text-gray-500">Tidak ada data penjualan untuk periode ini.</p>
                @else
                    <canvas id="lineChart" class="w-full h-full"></canvas>
                @endif
            </div>
        </div>
        <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary">
            <h3 class="text-2xl font-medium text-theme-black bg-theme-light rounded-t-lg px-6 py-4 flex items-center space-x-4 border-b border-theme-primary">
                <svg class="w-6 h-6 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>Penjualan vs Pembelian (Line)</span>
            </h3>
            <div class="p-6 h-96">
                @if((empty($penjualanData) || array_sum($penjualanData) == 0) && (empty($pembelianData) || array_sum($pembelianData) == 0))
                    <p class="text-center text-gray-500">Tidak ada data penjualan atau pembelian untuk periode ini.</p>
                @else
                    <canvas id="dualLineChart" class="w-full h-full"></canvas>
                @endif
            </div>
        </div>
    </div>

    <!-- Item Statistics Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary w-full">
            <h3 class="text-2xl font-medium text-theme-black bg-theme-light rounded-t-lg px-6 py-4 flex items-center space-x-4 border-b border-theme-primary">
                <svg class="w-6 h-6 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 10h18M3 14h18M3 18h18"></path>
                </svg>
                <span>Barang Terlaris</span>
            </h3>
            <div class="p-6 h-96">
                @if(empty($topSellingData) || array_sum($topSellingData) == 0 || empty($leastSellingData) || array_sum($leastSellingData) == 0)
                    <p class="text-center text-gray-500">Tidak ada data item terjual untuk periode ini.</p>
                @else
                    <canvas id="topLeastBarChart" class="w-full h-full"></canvas>
                @endif
            </div>
        </div>
        <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary w-full">
            <h3 class="text-2xl font-medium text-theme-black bg-theme-light rounded-t-lg px-6 py-4 flex items-center space-x-4 border-b border-theme-primary">
                <svg class="w-6 h-6 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 10h18M3 14h18M3 18h18"></path>
                </svg>
                <span>Barang Keuntungan Tertinggi</span>
            </h3>
            <div class="p-6 h-96">
                @if(empty($highestProfitData) || array_sum($highestProfitData) == 0)
                    <p class="text-center text-gray-500">Tidak ada data laba item untuk periode ini.</p>
                @else
                    <canvas id="profitBarChart" class="w-full h-full"></canvas>
                @endif
            </div>
        </div>
    </div>

    <!-- Available Reports -->
    <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary">
        <h3 class="text-xl font-medium text-theme-black bg-theme-light rounded-t-lg px-4 py-3 flex items-center space-x-3 border-b border-theme-primary">
            <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Laporan Tersedia</span>
        </h3>
        <div class="p-6 rounded-b-lg">
            <h4 class="text-lg font-medium mb-4 text-theme-black flex items-center space-x-2 border-b border-theme-primary pb-2">
                <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Pilih Periode Laporan</span>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="startDate" class="block text-sm font-medium text-theme-black">Tanggal Awal</label>
                    <div class="mt-1 relative rounded-md shadow-sm border border-theme-primary">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="date" id="startDate" wire:model.defer="startDate" class="pl-10 block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                    </div>
                    @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="endDate" class="block text-sm font-medium text-theme-black">Tanggal Akhir</label>
                    <div class="mt-1 relative rounded-md shadow-sm border border-theme-primary">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="date" id="endDate" wire:model.defer="endDate" class="pl-10 block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                    </div>
                    @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-theme-light">
                        <th class="px-4 py-2 text-theme-black border border-theme-primary">Nama Laporan</th>
                        <th class="px-4 py-2 text-theme-black border border-theme-primary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2 border-theme-primary">Ringkasan Penerimaan & Pembayaran</td>
                        <td class="border px-4 py-2 border-theme-primary">
                            <button wire:click="viewReport('penerimaan_pembayaran')" class="bg-theme-primary hover:bg-theme-secondary text-white font-bold py-2 px-4 rounded flex items-center space-x-2 border border-theme-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Lihat Laporan</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 border-theme-primary">Ringkasan Nilai Persediaan</td>
                        <td class="border px-4 py-2 border-theme-primary">
                            <button wire:click="viewReport('nilai_persediaan')" class="bg-theme-primary hover:bg-theme-secondary text-white font-bold py-2 px-4 rounded flex items-center space-x-2 border border-theme-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 21" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Lihat Laporan</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 border-theme-primary">Ringkasan Kuantitas Persediaan</td>
                        <td class="border px-4 py-2 border-theme-primary">
                            <button wire:click="viewReport('ringkasan_kuantitas')" class="bg-theme-primary hover:bg-theme-secondary text-white font-bold py-2 px-4 rounded flex items-center space-x-2 border border-theme-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Lihat Laporan</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 border-theme-primary">Margin Laba Persediaan Barang</td>
                        <td class="border px-4 py-2 border-theme-primary">
                            <button wire:click="viewReport('margin_laba')" class="bg-theme-primary hover:bg-theme-secondary text-white font-bold py-2 px-4 rounded flex items-center space-x-2 border border-theme-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Lihat Laporan</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 border-theme-primary">Laporan Laba Rugi</td>
                        <td class="border px-4 py-2 border-theme-primary">
                            <button wire:click="viewReport('laba_rugi')" class="bg-theme-primary hover:bg-theme-secondary text-white font-bold py-2 px-4 rounded flex items-center space-x-2 border border-theme-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-join="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Lihat Laporan</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hidden div to pass data to JavaScript -->
    <div id="chart-data" style="display: none;" 
            data-labels="{{ json_encode($labels) }}" 
            data-penjualan="{{ json_encode($penjualanData) }}" 
            data-pembelian="{{ json_encode($pembelianData) }}"
            data-top-selling-labels="{{ json_encode(array_slice($topSellingLabels, 0, 3) + array_slice($leastSellingLabels, -1)) }}"
            data-top-selling="{{ json_encode(array_slice($topSellingData, 0, 3) + array_slice($leastSellingData, -1)) }}"
            data-highest-profit-labels="{{ json_encode(array_slice($highestProfitLabels, 0, 3) + array_slice($highestProfitLabels, -1)) }}"
            data-highest-profit="{{ json_encode(array_slice($highestProfitData, 0, 3) + array_slice($highestProfitData, -1)) }}"
            data-least-selling-labels="{{ json_encode([]) }}"
            data-least-selling="{{ json_encode([]) }}">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>