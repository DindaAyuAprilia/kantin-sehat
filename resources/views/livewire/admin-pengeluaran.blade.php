<div class="p-[5%] space-y-6 snap-y snap-mandatory overflow-y-auto h-screen">
    <!-- Success Alert -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded border border-theme-primary snap-start">
            {{ session('success') }}
        </div>
    @endif

    <!-- Loading Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" x-show="$wire.isLoading" x-cloak>
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-theme-primary"></div>
    </div>

    <!-- Main Header -->
    <div class="mb-6 bg-theme-primary text-theme-white rounded-lg p-6 shadow-lg border border-theme-primary snap-start">
        <div class="flex items-center space-x-4">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <div>
                <h2 class="text-4xl font-bold">Manajemen Pengeluaran</h2>
                <p class="text-sm mt-1">{{ now()->format('l, F d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Form dan Tabel Pengeluaran -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Pengeluaran -->
        <div class="bg-theme-surface p-6 rounded-lg shadow-lg border border-theme-primary snap-start">
            <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>{{ $isEditing ? 'Edit Pengeluaran' : 'Tambah Pengeluaran' }}</span>
            </h3>
            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-theme-black">Tanggal</label>
                        <div class="mt-1 relative rounded-md shadow-sm border border-theme-primary">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="date" id="tanggal" wire:model="tanggal" class="pl-10 block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                            @error('tanggal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-theme-black">Deskripsi</label>
                        <div class="mt-1 relative rounded-md shadow-sm border border-theme-primary">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            <input type="text" id="deskripsi" wire:model="deskripsi" class="pl-10 block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50" placeholder="Masukkan deskripsi">
                            @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-theme-black">Jumlah</label>
                        <div class="mt-1 relative rounded-md shadow-sm border border-theme-primary">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 8c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path>
                                </svg>
                            </div>
                            <input type="number" id="jumlah" wire:model="jumlah" step="0.01" min="0" class="pl-10 block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50" placeholder="Masukkan jumlah">
                            @error('jumlah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</button>
                    <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 border border-theme-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>{{ $isEditing ? 'Update' : 'Simpan' }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Pengeluaran -->
        <div class="lg:col-span-2 bg-theme-surface rounded-lg shadow-lg border border-theme-primary snap-start">
            <h3 class="text-xl font-medium text-theme-black bg-theme-light rounded-t-lg px-4 py-3 flex items-center space-x-3 border-b border-theme-primary">
                <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                <span>Daftar Pengeluaran</span>
            </h3>
            <div class="p-6 rounded-b-lg">
                <div class="mb-4 flex space-x-4">
                    <div class="flex-1">
                        <div class="relative rounded-md shadow-sm border border-theme-primary">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.500ms="search" class="pl-10 block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50" placeholder="Cari deskripsi atau tanggal...">
                        </div>
                    </div>
                    <div>
                        <div class="relative rounded-md shadow-sm border border-theme-primary">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="month" wire:model.live="selectedMonth" class="form-control pl-10 block w-full rounded-md border-theme-primary shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50">
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-theme-primary text-white">
                                <th class="px-4 py-2 border border-theme-primary">Tanggal</th>
                                <th class="px-4 py-2 border border-theme-primary">Deskripsi</th>
                                <th class="px-4 py-2 border border-theme-primary">Jumlah</th>
                                <th class="px-4 py-2 border border-theme-primary">Dibuat Oleh</th>
                                <th class="px-4 py-2 border border-theme-primary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluarans as $pengeluaran)
                                <tr class="hover:bg-theme-light">
                                    <td class="border px-4 py-2 border-theme-primary">{{ $pengeluaran->tanggal }}</td>
                                    <td class="border px-4 py-2 border-theme-primary">{{ $pengeluaran->deskripsi }}</td>
                                    <td class="border px-4 py-2 text-right border-theme-primary">Rp {{ number_format($pengeluaran->jumlah, 2, ',', '.') }}</td>
                                    <td class="border px-4 py-2 border-theme-primary">{{ $pengeluaran->user->nama ?? 'Unknown' }}</td>
                                    <td class="border px-4 py-2 border-theme-primary text-center">
                                        <div class="flex justify-center space-x-2">
                                            <button wire:click="editPengeluaran({{ $pengeluaran->id }})" class="bg-yellow-400 hover:bg-yellow-500 text-black py-1.5 px-4 rounded flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span>Edit</span>
                                            </button>
                                            <button wire:click="confirmDelete({{ $pengeluaran->id }})" class="bg-red-400 hover:bg-red-500 text-white py-1.5 px-4 rounded flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border px-4 py-2 text-center border-theme-primary">Tidak ada data pengeluaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="flex space-x-2">
                        <button wire:click="previousPage" {{ $pengeluarans->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300"> < </button>
                        @foreach ($pengeluarans->getUrlRange(1, $pengeluarans->lastPage()) as $page => $url)
                            <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 {{ $pengeluarans->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-theme-light text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white">
                                {{ $page }}
                            </button>
                        @endforeach
                        <button wire:click="nextPage" {{ $pengeluarans->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300"> > </button>
                    </div>
                    <span class="text-sm text-theme-black">
                        Menampilkan {{ $pengeluarans->firstItem() ?: 0 }} - {{ $pengeluarans->lastItem() ?: 0 }} dari {{ $pengeluarans->total() }} data
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal:confirmUpdatePengeluaran', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data pengeluaran akan diperbarui.',
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

        window.addEventListener('swal:confirmDeletePengeluaran', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data pengeluaran akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#007022',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('proceedDelete', [event.detail.id]);
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