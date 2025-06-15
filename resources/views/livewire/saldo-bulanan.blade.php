<div class="p-6">
    <!-- Alert Success -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Alert Error -->
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Loading Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" wire:loading>
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-[#007022]"></div>
    </div>

    <!-- Tab Navigation -->
    <div x-data="{ activeTab: '{{ $activeTab }}' }" 
         x-init="activeTab = '{{ $activeTab }}'" 
         class="mb-8">
        <div class="flex justify-center">
            <div class="inline-flex bg-white rounded-lg shadow-md p-2 border-2 border-[#007022]">
                <button @click="activeTab = 'kas'; $wire.set('activeTab', 'kas')" 
                        x-bind:class="[
                            activeTab === 'kas' ? 'bg-[#007022] text-white' : 'bg-gray-100 text-gray-800',
                            'px-6 py-2 rounded-md font-semibold transition-all duration-300 hover:bg-[#007022] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#005b1c] text-sm tea'
                        ]">
                    Saldo Kas
                </button>
                <button @click="activeTab = 'barang'; $wire.set('activeTab', 'barang')" 
                        x-bind:class="[
                            activeTab === 'barang' ? 'bg-[#007022] text-white' : 'bg-gray-100 text-gray-800',
                            'px-6 py-2 rounded-md font-semibold transition-all duration-300 hover:bg-[#007022] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#005b1c] text-sm'
                        ]">
                    Saldo Barang
                </button>
            </div>
        </div>
        <!-- Input Bulan -->
        <div class="mt-4 mb-6 max-w-xs mx-auto">
            <label for="selectedMonth" class="block text-sm font-medium text-gray-800 mb-1">Pilih Bulan</label>
            <div class="relative">
                <input wire:model.live="selectedMonth" id="selectedMonth" type="month"
                       class="block w-full rounded-md border-gray-800 shadow-sm focus:border-[#007022] focus:ring-[#007022] pl-10 py-2 text-sm">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-[#007022]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
            @error('selectedMonth') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Tab Content -->
        <div class="mt-6 max-h-[calc(100vh-14rem)]">
            <!-- Saldo Kas Tab -->
            <div x-show="activeTab === 'kas'" class="w-full p-6 bg-white rounded-lg shadow-lg border-2 border-[#007022]">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Saldo Kas</h2>
                <div class="mb-4">
                    <button wire:click="recalculateMonthlySaldo" 
                            class="bg-[#007022] text-white px-4 py-2 rounded-md hover:bg-[#005b1c] focus:outline-none focus:ring-2 focus:ring-[#005b1c] text-sm">
                        Hitung Ulang Saldo Akhir Bulan
                    </button>
                </div>
                <div class="overflow-y-auto max-h-96">
                    <table class="min-w-full text-sm border border-[#007022]">
                        <thead class="bg-[#007022] text-white sticky top-0">
                            <tr class="divide-x divide-[#007022] border-b border-[#007022]">
                                <th class="px-4 py-2">Periode Bulan</th>
                                <th class="px-4 py-2">Saldo Awal</th>
                                <th class="px-4 py-2">Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#007022]">
                            @if($saldoKasBulanan)
                                <tr class="divide-x divide-[#007022] border-b border-[#007022]">
                                    <td class="px-4 py-2 text-gray-800">{{ $saldoKasBulanan->periode_bulan }}</td>
                                    <td class="px-4 py-2 text-gray-800">Rp. {{ number_format($saldoKasBulanan->saldo_awal, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-gray-800">Rp. {{ number_format($saldoKasBulanan->saldo_akhir ?? 0, 2, ',', '.') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="3" class="text-center py-2 text-gray-800 text-sm">Data tidak ada.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Saldo Barang Tab -->
            <div x-show="activeTab === 'barang'" class="w-full p-6 bg-white rounded-lg shadow-lg border-2 border-[#007022]">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Saldo Barang</h2>
                <div class="relative mb-4">
                    <input wire:model.debounce.500ms="searchBarang" id="searchBarang" type="text" placeholder="Cari nama barang..."
                           class="mt-1 block w-full rounded-md border-gray-800 shadow-sm focus:border-[#007022] focus:ring-[#007022] pl-10 py-2 text-sm">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-[#007022]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
                <div class="overflow-y-auto max-h-96">
                    <table class="min-w-full text-sm border border-[#007022]">
                        <thead class="bg-[#007022] text-white sticky top-0">
                            <tr class="divide-x divide-[#007022] border-b border-[#007022]">
                                <th class="px-4 py-2">Nama Barang</th>
                                <th class="px-4 py-2">Kuantitas Awal</th>
                                <th class="px-4 py-2">Nilai Awal</th>
                                <th class="px-4 py-2">Kuantitas Akhir</th>
                                <th class="px-4 py-2">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody id="barangTable" class="divide-y divide-[#007022]">
                            @forelse($saldoBarangBulanan as $sb)
                                <tr class="divide-x divide-[#007022] border-b border-[#007022]">
                                    <td class="px-4 py-2 text-gray-800">{{ $sb->barang->nama }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $sb->kuantitas_awal }}</td>
                                    <td class="px-4 py-2 text-gray-800">Rp. {{ number_format($sb->nilai_kuantitas_awal, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $sb->kuantitas_akhir }}</td>
                                    <td class="px-4 py-2 text-gray-800">Rp. {{ number_format($sb->nilai_kuantitas_akhir, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-2 text-gray-800 text-sm">Data tidak ada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
            const table = document.getElementById('barangTable');
            if (searchInput && table) {
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
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });

        window.addEventListener('swal:error', event => {
            Swal.fire({
                title: 'Error!',
                text: event.detail.message,
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        });
    </script>
</div>