<div class="min-h-screen flex flex-col p-4 sm:p-6 overflow-hidden">

    <!-- Main Header -->
    <x-header 
    title="Manajemen Barang"
        icon="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z"
        :active-tab="$activeTab"
        :tabs="[
            ['key' => 'barang', 'label' => 'Barang'],
            ['key' => 'hasil_bagi', 'label' => 'Hasil Bagi']
        ]"
    />

    <!-- Alert Sukses-->
    <x-alert 
        type="success" 
        :message="session('success')"
    />

    <!-- Alert Error-->
    <x-alert 
        type="error" 
        :message="session('error')"
    />

    <!-- Tab Content -->
    <div class="space-y-6" x-data="{ statusTitipan: {{ $status_titipan ? 'true' : 'false' }}, packAmount: '', itemsPerPack: '', totalPurchasePrice: '', formSubmitted: false }">

        <!-- Barang Tab -->
        @if ($activeTab === 'barang')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Card Form Barang -->
                <div class="max-h-[calc(100vh-0.5vh)] overflow-y-auto bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="{{ $isEditing ? 'Edit Barang' : 'Tambah Barang' }}" 
                        icon="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" 
                    />
                    <form wire:submit.prevent="{{ $isEditing ? 'confirmUpdate' : 'save' }}">
                        <div class="space-y-4 px-6">

                            <!-- Input Kode Barang -->
                            <div>
                                <label for="kode_barang" class="block text-sm font-medium text-theme-black">Kode Barang</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="kode_barang" id="kode_barang" type="text" placeholder="Kode barang otomatis"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10"
                                        x-on:change="formSubmitted = false" required readonly>
                                </div>
                                <div x-show="$wire.errors.kode_barang" x-text="$wire.errors.kode_barang" class="text-red-500 text-sm mt-1"></div>
                            </div>
                            
                            <!-- Input Nama Barang -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-theme-black">Nama Barang</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="nama" id="nama" type="text" placeholder="Masukkan nama barang"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.errors.nama" x-text="$wire.errors.nama" class="text-red-500 text-sm mt-1"></div>
                            </div>

                            <!-- Input Pilihan Input Satuan -->
                            <div>
                                <label class="block text-sm font-medium text-theme-black">Input Satuan Manual</label>
                                <div class="mt-1 space-x-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="use_unit_calculator" value="1" id="use_unit_calculator_yes" 
                                            class="form-radio text-theme-primary border border-theme-primary focus:ring-theme-secondary {{ $isEditing || $status_titipan ? 'bg-gray-200 cursor-not-allowed' : '' }}"
                                            x-on:change="document.getElementById('status_titipan_1').checked ? null : ($wire.set('use_unit_calculator', 1), $wire.set('status_titipan', 0)); $wire.set('stok', ''); $wire.set('harga_pokok', ''); packAmount = ''; itemsPerPack = ''; totalPurchasePrice = '';"
                                            {{ $isEditing || $status_titipan ? 'disabled' : '' }}>
                                        <span class="ml-2 text-sm text-theme-black">Ya</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="use_unit_calculator" value="0" id="use_unit_calculator_no" 
                                            class="form-radio text-theme-primary focus:ring-theme-secondary {{ $isEditing || $status_titipan ? 'bg-gray-200 cursor-not-allowed' : '' }}"
                                            x-on:change="document.getElementById('status_titipan_1').checked ? null : ($wire.set('use_unit_calculator', 0), $wire.set('status_titipan', 0));"
                                            {{ $isEditing || $status_titipan ? 'disabled' : '' }}>
                                        <span class="ml-2 text-sm text-theme-black">Tidak</span>
                                    </label>
                                </div>
                                <div x-show="$wire.errors.use_unit_calculator" x-text="$wire.errors.use_unit_calculator" class="text-red-500 text-sm mt-1"></div>
                            </div>

                            <!-- Kalkulator Harga Pokok Satuan -->
                            <div x-show="!$wire.use_unit_calculator">
                                <div class="space-y-4">
                                    <!-- Jumlah Pack/Box -->
                                    <div>
                                        <label for="pack_amount" class="block text-sm font-medium text-theme-black">Jumlah Pack/Dus</label>
                                        <div class="relative rounded-md shadow-sm border border-gray-300">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3"></path>
                                                </svg>
                                            </div>
                                            <input 
                                                x-model="packAmount" 
                                                wire:model.debounce.500ms="pack_amount"
                                                id="pack_amount" 
                                                type="number" 
                                                min="0" 
                                                step="1" 
                                                placeholder="Masukkan jumlah pack/dus" 
                                                class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-sm"
                                                @input="calculateUnitPrice"
                                            >
                                        </div>
                                    </div>
                                    <!-- Satuan per Pack -->
                                    <div>
                                        <label for="items_per_pack" class="block text-sm font-medium text-theme-black">Satuan per Pack</label>
                                        <div class="relative rounded-md shadow-sm border border-gray-300">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"></path>
                                                </svg>
                                            </div>
                                            <input 
                                                x-model="itemsPerPack" 
                                                wire:model.debounce.500ms="items_per_pack"
                                                id="items_per_pack" 
                                                type="number" 
                                                min="0" 
                                                step="1" 
                                                placeholder="Masukkan jumlah item per pack" 
                                                class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-sm"
                                                @input="calculateUnitPrice"
                                            >
                                        </div>
                                    </div>
                                    <!-- Total Harga Pembelian -->
                                    <div x-data="{ totalPurchasePrice: '' }">
                                        <label for="total_purchase_price" class="block text-sm font-medium text-theme-black">Total Harga Pembelian (Rp)</label>
                                        <div class="relative rounded-md shadow-sm border border-gray-300">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"></path>
                                                </svg>
                                            </div>
                                            <input 
                                                x-model="totalPurchasePrice" 
                                                wire:model.debounce.500ms="total_purchase_price"
                                                id="total_purchase_price" 
                                                type="number" 
                                                min="0" 
                                                step="0.01" 
                                                placeholder="Masukkan total harga pembelian" 
                                                class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-sm"
                                                @input="calculateUnitPrice"
                                            >
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600" x-text="totalPurchasePrice ? 'Rp ' + parseFloat(totalPurchasePrice).toLocaleString('id-ID') : 'Rp 0'"></p>
                                    </div>

                                    <!-- Checkbox Discount -->
                                    <div>
                                        <label for="use_discount" class="block text-sm font-medium text-theme-black">Gunakan Potongan</label>
                                        <input 
                                            type="checkbox" 
                                            wire:model="use_discount" 
                                            id="use_discount" 
                                            class="bg-theme-primary text-theme-primary form-checkbox mt-1" 
                                            x-bind:disabled="!$wire.total_harga || $wire.total_harga <= 0"
                                            x-bind:class="{ 'cursor-not-allowed opacity-50': !$wire.total_harga || $wire.total_harga <= 0 }"
                                        >
                                    </div>

                                    <!-- Discount Amount Input -->
                                    <div x-show="$wire.use_discount" class="flex items-end gap-2">
                                        <div class="flex-1">
                                            <label for="discount_amount" class="block text-sm font-medium text-theme-black">Jumlah Potongan (Rp)</label>
                                            <div class="relative">
                                                <input 
                                                    type="number" 
                                                    wire:model.debounce.500ms="discount_amount" 
                                                    id="discount_amount" 
                                                    min="0" 
                                                    step="0.01" 
                                                    placeholder="Masukkan jumlah potongan" 
                                                    class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base"
                                                    @blur="calculateUnitPrice"
                                                >
                                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.99 14.993 6.99 12.993m6-6 6 6m-12 0 6 6m-9-9h.01M15 9h.01M9 15h.01M5.25 5.25h13.5a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 16.5v-9A2.25 2.25 0 0 1 5.25 5.25Z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            @error('discount_amount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Harga Pokok Barang -->
                            <div>
                                <label for="harga_pokok" class="block text-sm font-medium text-theme-black">Harga Pokok</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        wire:model.debounce.500ms="harga_pokok" 
                                        id="harga_pokok" 
                                        type="number" 
                                        step="0.01" 
                                        placeholder="Masukkan harga pokok"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-sm"
                                        x-bind:disabled="!$wire.use_unit_calculator"
                                        x-bind:class="{ 'bg-gray-200 cursor-not-allowed': !$wire.use_unit_calculator }"
                                        x-on:change="formSubmitted = false" 
                                        required
                                    >
                                </div>
                                <div x-show="$wire.errors.harga_pokok" x-text="$wire.errors.harga_pokok" class="text-red-500 text-sm mt-1"></div>
                            </div>

                            <!-- Input Harga Jual Barang -->
                            <div>
                                <label for="harga_jual" class="block text-sm font-medium text-theme-black">Harga Jual</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="harga_jual" id="harga_jual" type="number" step="0.01" placeholder="Masukkan harga jual"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10"
                                        x-on:change="formSubmitted = false" required>
                                </div>
                                <div x-show="$wire.errors.harga_jual" x-text="$wire.errors.harga_jual" class="text-red-500 text-sm mt-1"></div>
                            </div>

                            <!-- Input Stok Barang -->
                            <div>
                                <label for="stok" class="block text-sm font-medium text-theme-black">Stok</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        wire:model.debounce.500ms="stok" 
                                        id="stok" 
                                        type="number" 
                                        min="0" 
                                        placeholder="Masukkan stok"
                                        class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-sm {{ $isEditing ? 'bg-gray-200 cursor-not-allowed' : '' }}"
                                        x-bind:disabled="!$wire.use_unit_calculator || {{ $isEditing ? 'true' : 'false' }}"
                                        x-bind:class="{ 'bg-gray-200 cursor-not-allowed': !$wire.use_unit_calculator || {{ $isEditing ? 'true' : 'false' }} }"
                                        x-on:change="formSubmitted = false" 
                                        required 
                                        {{ $isEditing ? 'disabled' : '' }}
                                    >
                                </div>
                                <div x-show="$wire.errors.stok" x-text="$wire.errors.stok" class="text-red-500 text-sm mt-1"></div>
                            </div>

                            <!-- Input status titipan -->
                            <div>
                                <label class="block text-sm font-medium text-theme-black">Status Titipan</label>
                                <div class="mt-1 space-x-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="status_titipan" value="1" id="status_titipan_1"
                                            class="form-radio text-theme-primary border border-theme-primary focus:ring-theme-secondary {{ $isEditing || !$use_unit_calculator ? 'bg-gray-200 cursor-not-allowed' : '' }}"
                                            x-on:change="document.getElementById('use_unit_calculator_no').checked ? null : ($wire.set('use_unit_calculator', 1), $wire.set('tipe_barang', 'titipan'), formSubmitted = false);"
                                            {{ $isEditing || !$use_unit_calculator ? 'disabled' : '' }}>
                                        <span class="ml-2 text-sm text-theme-black">Ya</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="status_titipan" value="0" id="status_titipan_0"
                                            class="form-radio text-theme-primary focus:ring-theme-secondary {{ $isEditing ? 'bg-gray-200 cursor-not-allowed' : '' }}"
                                            x-on:change="$wire.set('tipe_barang', 'lainnya'); formSubmitted = false;"
                                            {{ $isEditing ? 'disabled' : '' }}>
                                        <span class="ml-2 text-sm text-theme-black">Tidak</span>
                                    </label>
                                </div>
                                <div x-show="$wire.errors.status_titipan" x-text="$wire.errors.status_titipan" class="text-red-500 text-sm mt-1"></div>
                            </div>

                            <!-- Input Tipe Hasil Bagi -->
                            <div x-show="statusTitipan">
                                <label for="hasil_bagi_id" class="block text-sm font-medium text-theme-black">Tipe Hasil Bagi</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"></path>
                                        </svg>
                                    </div>
                                    <select wire:model="hasil_bagi_id" id="hasil_bagi_id" class="focus:ring-opacity-30 border-theme-primary pl-10 block w-full rounded-md shadow-sm focus:border-theme-primary focus:ring-theme-primary text-sm">
                                        <option value="">Pilih Tipe Hasil Bagi</option>
                                        @foreach($hasilBagis as $hasilBagi)
                                            <option value="{{ $hasilBagi->id }}">{{ $hasilBagi->tipe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div x-show="$wire.errors.hasil_bagi_id" x-text="$wire.errors.hasil_bagi_id" class="text-red-500 text-sm mt-1"></div>
                            </div>

                            <!-- Input Tipe Barang -->
                            <div>
                                <label for="tipe_barang" class="block text-sm font-medium text-theme-black">Tipe Barang</label>
                                <div class="relative rounded-md shadow-sm border border-gray-300">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>
                                    <select wire:model="tipe_barang" id="tipe_barang" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring-theme-primary focus:ring-opacity-30 border-theme-primary text-sm"
                                        x-bind:disabled="statusTitipan" x-bind:class="{ 'bg-gray-200 cursor-not-allowed': statusTitipan }">
                                        <option value="snack" x-show="!statusTitipan">Snack</option>
                                        <option value="minuman" x-show="!statusTitipan">Minuman</option>
                                        <option value="kebutuhan" x-show="!statusTitipan">Kebutuhan</option>
                                        <option value="lainnya" x-show="!statusTitipan">Lainnya</option>
                                        <option value="titipan" x-show="statusTitipan" selected>Titipan</option>
                                    </select>
                                </div>
                                <div x-show="$wire.errors.tipe_barang" x-text="$wire.errors.tipe_barang" class="text-red-500 text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end space-x-2 px-6">
                            <button type="button" 
                                    wire:click="resetForm" 
                                    @click="$refs.barangForm.reset(); formSubmitted = false; statusTitipan = false; $wire.set('status_titipan', false); $wire.set('hasil_bagi_id', null); $wire.set('tipe_barang', 'lainnya'); $wire.set('stok', 0);"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">
                                Reset
                            </button>
                            <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isEditing ? 'Update Barang' : 'Tambah Barang' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Card Tabel Barang -->
                <div class="lg:col-span-2 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="Daftar Barang" 
                        icon="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" 
                    />
                    
                    <!-- Search -->
                    <div class="mb-4 flex space-x-4 px-6">
                        <div class="flex-1">
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari kode atau nama barang..."
                                    class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                            </div>
                        </div>

                        <!-- Dropdown filter -->
                        <div>
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </div>
                                <select wire:model.live="filter_tipe_barang" id="filter_tipe_barang" class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
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
                    <div class="px-6">
                        <x-table 
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
                    </div>
                    
                    <!-- Cetak Barcode -->
                    <div class="mt-4 text-right px-6">
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
                
                <!-- Card Form Hasil Bagi -->
                <div class="max-h-[calc(100vh-0.5vh)] overflow-y-auto bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="{{ $isEditingHasilBagi ? 'Edit Hasil Bagi' : 'Tambah Hasil Bagi' }}" 
                        icon="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z"
                    />
                    <form wire:submit.prevent="{{ $isEditingHasilBagi ? 'confirmUpdateHasilBagi' : 'saveHasilBagi' }}" x-ref="hasilBagiForm">
                        <div class="space-y-4 px-6">
                            <label for="tipe_hasil_bagi" class="block text-sm font-medium text-theme-black">Tipe Hasil Bagi</label>
                            <div class="relative rounded-md shadow-sm border border-gray-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"></path>
                                    </svg>
                                </div>
                                <input wire:model.debounce.500ms="tipe_hasil_bagi" id="tipe_hasil_bagi" type="number" step="100" min="100" placeholder="Masukkan tipe hasil bagi (contoh: 500)"
                                    class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10">
                            </div>
                            <div x-show="$wire.errors.tipe_hasil_bagi" x-text="$wire.errors.tipe_hasil_bagi" class="text-red-500 text-sm mt-1"></div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2 px-6">
                            <button type="button" 
                                    wire:click="resetForm" 
                                    @click="$refs.hasilBagiForm.reset()"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">
                                Reset
                            </button>
                            <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isEditingHasilBagi ? 'Update Hasil Bagi' : 'Tambah Hasil Bagi' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Card Tabel Hasil Bagi -->
                <div class="lg:col-span-2 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary">
                    <x-card-header 
                        title="Daftar Hasil Bagi" 
                        icon="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" 
                    />
                    
                    <!-- Komponen Tabel Hasil Bagi -->
                    <div class="px-6">
                        <x-table 
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

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[wire\\:submit\\.prevent]');
            form.addEventListener('submit', function (event) {
                const hargaPokok = parseFloat(document.getElementById('harga_pokok').value) || 0;
                const hargaJual = parseFloat(document.getElementById('harga_jual').value) || 0;

                if (hargaJual < hargaPokok) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Harga jual tidak boleh kurang dari harga pokok!',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Fungsi kalkulator harga pokok satuan
        let originalTotalPrice = 0;

        function updateOriginalTotalPrice() {
            originalTotalPrice = parseFloat(document.getElementById('total_purchase_price').value) || 0;
        }

        function calculateUnitPrice() {
            const packAmount = parseFloat(document.getElementById('pack_amount').value) || 0;
            const itemsPerPack = parseFloat(document.getElementById('items_per_pack').value) || 0;
            const useDiscount = document.getElementById('use_discount').checked;
            const discountAmount = useDiscount ? parseFloat(document.getElementById('discount_amount').value) || 0 : 0;

            // Hitung stok satuan
            const unitStock = packAmount * itemsPerPack;
            const adjustedTotalPrice = Math.max(0, originalTotalPrice - discountAmount);
            const unitBasePrice = unitStock > 0 ? (adjustedTotalPrice / unitStock).toFixed(2) : '';

            // Update stok
            document.getElementById('stok').value = unitStock > 0 ? Math.floor(unitStock) : '';
            // Update harga pokok
            document.getElementById('harga_pokok').value = unitBasePrice > 0 ? unitBasePrice : '';
            // Update total_purchase_price
            document.getElementById('total_purchase_price').value = adjustedTotalPrice;

            // Dispatch to Livewire
            window.Livewire.dispatch('set', { 
                stok: unitStock > 0 ? Math.floor(unitStock) : '', 
                harga_pokok: unitBasePrice > 0 ? unitBasePrice : '',
                total_purchase_price: adjustedTotalPrice
            });
        }

        function resetDiscount() {
            if (!document.getElementById('use_discount').checked) {
                document.getElementById('discount_amount').value = 0;
                document.getElementById('total_purchase_price').value = originalTotalPrice;
                calculateUnitPrice();
            }
        }

        document.getElementById('pack_amount').addEventListener('input', calculateUnitPrice);
        document.getElementById('items_per_pack').addEventListener('input', calculateUnitPrice);
        document.getElementById('total_purchase_price').addEventListener('input', () => {
            updateOriginalTotalPrice();
            calculateUnitPrice();
        });
        document.getElementById('use_discount').addEventListener('change', resetDiscount);
        document.getElementById('discount_amount')?.addEventListener('blur', calculateUnitPrice);
    </script>
</div>