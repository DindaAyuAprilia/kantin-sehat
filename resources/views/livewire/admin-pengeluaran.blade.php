<div class="min-h-screen flex flex-col p-4 sm:p-[2%] overflow-hidden">

    <!-- Main Header -->
    <x-header-container 
        title="Manajemen Pengeluaran" 
        icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"
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

        <!-- Form dan Tabel Pengeluaran -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Pengeluaran -->
            <div id="form-pengeluaran" class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>{{ $isEditing ? 'Edit Pengeluaran' : 'Tambah Pengeluaran' }}</span>
                </h2>
                <form wire:submit.prevent="save">
                    <div class="space-y-4">
                        <!-- Input Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-theme-black">Tanggal</label>
                            <div class="relative">
                                <input type="date" id="tanggal" wire:model="tanggal" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                            </div>
                            @error('tanggal') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Input Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-theme-black">Deskripsi</label>
                            <div class="relative">
                                <input type="text" id="deskripsi" wire:model="deskripsi" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base" placeholder="Masukkan deskripsi">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </span>
                            </div>
                            @error('deskripsi') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Input Jumlah -->
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-theme-black">Jumlah</label>
                            <div class="relative">
                                <input type="number" id="jumlah" wire:model="jumlah" step="0.01" min="0" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base" placeholder="Masukkan jumlah">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 8c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path>
                                    </svg>
                                </span>
                            </div>
                            @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <!-- Tombol Submit -->
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</button>
                        <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $isEditing ? 'Update Pengeluaran' : 'Tambah Pengeluaran' }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Pengeluaran -->
            <div id="tabel-pengeluaran" class="lg:col-span-2 bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Daftar Pengeluaran</span>
                </h2>
                <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:space-x-4">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari deskripsi atau tanggal..." class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <div class="relative">
                        <input type="month" wire:model.live="selectedMonth" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Komponen Tabel -->
                <x-table-container 
                    :headers="[
                        ['key' => 'tanggal', 'label' => 'Tanggal', 'format' => 'tanggal', 'align' => 'center'],
                        ['key' => 'deskripsi', 'label' => 'Deskripsi', 'align' => 'left'],
                        ['key' => 'jumlah', 'label' => 'Jumlah', 'format' => 'currency', 'align' => 'right'],
                        ['key' => 'user', 'label' => 'Dibuat Oleh', 'format' => 'relation', 'align' => 'left'],
                    ]"
                    :data="$pengeluarans"
                    :actions="[
                        ['label' => 'Edit', 'wire:click' => 'editPengeluaran', 'class' => 'bg-yellow-400 hover:bg-yellow-500 text-black', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                        ['label' => 'Hapus', 'wire:click' => 'confirmDelete', 'class' => 'bg-red-400 hover:bg-red-500 text-white', 'icon' => 'M6 18L18 6M6 6l12 12'],
                    ]"
                    per-page="10"
                    table-id="pengeluaranTable"
                />

            </div>
        </div>
    </div>

    <!-- Add x-cloak CSS -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (data) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: data.message,
                    confirmButtonText: 'OK',
                });
            });

            Livewire.on('swal:confirmUpdatePengeluaran', () => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin memperbarui data pengeluaran?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('proceedUpdate');
                    }
                });
            });

            Livewire.on('swal:confirmDeletePengeluaran', (data) => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data pengeluaran?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('proceedDelete', [data.id]);
                    }
                });
            });

            Livewire.on('swal:error', (data) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message,
                    confirmButtonText: 'OK',
                });
            });
        });
    </script>
</div>