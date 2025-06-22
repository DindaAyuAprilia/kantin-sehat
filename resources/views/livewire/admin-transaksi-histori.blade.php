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

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', function () {
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
                });
            });

            Livewire.on('swal:error', (event) => {
                Swal.fire({
                    title: 'Gagal!',
                    text: event.message,
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</div>