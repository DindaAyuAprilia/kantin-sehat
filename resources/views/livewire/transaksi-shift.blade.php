<div class="min-h-screen flex flex-col justify-center p-4 sm:p-6 overflow-hidden">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h2 class="text-3xl font-bold">Manajemen Shift</h2>
                </div>
            </div>
            <!-- Tab Navigation -->
            <div class="flex space-x-2">
                <button wire:click="setActiveTab('transaksi')"
                        class="{{ $activeTab === 'transaksi' ? 'bg-white text-theme-primary' : 'bg-gray-200 text-gray-600' }} px-6 py-2 rounded-md font-semibold transition-all duration-300 hover:bg-gray-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-theme-secondary">
                    Transaksi
                </button>
                <button wire:click="setActiveTab('shift')"
                        class="{{ $activeTab === 'shift' ? 'bg-white text-theme-primary' : 'bg-gray-200 text-gray-600' }} px-6 py-2 rounded-md font-semibold transition-all duration-300 hover:bg-gray-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-theme-secondary">
                    Shift
                </button>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="space-y-6" x-data="{ activeTab: '{{ $activeTab }}' }">
        <!-- Shift Tab -->
        @if ($activeTab === 'shift')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Shift -->
                <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>{{ $isEditing ? 'Edit Shift' : 'Tambah Shift' }}</span>
                    </h3>
                    <form wire:submit.prevent="{{ $isEditing ? 'confirmUpdate' : 'saveShift' }}" x-data="{ formSubmitted: false }">
                        <div class="space-y-4">
                            <div>
                                <label for="nama_shift" class="block text-sm font-medium text-theme-black">Nama Shift</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="nama_shift" id="nama_shift" type="text" placeholder="Masukkan nama shift"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('nama_shift')" x-text="$wire.get('errors').first('nama_shift')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-theme-black">Jam Mulai</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="jam_mulai" id="jam_mulai" type="time"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('jam_mulai')" x-text="$wire.get('errors').first('jam_mulai')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-theme-black">Jam Selesai</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="jam_selesai" id="jam_selesai" type="time"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('jam_selesai')" x-text="$wire.get('errors').first('jam_selesai')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2">
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
                <div class="lg:col-span-2 bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Daftar Shift</span>
                    </h3>
                    <div class="overflow-x-auto max-h-[calc(100vh-300px)]">
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
                                                <button wire:click="confirmDelete({{ $shift->id }})" class="bg-red-400 hover:bg-red-500 text-white py-1 px-2 rounded flex items-center space-x-1 text-xs">
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
                <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span>Filter Transaksi</span>
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-theme-black">Tanggal Mulai</label>
                            <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input wire:model.debounce.500ms="startDate" id="startDate" type="date"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-theme-black">Tanggal Selesai</label>
                            <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input wire:model.debounce.500ms="endDate" id="endDate" type="date"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="shiftSelect" class="block text-sm font-medium text-theme-black">Pilih Shift</label>
                            <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <select wire:model.debounce.500ms="selectedShiftId" id="shiftSelect"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                                    <option value="">Semua Shift</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->nama_shift }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end">
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
                <div class="lg:col-span-2 bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span>Daftar Transaksi</span>
                    </h3>
                    <div class="mb-4">
                        <label for="searchUnixId" class="block text-sm font-medium text-theme-black">Cari Unix ID</label>
                        <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.500ms="search" id="searchUnixId" type="text" placeholder="Masukkan Unix ID (e.g., 0001250222)"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                        </div>
                    </div>
                    <div class="overflow-x-auto max-h-[calc(100vh-300px)]">
                        <table class="w-full table-auto border-collapse text-xs">
                            <thead>
                                <tr class="bg-theme-primary text-white">
                                    <th class="px-2 py-2 border border-theme-primary text-left">Unix ID</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Tanggal & Jam</th>
                                    <th class="px-2 py-2 border border-theme-primary text-right">Total Harga</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Metode Pembayaran</th>
                                    <th class="px-2 py-2 border border-theme-primary text-center">Detail Titipan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                    <tr class="hover:bg-theme-light">
                                        <td class="border px-2 py-2 border-theme-primary whitespace-nowrap">{{ $transaksi->unix_id }}</td>
                                        <td class="border px-2 py-2 border-theme-primary text-center">{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}</td>
                                        <td class="border px-2 py-2 border-theme-primary text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td class="border px-2 py-2 border-theme-primary text-center">{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                                        <td class="border px-2 py-2 border-theme-primary text-center">
                                            @php
                                                $hasTitipan = $transaksi->details->contains(function ($detail) {
                                                    return $detail->barang && $detail->barang->status_titipan;
                                                });
                                            @endphp
                                            {{ $hasTitipan ? 'Ya' : 'Tidak' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border px-2 py-2 text-center border-theme-primary text-xs">Tidak ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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