
<div class="space-y-6 p-4 sm:p-[2%] overflow-y-auto max-h-screen">

    <!-- Alert -->
    <x-alert 
        type="success" 
        :message="session('success')"
    />

    <!-- Main Header -->
    <x-header 
        title="Dashboard Kas" 
        icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
    />

    <!-- Saldo Kas Utama -->
    <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border border-theme-primary">
        <x-card-header 
            title="Saldo Kas Utama: Rp {{ number_format($saldoKas ?? 0, 2, ',', '.') }}" 
            icon="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"
        />
        <div class="flex items-center space-x-3 mt-2 px-6">
            <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"></path>
            </svg>
            <p class="text-m text-theme-black">Kas Kembalian: Rp {{ number_format($saldoKembalian ?? 0, 2, ',', '.') }}</p>
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
        <x-card-header 
            title="Saldo Kas Titipan" 
            icon="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
        />
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
    <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border border-theme-primary">
        <x-card-header 
            title="Statistik Penjualan dan Pembelian" 
            icon="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605"
        />
        <div class="px-6 rounded-b-lg">
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
            <x-card-header 
                title="Penjualan vs Pembelian (Line)" 
                icon="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605"
            />
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
            <x-card-header 
                title="Barang Terlaris" 
                icon="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"
            />
            <div class="p-6 h-96">
                @if(empty($topSellingData) || array_sum($topSellingData) == 0 || empty($leastSellingData) || array_sum($leastSellingData) == 0)
                    <p class="text-center text-gray-500">Tidak ada data item terjual untuk periode ini.</p>
                @else
                    <canvas id="topLeastBarChart" class="w-full h-full"></canvas>
                @endif
            </div>
        </div>
        <div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary w-full">
            <x-card-header 
                title="Barang Keuntungan Tertinggi" 
                icon="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"
            />
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
        <x-card-header 
            title="Laporan Tersedia" 
            icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
        />
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

    <style>
    [x-cloak] {
        display: none !important;
    }
    .scrollbar-thin {
        scrollbar-width: thin;
    }
    .scrollbar-thumb-theme-primary {
        scrollbar-color: #007022 #f1f5f9;
    }
    .scrollbar-track-theme-surface {
        background: rgb(249, 243, 241);
    }
    thead.sticky th {
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>

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