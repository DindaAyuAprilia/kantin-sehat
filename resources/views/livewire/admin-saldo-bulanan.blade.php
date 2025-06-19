<div class="min-h-screen flex flex-col p-6 sm:p-[2%] overflow-hidden">

    <!-- Main Header -->
    <x-header-container 
        title="Manajemen Saldo Bulanan"
        icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
        :active-tab="$activeTab"
        :tabs="[
            ['key' => 'kas', 'label' => 'Saldo Kas'],
            ['key' => 'barang', 'label' => 'Saldo Barang']
        ]"
    />

    <!-- Alert -->
    <x-alert-container 
        type="success" 
        :message="session('success')"
    />

    <x-alert-container 
        type="error" 
        :message="session('error')"
    />

    <!-- Tab Content -->
    <div class="space-y-6">
        <!-- Saldo Kas Tab -->
        @if ($activeTab === 'kas')
            <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Daftar Saldo Kas</span>
                </h3>
                <!-- Input Bulan -->
                <div class="mb-4">
                    <label for="selectedMonth" class="block text-sm font-medium text-theme-black mb-1">Pilih Bulan</label>
                    <div class="relative rounded-md shadow-sm border border-gray-300">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live="selectedMonth" id="selectedMonth" type="month"
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 py-2 text-sm">
                    </div>
                    @error('selectedMonth') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button wire:click="recalculateMonthlySaldo" 
                            class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Hitung Ulang Saldo Akhir Bulan</span>
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-theme-primary text-white">
                                <th class="px-4 py-2 border border-theme-primary">Periode Bulan</th>
                                <th class="px-4 py-2 border border-theme-primary">Saldo Awal</th>
                                <th class="px-4 py-2 border border-theme-primary">Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($saldoKasBulanan)
                                <tr class="hover:bg-theme-light">
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black">{{ $saldoKasBulanan->periode_bulan }}</td>
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black text-right">Rp. {{ number_format($saldoKasBulanan->saldo_awal, 2, ',', '.') }}</td>
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black text-right">Rp. {{ number_format($saldoKasBulanan->saldo_akhir ?? 0, 2, ',', '.') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="3" class="border px-4 py-2 text-center border-theme-primary text-theme-black">Data tidak ada.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Saldo Barang Tab -->
        @if ($activeTab === 'barang')
            <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Daftar Saldo Barang</span>
                </h3>
                <!-- Input Bulan dan Pencarian -->
                <div class="mb-4 flex space-x-4">
                    <div class="flex-1">
                        <label for="selectedMonth" class="block text-sm font-medium text-theme-black mb-1">Pilih Bulan</label>
                        <div class="relative rounded-md shadow-sm border border-gray-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live="selectedMonth" id="selectedMonth" type="month"
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 py-2 text-sm">
                        </div>
                        @error('selectedMonth') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-1">
                        <label for="searchBarang" class="block text-sm font-medium text-theme-black mb-1">Cari Barang</label>
                        <div class="relative rounded-md shadow-sm border border-gray-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.debounce.500ms="searchBarang" id="searchBarang" type="text" placeholder="Cari nama barang..."
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 py-2 text-sm">
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-theme-primary text-white">
                                <th class="px-4 py-2 border border-theme-primary">Nama Barang</th>
                                <th class="px-4 py-2 border border-theme-primary">Kuantitas Awal</th>
                                <th class="px-4 py-2 border border-theme-primary">Nilai Awal</th>
                                <th class="px-4 py-2 border border-theme-primary">Kuantitas Akhir</th>
                                <th class="px-4 py-2 border border-theme-primary">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($saldoBarangBulanan as $sb)
                                <tr class="hover:bg-theme-light">
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black">{{ $sb->barang->nama }}</td>
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black text-center">{{ $sb->kuantitas_awal }}</td>
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black text-right">Rp. {{ number_format($sb->nilai_kuantitas_awal, 2, ',', '.') }}</td>
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black text-center">{{ $sb->kuantitas_akhir }}</td>
                                    <td class="border px-4 py-2 border-theme-primary text-theme-black text-right">Rp. {{ number_format($sb->nilai_kuantitas_akhir, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border px-4 py-2 text-center border-theme-primary text-theme-black">Data tidak ada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const monthInput = document.getElementById('selectedMonth');
            if (monthInput) {
                monthInput.focus();
                monthInput.addEventListener('change', () => {
                    console.log('Month input changed:', monthInput.value);
                    Livewire.dispatch('updated', { propertyName: 'selectedMonth' });
                });
            }

            const searchInput = document.getElementById('searchBarang');
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    console.log('Search input changed:', searchInput.value);
                    Livewire.dispatch('updated', { propertyName: 'searchBarang' });
                });
            }
        });

        window.addEventListener('swal:success', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.detail.message,
                icon: 'success',
                confirmButtonColor: '#007022',
                confirmButtonText: 'OK'
            });
        });

        window.addEventListener('swal:error', event => {
            Swal.fire({
                title: 'Gagal!',
                text: event.detail.message,
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        });
    </script>
</div>