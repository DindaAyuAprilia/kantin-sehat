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
        title="Manajemen Gaji" 
        icon="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"
    />

    <!-- Konten Utama -->
    <div class="space-y-6 flex-1">

        <!-- Gaji Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Card Form Pembayaran Gaji -->
            <div id="form-pembayaran" class="bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <x-card-header 
                    title="{{ $isModifyingPembayaran ? 'Edit Pembayaran Gaji' : 'Pembayaran Gaji' }}" 
                    icon="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" 
                />

                <form wire:submit.prevent="{{ $isModifyingPembayaran ? 'confirmUpdate' : 'savePembayaran' }}">
                    <div class="space-y-4 px-6">

                        <!-- Input Karyawan -->
                        <div>
                            <label for="kasir" class="block text-sm font-medium text-theme-black">Pilih Karyawan</label>
                            <div class="relative">
                                <select wire:model="selectedKasirId" id="kasir" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($kasirs as $kasir)
                                        <option value="{{ $kasir->id }}">{{ $kasir->nama }} ({{ $kasir->email }})</option>
                                    @endforeach
                                </select>
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"  />
                                    </svg>
                                </span>
                            </div>
                            @error('selectedKasirId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Jumlah Gaji -->
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-theme-black">Jumlah Gaji</label>
                            <div class="relative">
                                <input wire:model="jumlah" id="jumlah" type="number" placeholder="Masukkan jumlah gaji" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </span>
                            </div>
                            @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Tanggal Pembayaran -->
                        <div>
                            <label for="tanggal_pembayaran" class="block text-sm font-medium text-theme-black">Tanggal Pembayaran</label>
                            <div class="relative">
                                <input wire:model="tanggal_pembayaran" id="tanggal_pembayaran" type="date" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"  />
                                    </svg>
                                </span>
                            </div>
                            @error('tanggal_pembayaran') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-4 flex justify-end space-x-2 px-6">
                        <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</button>
                        <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $isModifyingPembayaran ? 'Update Pembayaran' : 'Catat Pembayaran' }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Riwayat Pembayaran Gaji -->
            <div id="tabel-pembayaran" class="lg:col-span-2 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <x-card-header 
                    title="Riwayat Pembayaran Gaji" 
                    icon="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18" 
                />

                <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:space-x-4 px-6">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.500ms="search" id="searchPayment" placeholder="Cari nama, tanggal, atau jumlah..." class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"  />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="px-6">
                    <x-table 
                        :headers="[
                            ['key' => 'karyawan', 'label' => 'Nama Karyawan', 'format' => 'relation', 'align' => 'left'],
                            ['key' => 'admin', 'label' => 'Admin', 'format' => 'relation', 'align' => 'left'],
                            ['key' => 'tanggal_pembayaran', 'label' => 'Tanggal', 'format' => 'tanggal', 'align' => 'center'],
                            ['key' => 'jumlah', 'label' => 'Jumlah', 'format' => 'currency', 'align' => 'right'],
                        ]"
                        :data="$paymentHistory"
                        :actions="[
                            ['label' => 'Edit', 'wire:click' => 'editPembayaran', 'class' => 'bg-yellow-400 hover:bg-yellow-500 text-black', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                            ['label' => 'Hapus', 'wire:click' => 'confirmDelete', 'class' => 'bg-red-400 hover:bg-red-500 text-white', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
                        ]"
                        per-page="10"
                        table-id="pembayaranTable"
                    />
                </div>
                
            </div>
        </div>
    </div>

    <!-- Add x-cloak CSS to hide elements until Alpine.js is loaded -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- JavaScript untuk menangani SweetAlert -->
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

            Livewire.on('swal:confirmUpdate', () => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin memperbarui data pembayaran gaji?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('proceedUpdatePembayaran');
                    }
                });
            });

            Livewire.on('swal:confirmDelete', (data) => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data pembayaran gaji?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deletePembayaran', { id: data.id });
                    }
                });
            });
        });
    </script>
</div>