<div class="p-6">
    <!-- Alert Success -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Alert Error -->
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Loading Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" wire:loading>
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-theme-primary"></div>
    </div>

    <!-- Tab Navigation -->
    <div x-data="{ activeTab: '{{ $activeTab }}' }" class="mb-8">
        <div class="flex justify-center">
            <div class="inline-flex bg-theme-surface rounded-lg shadow-md p-2 border-2 border-theme-primary" style="border-color: #007022;">
                <button @click="activeTab = 'transaksi'; $wire.set('activeTab', 'transaksi')" 
                        :class="{ 'bg-theme-primary text-white': activeTab === 'transaksi', 'bg-gray-100 text-theme-black': activeTab !== 'transaksi' }"
                        class="px-8 py-3 rounded-md font-semibold transition-all duration-300 hover:bg-theme-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-theme-secondary">
                    Transaksi
                </button>
                <button @click="activeTab = 'shift'; $wire.set('activeTab', 'shift')" 
                        :class="{ 'bg-theme-primary text-white': activeTab === 'shift', 'bg-gray-100 text-theme-black': activeTab !== 'shift' }"
                        class="px-8 py-3 rounded-md font-semibold transition-all duration-300 hover:bg-theme-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-theme-secondary">
                    Shift
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="mt-6">
            <!-- Shift Tab -->
            <div x-show="activeTab === 'shift'" class="min-h-screen flex flex-col lg:flex-row lg:gap-8 py-12">
                <!-- Form Shift -->
                <div id="form-shift" class="w-full lg:w-1/2 max-w-2xl p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary mx-auto mb-8 lg:mb-0" style="border-color: #007022;">
                    <h2 class="text-xl font-semibold text-theme-black mb-4">{{ $isEditing ? 'Edit Shift' : 'Tambah Shift' }}</h2>
                    <form wire:submit.prevent="{{ $isEditing ? 'confirmUpdate' : 'saveShift' }}">
                        <div class="space-y-4">
                            <div>
                                <label for="nama_shift" class="block text-sm font-medium text-theme-black">Nama Shift</label>
                                <input wire:model="nama_shift" id="nama_shift" type="text" placeholder="Masukkan nama shift"
                                    class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary">
                                @error('nama_shift') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-theme-black">Jam Mulai</label>
                                <input wire:model="jam_mulai" id="jam_mulai" type="time"
                                    class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary">
                                @error('jam_mulai') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-theme-black">Jam Selesai</label>
                                <input wire:model="jam_selesai" id="jam_selesai" type="time"
                                    class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary">
                                @error('jam_selesai') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class="mt-4 flex items-center gap-2 px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary transition-all">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $isEditing ? 'Update Shift' : 'Tambah Shift' }}
                        </button>
                    </form>
                </div>

                <!-- Tabel Shift -->
                <div id="tabel-shift" class="w-full lg:w-1/2 max-w-2xl p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary mx-auto mb-8 lg:mb-0" style="border-color: #007022;">
                    <h2 class="text-xl font-semibold text-theme-black mb-4">Daftar Shift</h2>
                    <div class="overflow-x-auto max-h-[calc(100vh-16rem)]">
                        <table class="min-w-full text-sm border border-theme-primary border-collapse">
                            <thead class="bg-theme-primary text-white sticky top-0">
                                <tr class="border-b border-theme-primary">
                                    <th class="px-4 py-2 border-r border-theme-primary">Nama Shift</th>
                                    <th class="px-4 py-2 border-r border-theme-primary">Jam Mulai</th>
                                    <th class="px-4 py-2 border-r border-theme-primary">Jam Selesai</th>
                                    <th class="px-4 py-2 border-r border-theme-primary">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shifts as $shift)
                                    <tr class="border-b border-theme-primary">
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $shift->nama_shift }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary flex space-x-2">
                                            <button wire:click="confirmEdit({{ $shift->id }})" class="text-theme-primary hover:text-theme-secondary">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button wire:click="confirmDelete({{ $shift->id }})" class="text-red-600 hover:text-red-800">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center text-theme-black border-t border-theme-primary">Tidak ada shift.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Transaksi Tab -->
            <div x-show="activeTab === 'transaksi'" class="min-h-screen flex flex-col lg:flex-row lg:gap-8 py-12">
                <!-- Filter Tanggal dan Shift -->
                <div class="w-full max-w-2xl p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary mx-auto mb-8 lg:mb-0" style="border-color: #007022;">
                    <h2 class="text-xl font-semibold text-theme-black mb-4">Filter Transaksi</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-theme-black">Tanggal Mulai</label>
                            <input wire:model="startDate" id="startDate" type="date"
                                class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary">
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-theme-black">Tanggal Selesai</label>
                            <input wire:model="endDate" id="endDate" type="date"
                                class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary">
                        </div>
                        <div>
                            <label for="shiftSelect" class="block text-sm font-medium text-theme-black">Pilih Shift</label>
                            <select wire:model="selectedShiftId" id="shiftSelect"
                                class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary">
                                <option value="">Semua Shift</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->nama_shift }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button wire:click="applyFilter"
                            class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary transition-all">
                            Filter
                        </button>
                    </div>
                </div>

                <!-- Tabel Transaksi dan Laporan -->
                <div id="tabel-transaksi" class="w-full max-w-2xl p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary mx-auto mb-8 lg:mb-0" style="border-color: #007022;">
                    <h2 class="text-xl font-semibold text-theme-black mb-4">Daftar Transaksi</h2>
                    <div class="mb-4">
                        <label for="searchUnixId" class="block text-sm font-medium text-theme-black">Cari Unix ID</label>
                        <input wire:model.live="search" id="searchUnixId" type="text" placeholder="Masukkan Unix ID (e.g., 0001250222)"
                            class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary">
                    </div>
                    <div class="overflow-x-auto max-h-[calc(100vh-16rem)]">
                        <table class="min-w-full text-sm border border-theme-primary border-collapse">
                            <thead class="bg-theme-primary text-white sticky top-0">
                                <tr class="border-b border-theme-primary">
                                    <th class="px-4 py-2 border-r border-theme-primary">Unix ID</th>
                                    <th class="px-4 py-2 border-r border-theme-primary">Tanggal & Jam</th>
                                    <th class="px-4 py-2 border-r border-theme-primary">Total Harga</th>
                                    <th class="px-4 py-2 border-r border-theme-primary">Metode Pembayaran</th>
                                    <th class="px-4 py-2 border-r border-theme-primary">Detail Titipan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                    <tr class="border-b border-theme-primary">
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $transaksi->unix_id }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">
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
                                        <td colspan="5" class="px-4 py-2 text-center text-theme-black border-t border-theme-primary">Tidak ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button wire:click="viewShiftReport"
                        class="mt-4 px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md">
                        Lihat Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                confirmButtonColor: '#3085d6',
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
                confirmButtonColor: '#3085d6',
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
                cancelButtonColor: '#3085d6',
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
                confirmButtonColor: '#3085d6',
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