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
        title="Manajemen Shift"
        icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
        :active-tab="$activeTab"
        :tabs="[
            ['key' => 'transaksi', 'label' => 'Transaksi'],
            ['key' => 'shift', 'label' => 'Shift']
        ]"
    />

    <!-- Tab Content -->
    <div class="space-y-6" x-data="{ activeTab: '{{ $activeTab }}' }">
        <!-- Shift Tab -->
        @if ($activeTab === 'shift')
            <div class="grid grid-cols-1 lg:grid-cols-3 pb-4">
                <!-- Form Shift -->
                <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="{{ $isEditing ? 'Edit Shift' : 'Tambah Shift' }}"
                        icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" 
                    />
                    <form wire:submit.prevent="{{ $isEditing ? 'confirmUpdate' : 'saveShift' }}" x-data="{ formSubmitted: false }">
                        <div class="space-y-4 px-perpink-20 px-6">
                            <div>
                                <label for="nama_shift" class="block text-sm font-medium text-theme-black">Nama Shift</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="nama_shift" id="nama_shift" type="text" placeholder="Masukkan nama shift"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('nama_shift')" x-text="$wire.get('errors').first('nama_shift')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-theme-black">Jam Mulai</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="jam_mulai" id="jam_mulai" type="time"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('jam_mulai')" x-text="$wire.get('errors').first('jam_mulai')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-theme-black">Jam Selesai</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="jam_selesai" id="jam_selesai" type="time"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('jam_selesai')" x-text="$wire.get('errors').first('jam_selesai')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2 px-6">
                            <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">Reset</button>
                            <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isEditing ? 'Update Shift' : 'Tambah Shift' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Shift -->
                <div class="lg:col-span-2 bg-theme-surface mt-6 pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="Daftar Shift"
                        icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" 
                    />
                    <div class="overflow-x-auto max-h-[calc(100vh-300px)] px-6">
                        <table class="w-full table-auto border-collapse text-xs">
                            <thead>
                                <tr class="bg-theme-primary text-white">
                                    <th class="px-2 py-2 border border-theme-primary text-left">Nama Shift</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Jam Mulai</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Jam Selesai</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shifts as $shift)
                                    <tr class="hover:bg-theme-light">
                                        <td class="border px-2 py-2 border-theme-primary whitespace-nowrap">{{ $shift->nama_shift }}</td>
                                        <td class="border px-2 py-2 border-theme-primary text-center">{{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }}</td>
                                        <td class="border px-2 py-2 border-theme-primary text-center">{{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }}</td>
                                        <td class="border px-2 py-2 border-theme-primary text-center">
                                            <div class="flex justify-center space-x-1">
                                                <button wire:click="confirmEdit({{ $shift->id }})" class="bg-yellow-400 hover:bg-yellow-500 text-black py-1 px-2 rounded flex items-center space-x-1 text-xs">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <span>Edit</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border px-2 py-2 text-center border-theme-primary text-xs">Tidak ada data shift.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Transaksi Tab -->
        @if ($activeTab === 'transaksi')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Filter Tanggal dan Shift -->
                <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="Filter Transaksi"
                        icon="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" 
                    />
                    <div class="space-y-4 px-6">
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-theme-black">Tanggal Mulai</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input wire:model.debounce.500ms="startDate" id="startDate" type="date"
                                    class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                            </div>
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-theme-black">Tanggal Selesai</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input wire:model.debounce.500ms="endDate" id="endDate" type="date"
                                    class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                            </div>
                        </div>
                        <div>
                            <label for="shiftSelect" class="block text-sm font-medium text-theme-black">Pilih Shift</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <select wire:model.debounce.500ms="selectedShiftId" id="shiftSelect"
                                    class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                                    <option value="">Semua Shift</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->nama_shift }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end px-6">
                            <button wire:click="applyFilter" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v4.586a1 1 0 01-.293.707l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 01-.293-.707v-4.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                <span>Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabel Transaksi dan Laporan -->
                <div class="lg:col-span-2 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="Daftar Transaksi"
                        icon="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" 
                    />
                    <div class="mb-4 px-6">
                        <label for="searchUnixId" class="block text-sm font-medium text-theme-black">Cari Unix ID</label>
                        <div class="relative rounded-md shadow-sm border border-gray-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.500ms="search" id="searchUnixId" type="text" placeholder="Masukkan Unix ID (e.g., 0001250222)"
                                class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                        </div>
                    </div>

                    <div class="px-6">
                        <x-table 
                        :headers="[
                            ['key' => 'unix_id', 'label' => 'Unix ID', 'align' => 'left'],
                            ['key' => 'created_at', 'label' => 'Tanggal & Jam', 'format' => 'datetime', 'align' => 'center'],
                            ['key' => 'total_harga', 'label' => 'Total Harga', 'format' => 'currency', 'align' => 'right'],
                            ['key' => 'metode_pembayaran', 'label' => 'Metode Pembayaran', 'format' => 'ucfirst', 'align' => 'center'],
                            ['key' => 'details', 'label' => 'Detail Titipan', 'format' => 'boolean_titipan', 'align' => 'center'],
                        ]"
                        :data="$transaksis"
                        :actions="[]"
                        per-page="10"
                        table-id="transaksiTable"
                    />
                    </div>
                    
                    <div class="mt-4 flex justify-end px-6">
                        <button wire:click="viewShiftReport" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m0-2v-2m0-2V9m6 8v-2m0-2v-2m0-2V9m-9-4h12a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
                            </svg>
                            <span>Lihat Laporan</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- SweetAlert2 CDN -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const namaShiftInput = document.getElementById('nama_shift');
            if (namaShiftInput) {
                namaShiftInput.focus();
            }

            namaShiftInput?.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (namaShiftInput.value.trim() !== '') {
                        document.getElementById('jam_mulai')?.focus();
                    }
                }
            });
        });

        document.addEventListener('livewire:load', function () {
            Livewire.on('resetForm', () => {
                const namaShiftInput = document.getElementById('nama_shift');
                if (namaShiftInput) {
                    namaShiftInput.focus();
                }
            });
        });

        // SweetAlert2 event listeners untuk Shift
        window.addEventListener('swal:confirmEditShift', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan mengedit data shift ini.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, edit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('editShift', { id: event.detail.id });
                }
            });
        });

        window.addEventListener('swal:confirmUpdateShift', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data shift akan diperbarui.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('proceedUpdateShift');
                }
            });
        });

        window.addEventListener('swal:confirmDeleteShift', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data shift akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#007022',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteShift', { id: event.detail.id });
                }
            });
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