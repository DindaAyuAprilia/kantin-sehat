<div class="min-h-screen flex flex-col p-4 sm:p-6 overflow-hidden">

    <!-- Alert -->
    <x-alert 
        type="success" 
        :message="session('success')"
    />

    <x-alert 
        type="error" 
        :message="session('error')"
    />

    <!-- Main Header -->
    <x-header 
        title="Manajemen Stock Opname" 
        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
    />

    <!-- Cash Comparison Section -->
    <div class=" mb-6 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
        <x-card-header 
            title="Perbandingan Kas"
            icon="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" 
        />

        <div class="mb-4 flex space-x-4 px-6">
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
        <div class="overflow-x-auto px-6 scrollbar-thin scrollbar-thumb-theme-primary scrollbar-track-theme-surface">
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
    <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
        <x-card-header 
            title="Daftar Barang"
            icon="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" 
        />

        <div class="mb-4 flex space-x-4 px-6">
            <div class="flex-1">
                <div class="relative rounded-md shadow-sm border border-gray-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari kode atau nama barang..."
                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                </div>
            </div>
        </div>
        <div class="px-6">
            <div class="overflow-x-auto scrollbar-track-theme-surface scrollbar-thin scrollbar-thumb-theme-primary">
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