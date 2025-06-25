<div class="min-h-screen flex flex-col p-4 sm:p-[2%] overflow-hidden">

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
        title="Manajemen Histori Transaksi" 
        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
    />

    <!-- Form Transaksi Baru -->
    <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary mb-6">
        <x-card-header 
            title="Transaksi Baru"
            icon="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" 
        />
        <div class="mb-6 px-6">
            <label for="new_transaction_search" class="block text-sm font-medium text-theme-black">Scan Barcode atau Cari Barang</label>
            <div class="relative">
                <input wire:model.live="new_transaction_search" wire:keydown.enter="addItem" id="new_transaction_search" type="text" placeholder="Scan barcode atau ketik nama barang"
                       class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2"
                       x-ref="new_transaction_search_input" x-on:keydown.escape="$wire.searchResults = []" autocomplete="off">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                    </svg>
                </span>
            </div>
            <!-- Dropdown Hasil Pencarian -->
            <div x-show="$wire.new_transaction_search && ($wire.searchResults || []).length !== undefined" class="absolute z-10 mt-1 bg-white border border-theme-black rounded-md shadow-lg max-h-60 overflow-auto">
                <ul>
                    @if(empty($searchResults) && !empty($new_transaction_search))
                        <li class="px-4 py-2 text-theme-black">Tidak Ada Barang Ditemukan</li>
                    @else
                        @foreach($searchResults as $result)
                            <li wire:click="selectBarang({{ $result->id }})"
                                class="px-4 py-2 hover:bg-theme-primary hover:text-theme-white cursor-pointer">
                                {{ $result->kode_barang }} - {{ $result->nama }}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <!-- Daftar Keranjang -->
        <div class="mb-6 px-6">
            <h3 class="text-lg font-semibold mb-2 text-theme-black">Keranjang</h3>
            <div class="overflow-x-auto max-h-[calc(100vh-40vh)] overflow-y-auto ">
                <table class="min-w-full text-sm border-collapse border-2 border-theme-primary">
                    <thead class="sticky top-0 bg-theme-primary text-theme-white">
                        <tr class="border-b-2 border-theme-primary">
                            <th class="px-4 py-2 border-r-2 border-theme-primary">Barcode</th>
                            <th class="px-4 py-2 border-r-2 border-theme-primary">Nama Produk</th>
                            <th class="px-4 py-2 border-r-2 border-theme-primary">Harga Satuan</th>
                            <th class="px-4 py-2 border-r-2 border-theme-primary">Jumlah</th>
                            <th class="px-4 py-2 border-r-2 border-theme-primary">Subtotal</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cart as $index => $item)
                            <tr class="border-b border-theme-primary">
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $item['barcode'] }}</td>
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $item['name'] }}</td>
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="decrementQuantity({{ $index }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                        <input wire:model.live="cart.{{ $index }}.quantity" type="number" min="1"
                                               class="w-16 text-center border rounded py-1"
                                               wire:change="updateQuantity({{ $index }}, $event.target.value)">
                                        <button wire:click="incrementQuantity({{ $index }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-theme-black">
                                    <button wire:click="removeFromCart({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-theme-black text-center">Keranjang kosong.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-theme-primary">
                            <td colspan="-Musliman4" class="px-4 py-2 text-theme-black font-semibold">Total Harga</td>
                            <td class="px-4 py-2 text-theme-black">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                            <td class="px-4 py-2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @if(!empty($cart))
                <div class="mt-4">
                    <label class="block text-sm font-medium text-theme-black mb-2">Metode Pembayaran</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" wire:model="paymentMethod" value="tunai" class="form-radio text-theme-primary focus:ring-theme-secondary">
                            <span class="ml-2 text-theme-black">Tunai</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" wire:model="paymentMethod" value="non_tunai" class="form-radio text-theme-primary focus:ring-theme-secondary">
                            <span class="ml-2 text-theme-black">Non Tunai</span>
                        </label>
                    </div>
                    <div class="mt-4">
                        <label for="transactionDate" class="block text-sm font-medium text-theme-black">Tanggal Transaksi</label>
                        <div class="relative rounded-md shadow-sm border border-gray-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input wire:model="transactionDate" id="transactionDate" type="date" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="shift_id" class="block text-sm font-medium text-theme-black">Pilih Shift</label>
                        <div class="relative rounded-md shadow-sm border border-gray-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <select wire:model="shift_id" id="shift_id" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10" required>
                                <option value="">Pilih Shift</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->nama_shift }} ({{ $shift->jam_mulai->format('H:i') }} - {{ $shift->jam_selesai->format('H:i') }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button wire:click="createTransaction" class="mt-4 px-4 py-2 bg-theme-primary text-theme-white rounded-md hover:bg-theme-secondary focus:outline-none focus:ring-2 focus:ring-theme-secondary">
                        Simpan Transaksi
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
        <x-card-header 
            title="Daftar Transaksi"
            icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" 
        />
        <div class="mb-4 flex space-x-4 px-6">
            <div class="flex-1">
                <div class="relative rounded-md shadow-sm border border-gray-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari Unix ID atau nama admin..."
                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                </div>
            </div>
            <div>
                <div class="relative rounded-md shadow-sm border border-gray-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <select wire:model.live="filter_metode_pembayaran" id="filter_metode_pembayaran" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                        <option value="">Semua Metode</option>
                        <option value="tunai">Tunai</option>
                        <option value="non_tunai">Non Tunai</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="px-6">
            <!-- Komponen Tabel -->
        <x-table 
            :headers="[
                ['key' => 'unix_id', 'label' => 'Unix ID', 'align' => 'left'],
                ['key' => 'tanggal', 'label' => 'Tanggal', 'format' => 'tanggal_transaksi', 'align' => 'center'],
                ['key' => 'user', 'label' => 'Admin', 'format' => 'relation', 'align' => 'left'],
                ['key' => 'total_harga', 'label' => 'Total Harga', 'format' => 'currency', 'align' => 'right'],
                ['key' => 'metode_pembayaran', 'label' => 'Metode Pembayaran', 'format' => 'ucfirst', 'align' => 'center'],
                ['key' => 'details', 'label' => 'Detail', 'format' => 'transaction_details', 'align' => 'left'],
            ]"
            :data="$transactions"
            :actions="[
                ['label' => 'Edit', 'wire:click' => 'editTransaction', 'class' => 'bg-yellow-400 hover:bg-yellow-500 text-black', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                ['label' => 'Hapus', 'wire:click' => 'confirmDelete', 'class' => 'bg-red-400 hover:bg-red-500 text-white', 'icon' => 'M6 18L18 6M6 6l12 12'],
            ]"
            per-page="10"
            table-id="transaksiTable"
        />
        </div>
    </div>

    <!-- Modal Edit Transaksi -->
    @if($editingTransactionId)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <x-card-header 
                    title="Edit Transaksi"
                    icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" 
                />
                
                <form wire:submit.prevent="saveTransaction">
                    <div class="space-y-4 px-6">
                        <div>
                            <label for="editingDate" class="block text-sm font-medium text-theme-black">Tanggal</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input wire:model="editingDate" id="editingDate" type="date" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10" required>
                            </div>
                        </div>
                        @foreach($editingDetails as $index => $detail)
                            <div class="border-t pt-4">
                                @if($detail['barang_id'])
                                    <label class="block text-sm font-medium text-theme-black">{{ $detail['nama'] }}</label>
                                    <div class="relative rounded-md shadow-sm border border-gray-300">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 -webkit-transform: rotate(90deg); transform: rotate(90deg);24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                            </svg>
                                        </div>
                                        <input wire:model="editingDetails.{{ $index }}.jumlah" type="number" min="1" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10" required>
                                    </div>
                                @else
                                    <label for="keterangan_{{ $index }}" class="block text-sm font-medium text-theme-black">Keterangan</label>
                                    <div class="relative rounded-md shadow-sm border border-gray-300">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2h-3l-4 4z"></path>
                                            </svg>
                                        </div>
                                        <input wire:model="editingDetails.{{ $index }}.keterangan" id="keterangan_{{ $index }}" type="text" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10" required>
                                    </div>
                                    <label for="subtotal_{{ $index }}" class="block text-sm font-medium text-theme-black mt-2">Jumlah</label>
                                    <div class="relative rounded-md shadow-sm border border-gray-300">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2m-2 0h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm2 3h2m4 0h2"></path>
                                            </svg>
                                        </div>
                                        <input wire:model="editingDetails.{{ $index }}.subtotal" id="subtotal_{{ $index }}" type="number" min="0" step="0.01" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10" required>
                                    </div>
                                @endif
                                <button type="button" wire:click="removeDetail({{ $index }})" class="mt-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>Remove</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 flex justify-end space-x-2 px-6">
                        <button type="button" wire:click="cancelEdit" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', function () {
            // Fokus input pencarian transaksi baru
            const focusSearchInput = () => {
                const searchInput = document.getElementById('new_transaction_search');
                if (searchInput) {
                    setTimeout(() => searchInput.focus(), 100);
                }
            };

            Livewire.on('focus-transaction-input', focusSearchInput);

            Livewire.on('swal:confirmAction', (event) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: event.message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007022',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(event.action, { id: event.id });
                    }
                });
            });

            Livewire.on('swal:success', (event) => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: event.message,
                    icon: 'success',
                    confirmButtonColor: '#007022',
                    confirmButtonText: 'OK'
                }).then(() => focusSearchInput());
            });

            Livewire.on('swal:error', (event) => {
                Swal.fire({
                    title: 'Gagal!',
                    text: event.message,
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then(() => focusSearchInput());
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', (e) => {
                const searchInput = document.getElementById('new_transaction_search');
                const dropdown = document.querySelector('.absolute.z-10');
                if (searchInput && dropdown && !searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    Livewire.dispatch('clear-search-results');
                }
            });
        });
    </script>
</div>