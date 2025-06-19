<div class="min-h-screen flex flex-col p-4 sm:p-6 overflow-hidden">

    <!-- Main Header -->
    <x-header-container 
    title="Manajemen Barang"
        icon="M3 3h18M3 7h18M3 12h18m-6 5h6"
        :active-tab="$activeTab"
        :tabs="[
            ['key' => 'barang', 'label' => 'Barang'],
            ['key' => 'hasil_bagi', 'label' => 'Hasil Bagi']
        ]"
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

    <!-- Tab Content -->
    <div class="space-y-6" x-data="{ statusTitipan: {{ $status_titipan ? 'true' : 'false' }} }">
        <!-- Barang Tab -->
        @if ($activeTab === 'barang')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Barang -->
                <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>{{ $isEditing ? 'Edit Barang' : 'Tambah Barang' }}</span>
                    </h3>
                    <form wire:submit.prevent="{{ $isEditing ? 'confirmUpdate' : 'save' }}" x-data="{ formSubmitted: false }">
                        <div class="space-y-4">
                            <div>
                                <label for="kode_barang" class="block text-sm font-medium text-theme-black">Kode Barang</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h3m6 0h3m6 0h3M3 18h6m6 0h6"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="kode_barang" id="kode_barang" type="text" placeholder="Kode barang otomatis"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-on:change="formSubmitted = false" required readonly>
                                </div>
                                <div x-show="$wire.get('errors').has('kode_barang')" x-text="$wire.get('errors').first('kode_barang')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="nama" class="block text-sm font-medium text-theme-black">Nama Barang</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="nama" id="nama" type="text" placeholder="Masukkan nama barang"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('nama')" x-text="$wire.get('errors').first('nama')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="harga_pokok" class="block text-sm font-medium text-theme-black">Harga Pokok</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2m-2 0h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm2 3h2m4 0h2"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="harga_pokok" id="harga_pokok" type="number" step="0.01" placeholder="Masukkan harga pokok"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('harga_pokok')" x-text="$wire.get('errors').first('harga_pokok')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="harga_jual" class="block text-sm font-medium text-theme-black">Harga Jual</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2m-2 0h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm2 3h2m4 0h2"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="harga_jual" id="harga_jual" type="number" step="0.01" placeholder="Masukkan harga jual"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.get('errors').has('harga_jual')" x-text="$wire.get('errors').first('harga_jual')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="stok" class="block text-sm font-medium text-theme-black">Stok</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="stok" id="stok" type="number" min="0" placeholder="Masukkan stok"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 {{ $isEditing ? 'bg-gray-200 cursor-not-allowed' : '' }} text-sm"
                                        x-on:change="formSubmitted = false" required {{ $isEditing ? 'readonly' : '' }}>
                                </div>
                                <div x-show="$wire.get('errors').has('stok')" x-text="$wire.get('errors').first('stok')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-theme-black">Status Titipan</label>
                                <div class="mt-1 space-x-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="status_titipan" value="1" class="form-radio text-theme-primary focus:ring-theme-secondary"
                                            x-on:change="$wire.set('status_titipan', true); statusTitipan = true; formSubmitted = false; $wire.set('tipe_barang', 'titipan')">
                                        <span class="ml-2 text-sm text-theme-black">Ya</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="status_titipan" value="0" class="form-radio text-theme-primary focus:ring-theme-secondary"
                                            x-on:change="$wire.set('status_titipan', false); statusTitipan = false; formSubmitted = false; $wire.set('hasil_bagi_id', null)">
                                        <span class="ml-2 text-sm text-theme-black">Tidak</span>
                                    </label>
                                </div>
                                <div x-show="$wire.get('errors').has('status_titipan')" x-text="$wire.get('errors').first('status_titipan')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div x-show="statusTitipan">
                                <label for="hasil_bagi_id" class="block text-sm font-medium text-theme-black">Tipe Hasil Bagi</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8-8v16"></path>
                                        </svg>
                                    </div>
                                    <select wire:model="hasil_bagi_id" id="hasil_bagi_id" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                                        <option value="">Pilih Tipe Hasil Bagi</option>
                                        @foreach($hasilBagis as $hasilBagi)
                                            <option value="{{ $hasilBagi->id }}">{{ $hasilBagi->tipe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div x-show="$wire.get('errors').has('hasil_bagi_id')" x-text="$wire.get('errors').first('hasil_bagi_id')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            <div>
                                <label for="tipe_barang" class="block text-sm font-medium text-theme-black">Tipe Barang</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>
                                    <select wire:model="tipe_barang" id="tipe_barang" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm"
                                        x-bind:disabled="statusTitipan" x-bind:class="{ 'bg-gray-200 cursor-not-allowed': statusTitipan }">
                                        <option value="snack">Snack</option>
                                        <option value="minuman">Minuman</option>
                                        <option value="kebutuhan">Kebutuhan</option>
                                        <option value="lainnya">Lainnya</option>
                                        <option value="titipan" x-show="statusTitipan">Titipan</option>
                                    </select>
                                </div>
                                <div x-show="$wire.get('errors').has('tipe_barang')" x-text="$wire.get('errors').first('tipe_barang')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">Reset</button>
                            <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isEditing ? 'Update Barang' : 'Tambah Barang' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Barang -->
                <div class="lg:col-span-2 bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span>Daftar Barang</span>
                    </h3>
                    <div class="mb-4 flex space-x-4">
                        <div class="flex-1">
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari kode atau nama barang..."
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                            </div>
                        </div>

                        <div>
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </div>
                                <select wire:model.live="filter_tipe_barang" id="filter_tipe_barang" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                                    <option value="">Semua</option>
                                    <option value="snack">Snack</option>
                                    <option value="minuman">Minuman</option>
                                    <option value="kebutuhan">Kebutuhan</option>
                                    <option value="lainnya">Lainnya</option>
                                    <option value="titipan">Titipan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Barang -->
                    <x-table-container 
                        :headers="[
                            ['key' => 'kode_barang', 'label' => 'Kode Barang'],
                            ['key' => 'nama', 'label' => 'Nama'],
                            ['key' => 'harga_pokok', 'label' => 'Harga Pokok', 'format' => 'currency'],
                            ['key' => 'harga_jual', 'label' => 'Harga Jual', 'format' => 'currency'],
                            ['key' => 'stok', 'label' => 'Stok', 'align' => 'center'],
                            ['key' => 'tipe_barang', 'label' => 'Tipe Barang', 'format' => 'ucfirst', 'align' => 'center'],
                            ['key' => 'status_titipan', 'label' => 'Status Titipan', 'format' => 'boolean', 'align' => 'center'],
                            ['key' => 'hasil_bagi', 'label' => 'Tipe Hasil Bagi', 'format' => 'relation', 'align' => 'center'],
                            ['key' => 'is_active', 'label' => 'Status', 'format' => 'status', 'align' => 'center'],
                        ]"
                        :data="$barangs"
                        :actions="[
                            ['label' => 'Edit', 'wire:click' => 'editBarang', 'class' => 'bg-yellow-400 hover:bg-yellow-500 text-black', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                            ['label' => 'is_active ? \'Nonaktifkan\' : \'Aktifkan\'', 'wire:click' => 'confirmToggleActive', 'class' => 'is_active ? \'bg-red-400 hover:bg-red-500 text-white\' : \'bg-green-400 hover:bg-green-500 text-white\'', 'icon' => 'is_active ? \'M6 18L18 6M6 6l12 12\' : \'M5 13l4 4L19 7\''],
                        ]"
                        per-page="25"
                        table-id="barangTable"
                    />
                    
                    <div class="mt-4 text-right">
                        <button wire:click="printAllTitipanBarcodes" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            <span>Cetak Barcode {{ $filter_tipe_barang ? ucfirst($filter_tipe_barang) : 'Semua' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Hasil Bagi Tab -->
        @if ($activeTab === 'hasil_bagi')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Hasil Bagi -->
                <div class="bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>{{ $isEditingHasilBagi ? 'Edit Hasil Bagi' : 'Tambah Hasil Bagi' }}</span>
                    </h3>
                    <form wire:submit.prevent="{{ $isEditingHasilBagi ? 'confirmUpdateHasilBagi' : 'saveHasilBagi' }}">
                        <div class="space-y-4">
                            <div>
                                <label for="tipe_hasil_bagi" class="block text-sm font-medium text-theme-black">Tipe Hasil Bagi</label>
                                <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8-8v16"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="tipe_hasil_bagi" id="tipe_hasil_bagi" type="number" step="100" min="100" placeholder="Masukkan tipe hasil bagi (contoh: 500)"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring focus:ring-theme-primary focus:ring-opacity-50 text-sm">
                                </div>
                                <div x-show="$wire.get('errors').has('tipe_hasil_bagi')" x-text="$wire.get('errors').first('tipe_hasil_bagi')" class="text-red-500 text-sm mt-1"></div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">Reset</button>
                            <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isEditingHasilBagi ? 'Update Hasil Bagi' : 'Tambah Hasil Bagi' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Hasil Bagi -->
                <div class="lg:col-span-2 bg-theme-surface p-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <h3 class="text-xl font-medium text-theme-black mb-4 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span>Daftar Hasil Bagi</span>
                    </h3>

                    <!-- Komponen Tabel Hasil Bagi -->
                    <x-table-container 
                        :headers="[
                            ['key' => 'tipe', 'label' => 'Tipe Hasil Bagi'],
                            ['key' => 'barangs_count', 'label' => 'Jumlah Barang', 'format' => 'count', 'align' => 'center'],
                        ]"
                        :data="$hasilBagis"
                        :actions="[
                            ['label' => 'Edit', 'wire:click' => 'editHasilBagi', 'class' => 'bg-yellow-400 hover:bg-yellow-500 text-black', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                        ]"
                        table-id="hasilBagiTable"
                    />

                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kodeBarangInput = document.getElementById('kode_barang');
            const namaInput = document.getElementById('nama');

            // Fokus awal pada nama
            if (namaInput) {
                namaInput.focus();
            }

            // Tangani tombol Enter setelah input nama
            namaInput?.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (namaInput.value.trim() !== '') {
                        document.getElementById('harga_pokok')?.focus();
                    }
                }
            });
        });

        document.addEventListener('livewire:load', function () {
            Livewire.on('resetForm', () => {
                const namaInput = document.getElementById('nama');
                if (namaInput) {
                    namaInput.focus();
                }
            });
        });

        // SweetAlert2 event listeners untuk Barang
        window.addEventListener('swal:confirmUpdateBarang', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data barang akan diperbarui.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('proceedUpdateBarang');
                }
            });
        });

        window.addEventListener('swal:confirmToggleActive', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Barang akan ${event.detail.is_active ? 'dinonaktifkan' : 'diaktifkan'}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: `Ya, ${event.detail.is_active ? 'nonaktifkan' : 'aktifkan'}!`,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('toggleActiveBarang', [event.detail.id]);
                }
            });
        });

        // SweetAlert2 event listeners untuk Hasil Bagi
        window.addEventListener('swal:confirmUpdateHasilBagi', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data hasil bagi akan diperbarui.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007022',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('proceedUpdateHasilBagi');
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