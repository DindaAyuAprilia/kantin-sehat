<div>
    <div class="p-6">
        <!-- Main Header -->
        <x-header-container 
            title="Transaksi Kasir" 
            icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
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

        <section class="min-h-[calc(100vh-4rem)] flex flex-col lg:flex-row gap-8 justify-center transition-all duration-500" data-page="transaksi-kasir">
            <!-- Area Transaksi -->
            <div class="w-full lg:w-1/2 max-w-2xl p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4">Transaksi Kasir</h2>

                <!-- Area Scan Barcode -->
                <div class="mb-6">
                    <label for="search" class="block text-sm font-medium text-theme-black">Scan Barcode atau Cari Barang</label>
                    <div class="relative">
                        <input wire:model.live="search" wire:keydown.enter="addItem" id="search" type="text" placeholder="Scan barcode atau ketik nama barang"
                               class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2"
                               x-ref="search_input" x-on:keydown.escape="$wire.searchResults = []" autocomplete="off">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <!-- Dropdown Hasil Pencarian -->
                    <div x-show="$wire.search && ($wire.searchResults || []).length !== undefined" class="absolute z-10 mt-1 bg-white border border-theme-black rounded-md shadow-lg max-h-60 overflow-auto"
                         x-bind:style="($wire.searchResults || []).length > 0 ? 'width: ' + ($wire.maxContentWidth || 200) + 'px' : 'width: auto; min-width: 200px;'">
                        <ul>
                            @if(empty($searchResults) && !empty($search))
                                <li class="px-4 py-2 text-theme-black">Tidak Ada Barang Ditemukan</li>
                            @else
                                @foreach($searchResults as $result)
                                    <li wire:click="selectBarang({{ $result->id }})"
                                        class="px-4 py-2 hover:bg-theme-primary hover:text-theme-white cursor-pointer">
                                        {{ $result->kode_barang }} - {{ $result->nama }}
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Error Message -->
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Daftar Keranjang -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2 text-theme-black">Keranjang</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm border-collapse border-2 border-theme-primary">
                            <thead class="bg-theme-primary text-theme-white">
                                <tr class="border-b-2 border-theme-primary">
                                    <th class="px-4 py-2 border-r-2 border-theme-primary">Barcode</th>
                                    <th class="px-4 py-2 border-r-2 border-theme-primary">Nama Produk</th>
                                    <th class="px-4 py-2 border-r-2 border-theme-primary">Harga Satuan</th>
                                    <th class="px-4 py-2 border-r-2 border-theme-primary">Jumlah</th>
                                    <th class="px-4 py-2 border-r-2 border-theme-primary">Subtotal</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cart as $index => $item)
                                    <tr class="border-b border-theme-primary">
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $item['barcode'] }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $item['name'] }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">
                                            <div class="flex items-center space-x-2">
                                                <button wire:click="decrementQuantity({{ $index }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                                <input wire:model.live="cart.{{ $index }}.quantity" type="number" min="1"
                                                       class="w-16 text-center border rounded py-1"
                                                       wire:change="updateQuantity({{ $index }}, $event.target.value)">
                                                <button wire:click="incrementQuantity({{ $index }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-theme-black">
                                            <button wire:click="removeFromCart({{ $index }})" class="text-red-600 hover:text-red-800">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-theme-black text-center">Keranjang kosong.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-theme-primary">
                                    <td colspan="4" class="px-4 py-2 text-theme-black font-semibold">Total Harga</td>
                                    <td class="px-4 py-2 text-theme-black">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if(!empty($cart))
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-theme-black mb-2">Metode Pembayaran</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model="paymentMethod" value="tunai" class="form-radio text-theme-primary focus:ring-theme-secondary">
                                    <span class="ml-2 text-theme-black">Tunai</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model="paymentMethod" value="transfer" class="form-radio text-theme-primary focus:ring-theme-secondary">
                                    <span class="ml-2 text-theme-black">Transfer</span>
                                </label>
                            </div>
                            <button wire:click="checkout" class="mt-4 px-4 py-2 bg-theme-primary text-theme-white rounded-md hover:bg-theme-secondary focus:outline-none focus:ring-2 focus:ring-theme-secondary">
                                Checkout
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Transaksi -->
            <div class="w-full lg:w-1/2 max-w-2xl p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4">Riwayat Transaksi</h2>
                <div class="flex justify-between items-center mb-4">
                    <button wire:click="previousDay" class="px-4 py-2 bg-theme-primary text-theme-white rounded-md hover:bg-theme-secondary">
                        ← Sebelumnya
                    </button>
                    <input type="date" wire:model.live="selectedDate" class="form-input rounded-md shadow-sm" />
                    <button wire:click="nextDay" class="px-4 py-2 bg-theme-primary text-theme-white rounded-md hover:bg-theme-secondary">
                        Berikutnya →
                    </button>
                </div>
                <div class="overflow-y-auto max-h-[calc(100vh-20rem)]">
                    <table class="min-w-full text-sm border-collapse border-2 border-theme-primary">
                        <thead class="bg-theme-primary text-theme-white sticky top-0">
                            <tr class="border-b-2 border-theme-primary">
                                <th class="px-4 py-2 border-r-2 border-theme-primary">Unix ID</th>
                                <th class="px-4 py-2 border-r-2 border-theme-primary">Jam</th>
                                <th class="px-4 py-2 border-r-2 border-theme-primary">Total Harga</th>
                                <th class="px-4 py-2 border-r-2 border-theme-primary">Metode</th>
                                <th class="px-4 py-2 border-r-2 border-theme-primary">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="border-b border-theme-primary">
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ $transaction->unix_id }}</td>
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ \Carbon\Carbon::parse($transaction->created_at)->translatedFormat('H:i:s') }}</td>
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">{{ ucfirst($transaction->metode_pembayaran) }}</td>
                                    <td class="px-4 py-2 text-theme-black border-r border-theme-primary">
                                        <ul class="list-disc pl-4">
                                            @foreach($transaction->details as $detail)
                                                <li>{{ $detail->barang->nama }} ({{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-theme-black text-center border-r border-theme-primary">Tidak ada transaksi pada tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Integrasi JavaScript untuk Transaksi Kasir -->
    <script>
        document.addEventListener('livewire:init', function () {
            // Hanya jalankan logika fokus untuk halaman transaksi kasir
            if (document.querySelector('[data-page="transaksi-kasir"]')) {
                const focusSearchInput = () => {
                    const searchInput = document.getElementById('search');
                    if (searchInput) {
                        setTimeout(() => searchInput.focus(), 100);
                    }
                };

                // Fokus awal pada input
                focusSearchInput();

                // Event listener untuk fokus input
                Livewire.on('item-added', focusSearchInput);
                Livewire.on('item-removed', focusSearchInput);
                Livewire.on('item-updated', focusSearchInput);
                Livewire.on('focus-input', focusSearchInput);

                // Event listener untuk alert
                Livewire.on('show-alert', (event) => {
                    console.log('Show Alert:', event);
                    Swal.fire({
                        title: 'Peringatan!',
                        text: event.message || 'Terjadi kesalahan.',
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    }).then(() => focusSearchInput());
                });

                // Event listener untuk input uang diberikan
                Livewire.on('swal:inputUangDiberikan', (event) => {
                    console.log('Input Uang Diberikan:', event);
                    Swal.fire({
                        title: 'Masukkan Jumlah Uang yang Diberikan',
                        html: `Total Harga: Rp ${new Intl.NumberFormat('id-ID').format(event.totalHarga)}`,
                        input: 'number',
                        inputAttributes: {
                            min: 0,
                            step: 1
                        },
                        inputPlaceholder: 'Masukkan jumlah uang',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Lanjutkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed && result.value !== undefined) {
                            console.log('Uang Diberikan:', result.value);
                            Livewire.dispatch('handleUangDiberikan', { jumlah: result.value });
                        } else {
                            console.log('Input Uang Diberikan Dibatalkan');
                        }
                    });
                });

                // Event listener untuk input opsi kembalian
                Livewire.on('swal:inputKembalianOpsi', (event) => {
                    console.log('Input Kembalian Opsi:', event);
                    Swal.fire({
                        title: 'Apakah pelanggan mengambil kembalian?',
                        html: `Total Kembalian: Rp ${new Intl.NumberFormat('id-ID').format(event.kembalian)}<br>` +
                              '<div class="swal-custom-buttons">' +
                              '<button id="swal-sebagian-btn" class="swal2-confirm swal2-styled" style="background-color: #007bff; color: white; margin-right: 5px;">Sebagian</button>' +
                              '</div>',
                        showDenyButton: true,
                        showCancelButton: true,
                        showConfirmButton: true,
                        confirmButtonText: 'Iya',
                        denyButtonText: 'Tidak',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#28a745',
                        denyButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        didOpen: () => {
                            const sebagianBtn = document.getElementById('swal-sebagian-btn');
                            if (sebagianBtn) {
                                sebagianBtn.addEventListener('click', () => {
                                    Swal.close();
                                    Swal.fire({
                                        title: 'Masukkan Jumlah Kembalian Sebagian',
                                        html: `Total Kembalian: Rp ${new Intl.NumberFormat('id-ID').format(event.kembalian)}`,
                                        input: 'number',
                                        inputAttributes: {
                                            min: 0,
                                            max: event.kembalian,
                                            step: 500,
                                            placeholder: 'Masukkan jumlah kembalian'
                                        },
                                        inputValidator: (value) => {
                                            if (!value || value < 0) {
                                                return 'Nominal tidak boleh minus atau kosong!';
                                            }
                                            if (value > event.kembalian) {
                                                return 'Nominal melebihi total kembalian!';
                                            }
                                            return null;
                                        },
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Lanjutkan',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed && result.value !== undefined) {
                                            console.log('Kembalian Sebagian:', result.value);
                                            Livewire.dispatch('handleKembalianDiambil', { jumlah: result.value, opsi: 'sebagian' });
                                        } else {
                                            console.log('Input Kembalian Sebagian Dibatalkan');
                                        }
                                    });
                                });
                            }
                        },
                        preConfirm: () => {
                            return new Promise((resolve) => {
                                resolve();
                            });
                        },
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('Kembalian Diambil:', event.kembalian);
                            Livewire.dispatch('handleKembalianDiambil', { jumlah: event.kembalian, opsi: 'iya' });
                        } else if (result.isDenied) {
                            console.log('Kembalian Tidak Diambil');
                            Livewire.dispatch('handleKembalianDiambil', { jumlah: 0, opsi: 'tidak' });
                        } else {
                            console.log('Input Kembalian Opsi Dibatalkan');
                        }
                    });
                });

                // Event listener untuk konfirmasi checkout
                Livewire.on('swal:confirmCheckout', () => {
                    console.log('Confirm Checkout Triggered');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Transaksi akan disimpan.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, simpan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('Proceed Checkout Dispatched');
                            Livewire.dispatch('proceedCheckout');
                        } else {
                            console.log('Checkout Dibatalkan');
                        }
                    });
                });

                // Event listener untuk notifikasi sukses
                Livewire.on('swal:success', (event) => {
                    console.log('Success Notification:', event);
                    Swal.fire({
                        title: 'Berhasil!',
                        text: event.message,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => focusSearchInput());
                });

                // Tutup dropdown saat klik di luar
                document.addEventListener('click', (e) => {
                    const searchInput = document.getElementById('search');
                    const dropdown = document.querySelector('.absolute.z-10');
                    if (searchInput && dropdown && !searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                        console.log('Clearing Search Results');
                        window.Livewire.dispatch('clear-search-results');
                    }
                });
            }
        });
    </script>
</div>