<div class="min-h-screen flex flex-col justify-center p-4 sm:p-[2%] overflow-hidden">
    <!-- Main Header -->
    <div class="mb-4 bg-theme-primary text-theme-white rounded-lg p-6 shadow-lg border-2 border-theme-primary">
        <div class="flex items-center space-x-4">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h2 class="text-4xl font-bold">Manajemen Gaji</h2>
                <p class="text-sm mt-1">{{ now()->format('l, F d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="space-y-6 flex-1">
        <!-- Alert Success -->
        @if (session('success'))
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded border-2 border-theme-primary">
                {{ session('success') }}
            </div>
        @endif

        <!-- Alert Error -->
        @if (session('error'))
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded border-2 border-theme-primary">
                {{ session('error') }}
            </div>
        @endif

        <!-- Gaji Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Pembayaran Gaji -->
            <div id="form-pembayaran" class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>{{ $isModifyingPembayaran ? 'Edit Pembayaran Gaji' : 'Pembayaran Gaji' }}</span>
                </h2>

                <form wire:submit.prevent="{{ $isModifyingPembayaran ? 'confirmUpdate' : 'savePembayaran' }}">
                    <div class="space-y-4">
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
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
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
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.106-.057.21-.118.316-.177a1 1 0 011.415 1.414c-.297.298-.654.55-1.05.73-.396.18-.854.297-1.357.297-.615 0-1.193-.194-1.633-.533a1 1 0 011.414-1.414c.108.108.24.198.378.27.138.073.294.122.477.122s.339-.05.477-.122zm4.767 5.297c-.106.057-.21-.118-.316.177a1 1 0 01-1.415-1.414c.297-.298.654-.55 1.05-.73-.396-.18.854-.297 1.357-.297c.615 0 1.193.194 1.633.533a1 1 0 01-1.414 1.414c-.108-.108-.240-.198-.378-.270-.138-.073-.294-.122-.477-.122s-.339.05-.477.122zM3 3v14a2 2 0 002 2h10a2 2 0 002-2V3a2 2 0 00-2-2H5a2 2 0 00-2 2zm11 0H6v14h8V3z" />
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
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            @error('tanggal_pembayaran') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-4 flex justify-end space-x-2">
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
            <div id="tabel-pembayaran" class="lg:col-span-2 bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4 flex items-center space-x-3">
                    <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Riwayat Pembayaran Gaji</span>
                </h2>

                <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:space-x-4">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.500ms="search" id="searchPayment" placeholder="Cari nama, tanggal, atau jumlah..." class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse text-sm border border-theme-primary">
                        <thead class="bg-theme-primary text-white sticky top-0">
                            <tr class="border-b border-theme-primary">
                                <th class="px-4 py-2 border-r border-theme-primary">Nama Karyawan</th>
                                <th class="px-4 py-2 border-r border-theme-primary">Admin</th>
                                <th class="px-4 py-2 border-r border-theme-primary">Tanggal</th>
                                <th class="px-4 py-2 border-r border-theme-primary">Jumlah</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pembayaranTable">
                            @forelse($paymentHistory as $payment)
                                <tr class="border-b border-theme-primary hover:bg-theme-light">
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $payment->karyawan->nama ?? 'Tidak Diketahui' }} ({{ ucfirst($payment->karyawan->role ?? '') }})</td>
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $payment->admin->nama ?? 'Tidak Diketahui' }}</td>
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-theme-black">
                                        <div class="flex justify-center space-x-2">
                                            <button wire:click="editPembayaran({{ $payment->id }})" class="bg-yellow-400 hover:bg-yellow-500 text-black py-1.5 px-4 rounded flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span>Edit</span>
                                            </button>
                                            <button wire:click="confirmDelete({{ $payment->id }})" class="bg-red-400 hover:bg-red-500 text-white py-1.5 px-4 rounded flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-theme-black">Tidak ada riwayat pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div class="flex space-x-2">
                        <button wire:click="previousPage" {{ $paymentHistory->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300"><</button>
                        @foreach ($paymentHistory->getUrlRange(1, $paymentHistory->lastPage()) as $page => $url)
                            <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 {{ $paymentHistory->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-gray-200 text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white">{{ $page }}</button>
                        @endforeach
                        <button wire:click="nextPage" {{ $paymentHistory->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300">></button>
                    </div>
                    <span class="text-sm text-theme-black">
                        Menampilkan {{ $paymentHistory->firstItem() ?: 0 }} - {{ $paymentHistory->lastItem() ?: 0 }} dari {{ $paymentHistory->total() }} data
                    </span>
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

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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