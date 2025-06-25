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
        title="Manajemen Pengeluaran" 
        icon="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"
    />

    <!-- Konten Utama -->
    <div class="space-y-6 flex-1">

        <!-- Form dan Tabel Pengeluaran -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Pengeluaran -->
            <div id="form-pengeluaran" class="max-h-[calc(100vh-0.5vh)] overflow-y-auto bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <x-card-header 
                    title="{{ $isEditing ? 'Edit Pengeluaran' : 'Tambah Pengeluaran' }}" 
                    icon="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" 
                />
                <form wire:submit.prevent="save">
                    <div class="space-y-4 px-6 px-6">

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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"></path>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                    </svg>
                                </span>
                            </div>
                            @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-4 flex justify-end space-x-2 px-6">
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
            <div id="tabel-pengeluaran" class="lg:col-span-2 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <x-card-header 
                    title="Daftar Pengeluaran" 
                    icon="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" 
                />
                
                <!-- Search -->
                <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:space-x-4 px-6">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari deskripsi atau tanggal..." class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"  />
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

                <div class="px-6">
                    <!-- Komponen Tabel -->
                    <x-table 
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
    </div>

    <!-- Add x-cloak CSS -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

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