<div class="p-6 overflow-y-auto">
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
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden" id="loadingOverlay" x-show="$wire.isLoading">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-theme-primary"></div>
    </div>

    <!-- Gaji Content -->
    <div class="min-h-[80vh] flex flex-col lg:flex-row lg:gap-4 py-12 justify-center items-center mx-auto lg:mr-[5%]">
        <!-- Form Pembayaran Gaji -->
        <div id="form-pembayaran" class="w-full lg:w-1/3 max-w-lg h-[600px] overflow-y-auto p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary mx-auto mb-8 lg:mb-0" style="border-color: #007022;">
            <h2 class="text-xl font-semibold text-theme-black mb-4">{{ $isModifyingPembayaran ? 'Edit Pembayaran Gaji' : 'Pembayaran Gaji' }}</h2>
            <form wire:submit.prevent="{{ $isModifyingPembayaran ? 'confirmUpdate' : 'savePembayaran' }}">
                <div class="space-y-4">
                    <div>
                        <label for="kasir" class="block text-sm font-medium text-theme-black">Pilih Karyawan</label>
                        <div class="relative">
                            <select wire:model="selectedKasirId" id="kasir" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
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
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-theme-black">Jumlah Gaji</label>
                        <div class="relative">
                            <input wire:model="jumlah" id="jumlah" type="number" placeholder="Masukkan jumlah gaji"
                                class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8.433 7.418c.106-.057.21-.118.316-.177a1 1 0 011.415 1.414c-.297.298-.654.55-1.05.73-.396.18-.854.297-1.357.297-.615 0-1.193-.194-1.633-.533a1 1 0 011.414-1.414c.108.108.24.198.378.27.138.073.294.122.477.122s.339-.05.477-.122zm4.767 5.297c-.106.057-.21-.118-.316.177a1 1 0 01-1.415-1.414c.297-.298.654-.55 1.05-.73-.396-.18.854-.297 1.357-.297c.615 0 1.193.194 1.633.533a1 1 0 01-1.414 1.414c-.108-.108-.240-.198-.378-.270-.138-.073-.294-.122-.477-.122s-.339.05-.477.122zM3 3v14a2 2 0 002 2h10a2 2 0 002-2V3a2 2 0 00-2-2H5a2 2 0 00-2 2zm11 0H6v14h8V3z" />
                                </svg>
                            </span>
                        </div>
                        @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_pembayaran" class="block text-sm font-medium text-theme-black">Tanggal Pembayaran</label>
                        <div class="relative">
                            <input wire:model="tanggal_pembayaran" id="tanggal_pembayaran" type="date"
                                class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                        @error('tanggal_pembayaran') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit"
                    class="mt-4 flex items-center gap-2 px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary transition-all">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $isModifyingPembayaran ? 'Update Pembayaran' : 'Catat Pembayaran' }}
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Pembayaran Gaji -->
        <div id="tabel-pembayaran" class="w-full lg:w-2/3 max-w-4xl min-w-0 flex flex-col h-[600px] p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary mx-auto mb-8 lg:mb-0" style="border-color: #007022;">
            <h2 class="text-xl font-semibold text-theme-black mb-4">Riwayat Pembayaran Gaji</h2>
            <div class="mb-4 flex space-x-4">
                <div class="relative flex-1">
                    <input type="text" wire:model.live.debounce.500ms="search" id="searchPayment" placeholder="Cari nama, tanggal, atau jumlah..."
                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm border border-theme-primary border-collapse table-auto">
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
                            <tr class="border-b border-theme-primary">
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $payment->karyawan->nama ?? 'Tidak Diketahui' }} ({{ ucfirst($payment->karyawan->role ?? '') }})</td>
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $payment->admin->nama ?? 'Tidak Diketahui' }}</td>
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-theme-black flex space-x-2">
                                    <button wire:click="editPembayaran({{ $payment->id }})" class="text-theme-primary hover:text-theme-secondary">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $payment->id }})" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
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
            <!-- Paginasi -->
            <div class="mt-4 flex justify-between items-center">
                <div class="flex space-x-2">
                    <button wire:click="previousPage" {{ $paymentHistory->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300">
                        <
                    </button>
                    @foreach ($paymentHistory->getUrlRange(1, $paymentHistory->lastPage()) as $page => $url)
                        <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 {{ $paymentHistory->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-gray-200 text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white">
                            {{ $page }}
                        </button>
                    @endforeach
                    <button wire:click="nextPage" {{ $paymentHistory->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300">
                        >
                    </button>
                </div>
                <span class="text-sm text-theme-black">
                    Menampilkan {{ $paymentHistory->firstItem() }} - {{ $paymentHistory->lastItem() }} dari {{ $paymentHistory->total() }} data
                </span>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Fokus awal ke input kasir
            const kasirInput = document.getElementById('kasir');
            if (kasirInput) kasirInput.focus();
        });

        // Livewire event listeners untuk SweetAlert
        window.addEventListener('swal:confirmDelete', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data pembayaran gaji akan dihapus permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deletePembayaran', { id: event.detail.id });
                }
            });
        });

        window.addEventListener('swal:confirmUpdate', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data pembayaran gaji akan diperbarui.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('proceedUpdatePembayaran');
                }
            });
        });

        window.addEventListener('swal:success', event => {
            Swal.fire({
                title: event.detail.message.includes('gagal') ? 'Gagal!' : 'Berhasil!',
                text: event.detail.message,
                icon: event.detail.message.includes('gagal') ? 'error' : 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
</div>