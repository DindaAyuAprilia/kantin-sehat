<div class="p-6 space-y-6">
    <!-- Success Alert -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded border-2 border-theme-primary">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Alert -->
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded border-2 border-theme-primary">
            {{ session('error') }}
        </div>
    @endif

    <!-- Loading Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" x-show="$wire.isLoading" x-cloak>
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-theme-primary"></div>
    </div>

    <!-- Main Header -->
    <div class="mb-6 bg-theme-primary text-theme-white rounded-lg p-6 shadow-lg border-2 border-theme-primary">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h2 class="text-4xl font-bold">Stock Opname</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash Comparison Section -->
    <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
        <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
            <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2m-2 0h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm2 3h2m4 0h2"></path>
            </svg>
            <span>Perbandingan Kas</span>
        </h3>
        <div class="mb-4 flex space-x-4">
            <div>
                <label for="month" class="block text-sm font-medium text-theme-black">Bulan</label>
                <select wire:model.live="month" id="month" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                    @foreach ($months as $month)
                        <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="year" class="block text-sm font-medium text-theme-black">Tahun</label>
                <select wire:model.live="year" id="year" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                    @foreach ($years as $year)
                        <option value="{{ $year['value'] }}">{{ $year['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label for="uang_fisik" class="block text-sm font-medium text-theme-black">Uang Fisik</label>
                <input wire:model.live="uang_fisik" id="uang_fisik" type="number" step="0.01" placeholder="Masukkan jumlah uang fisik"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-theme-primary text-white">
                        <th class="px-4 py-2 border border-theme-primary">Uang Sistem</th>
                        <th class="px-4 py-2 border border-theme-primary">Uang Fisik</th>
                        <th class="px-4 py-2 border border-theme-primary">Selisih</th>
                        <th class="px-4 py-2 border border-theme-primary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-theme-light">
                        <td class="border px-4 py-2 border-theme-primary text-right">Rp {{ number_format($systemCash, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2 border-theme-primary text-right">Rp {{ number_format($uang_fisik, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2 border-theme-primary text-right">Rp {{ number_format($selisihCash, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2 border-theme-primary text-center">
                            @if ($selisihCash != 0)
                                <button wire:click="$dispatch('confirmAdjustCash')" class="bg-blue-400 hover:bg-blue-500 text-white py-1.5 px-4 rounded flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Sesuaikan Kas</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
        <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
            <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
            <span>Daftar Barang</span>
        </h3>
        <div class="mb-4 flex space-x-4">
            <div class="flex-1">
                <div class="relative rounded-md shadow-sm border border-gray-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari kode atau nama barang..."
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-theme-primary text-white">
                        <th class="px-4 py-2 border border-theme-primary">Barcode</th>
                        <th class="px-4 py-2 border border-theme-primary">Nama Barang</th>
                        <th class="px-4 py-2 border border-theme-primary">Stok Sistem</th>
                        <th class="px-4 py-2 border border-theme-primary">Stok Fisik</th>
                        <th class="px-4 py-2 border border-theme-primary">Harga Jual Satuan</th>
                        <th class="px-4 py-2 border border-theme-primary">Selisih Harga</th>
                        <th class="px-4 py-2 border border-theme-primary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                        <tr class="hover:bg-theme-light">
                            <td class="border px-4 py-2 border-theme-primary">{{ $barang->kode_barang }}</td>
                            <td class="border px-4 py-2 border-theme-primary">{{ $barang->nama }}</td>
                            <td class="border px-4 py-2 border-theme-primary text-center">{{ $barang->stok }}</td>
                            <td class="border px-4 py-2 border-theme-primary text-center">
                                <input wire:model.live="physicalStocks.{{ $barang->id }}" type="number" min="0"
                                    class="w-20 text-center rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                            </td>
                            <td class="border px-4 py-2 border-theme-primary text-right">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                            <td class="border px-4 py-2 border-theme-primary text-right">
                                @if (isset($physicalStocks[$barang->id]) && is_numeric($physicalStocks[$barang->id]))
                                    Rp {{ number_format(($barang->stok - $physicalStocks[$barang->id]) * $barang->harga_jual, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border px-4 py-2 border-theme-primary text-center">
                                @if (isset($physicalStocks[$barang->id]) && is_numeric($physicalStocks[$barang->id]) && $physicalStocks[$barang->id] != $barang->stok)
                                    @if ($physicalStocks[$barang->id] < $barang->stok)
                                        <div class="flex justify-center space-x-2">
                                            <div class="relative" x-data="{ showDatePicker: false }">
                                                <button x-on:click="showDatePicker = !showDatePicker" class="bg-blue-400 hover:bg-blue-500 text-white py-1.5 px-4 rounded flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span>Sesuaikan dengan Transaksi</span>
                                                </button>
                                                <div x-show="showDatePicker" class="absolute z-10 mt-2 bg-white border rounded shadow-lg p-4">
                                                    <input wire:model="selectedDate" type="date" class="mb-2 rounded-md border-gray-300 shadow-sm">
                                                    <button wire:click="$dispatch('confirmAdjustStockWithTransaction', @js(['id' => $barang->id, 'stock' => $physicalStocks[$barang->id] ?? 0]))"
                                                        class="bg-blue-400 hover:bg-blue-500 text-white py-1.5 px-4 rounded flex items-center space-x-1">
                                                        <span>Konfirmasi</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <button wire:click="$dispatch('confirmAdjustStockWithoutTransaction', @js(['id' => $barang->id, 'stock' => $physicalStocks[$barang->id] ?? 0]))"
                                                class="bg-green-400 hover:bg-green-500 text-white py-1.5 px-4 rounded flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>Sesuaikan Tanpa Transaksi</span>
                                            </button>
                                        </div>
                                    @else
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.transaksi-histori') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black py-1.5 px-4 rounded flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <span>Histori Transaksi</span>
                                            </a>
                                            <button wire:click="$dispatch('confirmAdjustStockWithoutTransaction', @js(['id' => $barang->id, 'stock' => $physicalStocks[$barang->id] ?? 0]))"
                                                class="bg-green-400 hover:bg-green-500 text-white py-1.5 px-4 rounded flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>Sesuaikan Stok</span>
                                            </button>
                                        </div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border px-4 py-2 text-center border-theme-primary">Tidak ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <div class="flex space-x-2">
                <button wire:click="previousPage" {{ $barangs->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300"> < </button>
                @foreach ($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                    <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 {{ $barangs->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-theme-light text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white">
                        {{ $page }}
                    </button>
                @endforeach
                <button wire:click="nextPage" {{ $barangs->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300"> > </button>
            </div>
            <span class="text-sm text-theme-black">
                Menampilkan {{ $barangs->firstItem() ?: 0 }} - {{ $barangs->lastItem() ?: 0 }} dari {{ $barangs->total() }} data
            </span>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

        window.addEventListener('swal:confirmAdjustStockWithTransaction', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Stok akan disesuaikan dengan membuat transaksi penjualan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, sesuaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('confirmAdjustStockWithTransaction', event.detail);
                }
            });
        });

        window.addEventListener('swal:confirmAdjustStockWithoutTransaction', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Stok akan disesuaikan tanpa transaksi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, sesuaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('confirmAdjustStockWithoutTransaction', event.detail);
                }
            });
        });

        window.addEventListener('swal:confirmAdjustCash', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Kas sistem akan disesuaikan dengan kas fisik.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, sesuaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('confirmAdjustCash');
                }
            });
        });
    </script>
</div>