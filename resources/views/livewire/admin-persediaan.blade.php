<div class=" min-h-screen flex flex-col p-4 sm:p-[2%] overflow-hidden">

    <!-- Main Header -->
    <x-header-container 
        title="Manajemen Persediaan" 
        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
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

    <!-- Konten Utama -->
    <div class="space-y-6 flex-1">

        <!-- Persediaan Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Persediaan -->
            <div id="form-persediaan" class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;" x-data="{ searchOpen: false }">
                <h2 class="text-xl font-semibold text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>{{ $isEditing ? 'Edit Persediaan' : 'Tambah Persediaan' }}</span>
                </h2>

                <form wire:submit.prevent="{{ $isEditing ? 'confirmUpdate' : 'save' }}">
                    <div class="space-y-4">
                        <!-- Input Barang -->
                        <div>
                            <label for="search_barang" class="block text-sm font-medium text-theme-black">Barang</label>
                            <div class="relative">
                                <input wire:model.live.debounce.300ms="search_query_form" id="search_barang" type="text" x-ref="search_barang" placeholder="Ketik nama atau scan kode barang" autocomplete="off" x-on:input="searchOpen = true" x-on:keydown.enter.prevent="searchOpen = false" x-on:keydown.escape="searchOpen = false" x-on:focus="searchOpen = true" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            <div x-show="searchOpen && $wire.search_results.length > 0" class="absolute z-50 mt-1 bg-white border border-theme-black rounded-md shadow-lg max-h-60 overflow-auto" x-ref="dropdown">
                                <ul>
                                    @foreach($search_results as $result)
                                        <li wire:click="selectBarang({{ $result->id }})" class="px-4 py-2 hover:bg-theme-primary hover:text-theme-white cursor-pointer text-sm">
                                            {{ $result->kode_barang }} - {{ $result->nama }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('barang_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Dikelola Oleh -->
                        <div>
                            <label class="block text-sm font-medium text-theme-black">Dikelola Oleh</label>
                            <div class="relative">
                                <input type="text" value="{{ Auth::user()->nama ?? 'Pengelola Saat Ini' }}" readonly class="mt-1 block w-full rounded-md border-theme-black bg-gray-100 shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Input Tipe -->
                        <div>
                            <label for="tipe" class="block text-sm font-medium text-theme-black">Tipe</label>
                            <div class="relative">
                                <select wire:model="tipe" id="tipe" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                    <option value="pembelian">Pembelian</option>
                                    <option value="penghapusan">Penghapusan</option>
                                    <option value="penambahan_titipan">Penambahan Titipan</option>
                                    <option value="pengambilan_titipan">Pengambilan Titipan</option>
                                </select>
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </div>
                            @error('tipe') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-theme-black">Tanggal</label>
                            <div class="relative">
                                <input wire:model="tanggal" id="tanggal" type="date" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            @error('tanggal') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Jumlah -->
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-theme-black">Jumlah</label>
                            <div class="relative">
                                <input wire:model.live="jumlah" id="jumlah" type="number" min="1" x-ref="jumlah" placeholder="Masukkan jumlah" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 4a2 2 0 012-2h12a2 2 0 012 2v2H2V4zm0 4v8a2 2 0 002 2h12a2 2 0 002-2V8H2zm3 2h2v2H5v-2zm4 0h2v2H9v-2zm4 0h2v2h-2v-2z" />
                                    </svg>
                                </span>
                            </div>
                            @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Harga Beli -->
                        <div>
                            <label for="harga_beli" class="block text-sm font-medium text-theme-black">Harga Beli</label>
                            <div class="relative">
                                <input wire:model.live="harga_beli" id="harga_beli" type="number" step="0.01" min="0" placeholder="Masukkan harga beli" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            @error('harga_beli') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Total Harga -->
                        <div>
                            <label for="total_harga" class="block text-sm font-medium text-theme-black">Total Harga</label>
                            <div class="relative">
                                <input wire:model="total_harga" id="total_harga" type="text" readonly value="Rp {{ number_format($total_harga ?? 0, 2, ',', '.') }}" class="mt-1 block w-full rounded-md border-theme-black bg-gray-100 shadow-sm pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Input Alasan -->
                        <div>
                            <label for="alasan" class="block text-sm font-medium text-theme-black">Alasan</label>
                            <div class="relative">
                                <textarea wire:model="alasan" id="alasan" placeholder="Masukkan alasan (opsional)" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pt-2 text-base"></textarea>
                                <span class="absolute inset-y-0 left-0 flex items-start pl-3 pt-2">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            @error('alasan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">Reset</button>
                        <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $isEditing ? 'Update Persediaan' : 'Tambah Persediaan' }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Persediaan -->
            <div id="tabel-persediaan" class="lg:col-span-2 bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Daftar Persediaan</span>
                </h2>

                <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:space-x-4">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.500ms="search_query_table" id="search" placeholder="Cari nama barang atau tanggal..." class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="relative overflow-y-auto max-h-[calc(100%-12rem)] scrollbar-thin scrollbar-thumb-theme-primary scrollbar-track-theme-surface">
                    <div class="border border-gray-300 p-1">
                        <table class="w-full table-auto border-collapse text-xs">
                            <thead class="sticky top-0 bg-theme-primary text-white z-10">
                                <tr>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Barang</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Dikelola Oleh</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Tipe</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Tanggal</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Jumlah</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Total Harga</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Alasan</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="persediaanTable">
                                @forelse($persediaans as $p)
                                    <tr class="border border-theme-primary hover:bg-theme-light">
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">{{ $p->barang->kode_barang }} - {{ $p->barang->nama }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">{{ $p->kelola->nama }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">
                                            @if($p->tipe === 'pembelian')
                                                Pembelian
                                            @elseif($p->tipe === 'penghapusan')
                                                Penghapusan
                                            @elseif($p->tipe === 'penambahan_titipan')
                                                Penambahan Titipan
                                            @elseif($p->tipe === 'pengambilan_titipan')
                                                Pengambilan Titipan
                                            @else
                                                {{ ucfirst(str_replace('_', ' ', $p->tipe)) }}
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-nowrap">{{ $p->tanggal }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary text-center">{{ $p->jumlah }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">Rp {{ number_format($p->total_harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">{{ $p->alasan ?? '-' }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary text-center">
                                            <div class="flex justify-center space-x-1">
                                                <button wire:click="confirmEdit({{ $p->id }})" class="bg-yellow-400 hover:bg-yellow-500 text-black py-1 px-2 rounded flex items-center space-x-1 text-xs">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <span>Edit</span>
                                                </button>
                                                <button wire:click="confirmDelete({{ $p->id }})" class="bg-red-400 hover:bg-red-500 text-white py-1 px-2 rounded flex items-center space-x-1 text-xs">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-2 text-theme-black border border-theme-primary">Data tidak ada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div class="flex space-x-2">
                        <button wire:click="previousPage" {{ $persediaans->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs"><</button>
                        @foreach ($persediaans->getUrlRange(1, $persediaans->lastPage()) as $page => $url)
                            <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 {{ $persediaans->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-theme-light text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white text-xs">{{ $page }}</button>
                        @endforeach
                        <button wire:click="nextPage" {{ $persediaans->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs">></button>
                    </div>
                    <span class="text-xs text-theme-black">
                        Menampilkan {{ $persediaans->firstItem() ?: 0 }} - {{ $persediaans->lastItem() ?: 0 }} dari {{ $persediaans->total() }} data
                    </span>
                </div>
            </div>
        </div>

        <!-- Tabel Histori -->
        <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-theme-black flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Histori Perubahan Persediaan</span>
                </h2>
                <button wire:click="toggleHistory" class="px-4 py-2 bg-theme-primary text-theme-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $showHistory ? 'M6 18L18 6M6 6l12 12' : 'M5 15l7-7 7 7' }}"></path>
                    </svg>
                    <span>{{ $showHistory ? 'Sembunyikan Histori' : 'Tampilkan Histori' }}</span>
                </button>
            </div>
            @if($showHistory)
                <div class="relative overflow-y-auto max-h-[calc(100%-12rem)] scrollbar-thin scrollbar-thumb-theme-primary scrollbar-track-theme-surface">
                    <div class="border border-gray-300 p-1">
                        <table class="w-full table-auto border-collapse text-xs">
                            <thead class="sticky top-0 bg-theme-primary text-white z-10">
                                <tr>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Waktu</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Dikelola Oleh</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Aksi</th>
                                    <th class="px-2 py-2 border border-theme-primary text-left">Detail Perubahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activityLogs as $log)
                                    <tr class="border border-theme-primary hover:bg-theme-light">
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-nowrap">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">{{ $log->causer->nama ?? 'Unknown' }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-nowrap">{{ ucfirst($log->event) }}</td>
                                        <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">
                                            @if($log->event === 'created')
                                                Ditambahkan: 
                                                @if($log->properties['attributes']['tipe'] === 'pembelian')
                                                    Pembelian
                                                @elseif($log->properties['attributes']['tipe'] === 'penghapusan')
                                                    Penghapusan
                                                @elseif($log->properties['attributes']['tipe'] === 'penambahan_titipan')
                                                    Penambahan Titipan
                                                @elseif($log->properties['attributes']['tipe'] === 'pengambilan_titipan')
                                                    Pengambilan Titipan
                                                @else
                                                    {{ $log->properties['attributes']['tipe'] }}
                                                @endif
                                                untuk barang {{ $log->subject?->barang->nama ?? \App\Models\Barang::find($log->properties['attributes']['barang_id'])->nama ?? 'Unknown' }} sebanyak {{ $log->properties['attributes']['jumlah'] }}
                                            @elseif($log->event === 'updated')
                                                Diperbarui:
                                                @foreach($log->properties['attributes'] as $key => $newValue)
                                                    @if(isset($log->properties['old'][$key]))
                                                        @if($key === 'tipe')
                                                            {{ $key }} dari 
                                                            @if($log->properties['old'][$key] === 'pembelian')
                                                                Pembelian
                                                            @elseif($log->properties['old'][$key] === 'penghapusan')
                                                                Penghapusan
                                                            @elseif($log->properties['old'][$key] === 'penambahan_titipan')
                                                                Penambahan Titipan
                                                            @elseif($log->properties['old'][$key] === 'pengambilan_titipan')
                                                                Pengambilan Titipan
                                                            @else
                                                                {{ $log->properties['old'][$key] }}
                                                            @endif
                                                            menjadi 
                                                            @if($newValue === 'pembelian')
                                                                Pembelian
                                                            @elseif($newValue === 'penghapusan')
                                                                Penghapusan
                                                            @elseif($newValue === 'penambahan_titipan')
                                                                Penambahan Titipan
                                                            @elseif($newValue === 'pengambilan_titipan')
                                                                Pengambilan Titipan
                                                            @else
                                                                {{ $newValue }}
                                                            @endif
                                                        @else
                                                            {{ $key }} dari "{{ $log->properties['old'][$key] }}" menjadi "{{ $newValue }}"
                                                        @endif
                                                        ;
                                                    @endif
                                                @endforeach
                                            @elseif($log->event === 'deleted')
                                                Dihapus: 
                                                @if($log->properties['old']['tipe'] === 'pembelian')
                                                    Pembelian
                                                @elseif($log->properties['old']['tipe'] === 'penghapusan')
                                                    Penghapusan
                                                @elseif($log->properties['old']['tipe'] === 'penambahan_titipan')
                                                    Penambahan Titipan
                                                @elseif($log->properties['old']['tipe'] === 'pengambilan_titipan')
                                                    Pengambilan Titipan
                                                @else
                                                    {{ $log->properties['old']['tipe'] }}
                                                @endif
                                                untuk barang {{ \App\Models\Barang::find($log->properties['old']['barang_id'])->nama ?? 'Unknown' }} sebanyak {{ $log->properties['old']['jumlah'] }}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-2 text-theme-black border border-theme-primary">Tidak ada histori perubahan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div class="flex space-x-2">
                        <button wire:click="previousHistoryPage" {{ $activityLogs->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs"><</button>
                        @foreach ($activityLogs->getUrlRange(1, $activityLogs->lastPage()) as $page => $url)
                            <button wire:click="gotoHistoryPage({{ $page }})" class="px-3 py-1 {{ $activityLogs->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-theme-light text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white text-xs">{{ $page }}</button>
                        @endforeach
                        <button wire:click="nextHistoryPage" {{ $activityLogs->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs">></button>
                    </div>
                    <span class="text-xs text-theme-black">
                        Menampilkan {{ $activityLogs->firstItem() ?: 0 }} - {{ $activityLogs->lastItem() ?: 0 }} dari {{ $activityLogs->total() }} histori
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Add x-cloak CSS and Scrollbar Styles -->
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
            background: #f1f5f9;
        }
        thead.sticky th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #007022;
            color: white;
        }
    </style>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JavaScript untuk menangani SweetAlert dan Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search_barang');
            const jumlahInput = document.getElementById('jumlah');
            const dropdown = document.querySelector('[x-ref="dropdown"]');
            if (searchInput) {
                searchInput.focus();
            }

            function adjustDropdownWidth() {
                if (!dropdown) return;
                const items = dropdown.querySelectorAll('li');
                if (items.length === 0) return;

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                context.font = '12px sans-serif';
                let maxWidth = 0;

                items.forEach(item => {
                    const text = item.textContent;
                    const textWidth = context.measureText(text).width;
                    maxWidth = Math.max(maxWidth, textWidth);
                });

                const extraWidth = maxWidth * 0.05;
                const totalWidth = maxWidth + extraWidth + 32;
                const inputWidth = searchInput.getBoundingClientRect().width;

                dropdown.style.width = `${Math.min(totalWidth, inputWidth)}px`;
            }

            new MutationObserver(adjustDropdownWidth).observe(dropdown, { childList: true, subtree: true });

            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !e.target.closest('.absolute.z-50')) {
                    Alpine.data('searchOpen', () => false);
                }
            });

            window.addEventListener('barangSelected', () => {
                if (jumlahInput) {
                    jumlahInput.focus();
                    jumlahInput.select();
                }
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:confirmSave', () => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data persediaan akan ditambahkan.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007022',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tambah!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('proceedSave');
                    }
                });
            });

            Livewire.on('swal:confirmUpdatePersediaan', () => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data persediaan akan diperbarui.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007022',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, perbarui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('proceedUpdate');
                    }
                });
            });

            Livewire.on('swal:confirmDeletePersediaan', (data) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data persediaan akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#007022',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deletePersediaan', { id: data.id });
                    }
                });
            });

            Livewire.on('swal:success', (data) => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#007022',
                    confirmButtonText: 'OK'
                });
            });

            Livewire.on('swal:error', (data) => {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</div>