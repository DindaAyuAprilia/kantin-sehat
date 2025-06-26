<div class=" min-h-screen flex flex-col p-4 sm:p-[2%] overflow-hidden">
    
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
        title="Manajemen Persediaan" 
        icon="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18"
    />

    <!-- Konten Utama -->
    <div class="space-y-6 flex-1">

        <!-- Persediaan Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Persediaan -->
            <div id="form-persediaan" class="max-h-[calc(100vh-0.5vh)] overflow-y-auto bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;" x-data="{ searchOpen: false }">
                <x-card-header 
                    title="{{ $isEditing ? 'Edit Persediaan' : 'Catat Persediaan' }}" 
                    icon="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" 
                />

                <form wire:submit.prevent="{{ $isEditing ? 'confirmUpdate' : 'save' }}" x-ref="persediaanForm">
                    <div class="space-y-4 px-6">

                        <!-- Input Barang -->
                        <div>
                            <label for="search_barang" class="block text-sm font-medium text-theme-black">Barang</label>
                            <div class="relative">
                                <input wire:model.live.debounce.300ms="search_query_form" id="search_barang" type="text" x-ref="search_barang" placeholder="Ketik nama atau scan kode barang" autocomplete="off" x-on:input="searchOpen = true" x-on:keydown.enter.prevent="searchOpen = false" x-on:keydown.escape="searchOpen = false" x-on:focus="searchOpen = true" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"  />
                                    </svg>
                                </span>
                            </div>
                            <div x-show="searchOpen && $wire.search_results.length > 0" class="absolute z-50 mt-1 bg-white border border-theme-black rounded-md shadow-lg max-h-60 overflow-auto" x-ref="dropdown">
                                <ul>
                                    @foreach($search_results as $result)
                                        <li wire:click="selectBarang({{ $result->id }})" class="px-4 py-2 hover:bg-theme-primary hover:text-theme-white cursor-pointer text-sm">
                                            {{ $result->kode_barang }} - {{ $result->nama }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('barang_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Dikelola Oleh -->
                        <div>
                            <label class="block text-sm font-medium text-theme-black">Dikelola Oleh</label>
                            <div class="relative">
                                <input type="text" value="{{ Auth::user()->nama ?? 'Pengelola Saat Ini' }}" readonly class="mt-1 block w-full rounded-md border-theme-black bg-gray-100 shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"  />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Input Tipe -->
                        <div>
                            <label for="tipe" class="block text-sm font-medium text-theme-black">Tipe</label>
                            <div class="relative">
                                <select wire:model="tipe" id="tipe" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                    @if($barang_id)
                                        @php
                                            $barang = \App\Models\Barang::find($barang_id);
                                            $isTitipan = $barang ? $barang->status_titipan : false;
                                        @endphp
                                        @if($isTitipan)
                                            <option value="penambahan_titipan">Penambahan Titipan</option>
                                            <option value="pengambilan_titipan">Pengembalian Titipan</option>
                                        @else
                                            <option value="pembelian">Pembelian</option>
                                            <option value="penghapusan">Penghapusan</option>
                                        @endif
                                    @else
                                        <option value="" disabled selected>Pilih barang terlebih dahulu</option>
                                    @endif
                                </select>
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"></path>
                                    </svg>
                                </span>
                            </div>
                            @error('tipe') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-theme-black">Tanggal</label>
                            <div class="relative">
                                <input wire:model="tanggal" id="tanggal" type="date" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z"  />
                                    </svg>
                                </span>
                            </div>
                            @error('tanggal') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bulk Purchase Calculator Toggle -->
                        @if(in_array($tipe, ['pembelian', 'penambahan_titipan']))
                            <div>
                                <label class="block text-sm font-medium text-theme-black">Gunakan Kalkulator Massal</label>
                                <input type="checkbox" wire:model="use_calculator" class="bg-theme-primary text-theme-primary form-checkbox mt-1">
                            </div>
                        @endif

                        <!-- Calculator Fields -->
                        <div x-show="$wire.use_calculator && ['pembelian', 'penambahan_titipan'].includes('{{ $tipe }}')">
                            <div class="space-y-4">
                                <!-- Jumlah Pack/Dus -->
                                <div>
                                    <label for="pack_amount" class="block text-sm font-medium text-theme-black">Jumlah Pack/Dus</label>
                                    <div class="relative">
                                        <input type="number" wire:model="pack_amount" id="pack_amount" min="0" step="1" placeholder="Masukkan jumlah pack/dus" @input="calculate" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                                            </svg>
                                        </span>
                                    </div>
                                    @error('pack_amount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <!-- Satuan per Pack -->
                                <div>
                                    <label for="items_per_pack" class="block text-sm font-medium text-theme-black">Satuan per Pack</label>
                                    <div class="relative">
                                        <input type="number" wire:model="items_per_pack" id="items_per_pack" min="0" step="1" placeholder="Masukkan satuan per pack" @input="calculate" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 22" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                                            </svg>
                                        </span>
                                    </div>
                                    @error('items_per_pack') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>
                               
                                <!-- Total Harga -->
                                <div x-data="{ totalHargaPembelian: '' }">
                                    <label for="total_harga" class="block text-sm font-medium text-theme-black">Total Harga Pembelian (Rp)</label>
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            wire:model.blur="total_harga" 
                                            x-model="totalHargaPembelian"
                                            id="total_harga" 
                                            min="0" 
                                            step="0.01" 
                                            placeholder="Masukkan total harga pembelian" 
                                            @input="calculate"
                                            class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base"
                                        >
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600" x-text="totalHargaPembelian ? 'Rp ' + parseFloat(totalHargaPembelian).toLocaleString('id-ID') : 'Rp 0'"></p>
                                    @error('total_harga') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <!-- Gunakan Potongan -->
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
                                <!-- Jumlah Potongan -->
                                <div x-show="$wire.use_discount" class="flex items-end gap-2" x-data="{ totalPotongan: '' }">
                                    <div class="flex-1">
                                        <label for="discount_amount" class="block text-sm font-medium text-theme-black">Total Potongan (Rp)</label>
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                wire:model.blur="discount_amount" 
                                                x-model="totalPotongan"
                                                id="discount_amount" 
                                                min="0" 
                                                step="0.01" 
                                                placeholder="Masukkan jumlah potongan" 
                                                @input="calculate" 
                                                class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base"
                                            >
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600" x-text="totalPotongan ? 'Rp ' + parseFloat(totalPotongan).toLocaleString('id-ID') : 'Rp 0'"></p>
                                        @error('discount_amount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Harga Beli (Readonly) -->
                                <div>
                                    <label for="harga_beli_calc" class="block text-sm font-medium text-theme-black">Harga Pokok per Unit (Rp)</label>
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            wire:model="harga_beli"
                                            id="harga_beli_calc" 
                                            readonly 
                                            class="mt-1 block w-full rounded-md border-theme-black bg-gray-100 shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base"
                                        >
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Input Jumlah -->
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-theme-black">Jumlah Satuan Barang</label>
                            <div class="relative">
                                <input wire:model.live="jumlah" id="jumlah" type="number" min="1" 
                                       @if($barang_id && in_array($tipe, ['penghapusan', 'pengambilan_titipan'])) 
                                           max="{{ \App\Models\Barang::find($barang_id)->stok }}" 
                                       @endif
                                       :readonly="$wire.use_calculator && ['pembelian', 'penambahan_titipan'].includes('{{ $tipe }}')"
                                       placeholder="Masukkan jumlah" 
                                       class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base"
                                       x-bind:class="{ 'bg-gray-100 cursor-not-allowed': $wire.use_calculator && ['pembelian', 'penambahan_titipan'].includes('{{ $tipe }}') }">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"  />
                                    </svg>
                                </span>
                            </div>
                            @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            @if($barang_id && in_array($tipe, ['penghapusan', 'pengambilan_titipan']))
                                <span class="text-sm text-gray-600">Stok saat ini: {{ \App\Models\Barang::find($barang_id)->stok }}</span>
                            @endif
                        </div>

                        <!-- Input Harga Beli (Non-Calculator) -->
                        <div x-data="{ hargaPokok: '' }" x-show="!($wire.use_calculator && ['pembelian', 'penambahan_titipan'].includes('{{ $tipe }}'))">
                            <label for="harga_beli" class="block text-sm font-medium text-theme-black">Harga Pokok</label>
                            <div class="relative">
                                <input wire:model.live="harga_beli" id="harga_beli" type="number" step="0.01" min="0" 
                                       placeholder="Masukkan harga beli" 
                                        x-model="hargaPokok"
                                       class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"  />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-gray-600" x-text="hargaPokok ? 'Rp ' + parseFloat(hargaPokok).toLocaleString('id-ID') : 'Rp 0'"></p>
                            @error('harga_beli') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Alasan -->
                        <div>
                            <label for="alasan" class="block text-sm font-medium text-theme-black">Alasan</label>
                            <div class="relative">
                                <textarea wire:model="alasan" id="alasan" placeholder="Masukkan alasan (opsional)" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pt-2 text-base"></textarea>
                                <span class="absolute inset-y-0 left-0 flex items-start pl-3 pt-2">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"  />
                                    </svg>
                                </span>
                            </div>
                            @error('alasan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-4 flex justify-end space-x-2 px-6">
                        <button type="button" 
                                wire:click="resetForm" 
                                @click="$refs.persediaanForm.reset(); searchOpen = false; $wire.set('search_query_form', ''); $wire.set('barang_id', null); $wire.set('tipe', ''); $wire.set('tanggal', ''); $wire.set('jumlah', ''); $wire.set('harga_beli', ''); $wire.set('alasan', ''); $wire.set('use_calculator', false); $wire.set('pack_amount', ''); $wire.set('items_per_pack', ''); $wire.set('total_harga', ''); $wire.set('use_discount', false); $wire.set('discount_amount', ''); resetCalculatorFields();"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">
                            Reset
                        </button>
                        <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $isEditing ? 'Update Persediaan' : 'Catat Persediaan' }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Persediaan -->
            <div id="tabel-persediaan" class="lg:col-span-2 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <x-card-header 
                    title="Daftar Persediaan"
                    icon="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" 
                />

                <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:space-x-4 px-6">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.500ms="search_query_table" id="search" placeholder="Cari nama barang atau tanggal..." class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </span>
                    </div>
                    <select wire:model.live="tipe_filter" class="w-full sm:w-auto rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary text-base">
                        <option value="all">Semua Tipe</option>
                        <option value="pembelian">Pembelian</option>
                        <option value="penghapusan">Penghapusan</option>
                        <option value="penambahan_titipan">Penambahan Titipan</option>
                        <option value="pengambilan_titipan">Pengambilan Titipan</option>
                    </select>
                </div>

                <div class="px-6">
                    <x-table
                        :headers="[
                            ['key' => 'barang', 'label' => 'Barang', 'format' => 'relation'],
                            ['key' => 'kelola', 'label' => 'Dikelola Oleh', 'format' => 'relation'],
                            ['key' => 'tipe', 'label' => 'Tipe', 'format' => 'tipe_persediaan'],
                            ['key' => 'tanggal', 'label' => 'Tanggal', 'format' => 'tanggal'],
                            ['key' => 'jumlah', 'label' => 'Jumlah', 'align' => 'center'],
                            ['key' => 'total_harga', 'label' => 'Total Harga', 'format' => 'currency_no_decimal'],
                            ['key' => 'alasan', 'label' => 'Alasan'],
                        ]"
                        :data="$persediaans"
                        :actions="[
                            ['label' => 'Edit', 'wire:click' => 'confirmEdit', 'class' => 'bg-yellow-400 hover:bg-yellow-500 text-black', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                            ['label' => 'Hapus', 'wire:click' => 'confirmDelete', 'class' => 'bg-red-400 hover:bg-red-500 text-white', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
                        ]"
                        table-id="persediaanTable"
                    />
                </div>
            </div>
        </div>

        <!-- Tabel Histori -->
        <div class="bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
            <x-card-header 
                title="Histori Perubahan Persediaan"
                icon="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" 
            />
            
            <div class="px-6">
                <button wire:click="toggleHistory" class="px-4 py-2 bg-theme-primary text-theme-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $showHistory ? 'M6 18L18 6M6 6l12 12' : 'M5 15l7-7 7 7' }}"></path>
                </svg>
                <span>{{ $showHistory ? 'Sembunyikan Histori' : 'Tampilkan Histori' }}</span>
            </button>
                @if($showHistory)
                    <div class="relative overflow-y-auto max-h-[calc(100%-12rem)] scrollbar-thin scrollbar-thumb-theme-primary scrollbar-track-theme-surface">
                        <div class="border border-gray-300 p-1">
                            <table class="w-full table-auto border-collapse text-xs">
                                <thead class="sticky top-0 bg-theme-primary text-white z-10">
                                    <tr>
                                        <th class="px-2 py-2 border border-theme-primary text-left">Waktu</th>
                                        <th class="px-2 py-2 border border-theme-primary text-left">Dikelola Oleh</th>
                                        <th class="px-2 py-2 border border-theme-primary text-left">Aksi</th>
                                        <th class="px-2 py-2 border border-theme-primary text-left">Detail Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activityLogs as $log)
                                        <tr class="border border-theme-primary hover:bg-theme-light">
                                            <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-nowrap">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">{{ $log->causer->nama ?? 'Unknown' }}</td>
                                            <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-nowrap">{{ ucfirst($log->event) }}</td>
                                            <td class="px-2 py-2 text-theme-black border border-theme-primary whitespace-normal break-words">
                                                @if($log->event === 'created')
                                                    Ditambahkan: 
                                                    @if($log->properties['attributes']['tipe'] === 'pembelian')
                                                        Pembelian
                                                    @elseif($log->properties['attributes']['tipe'] === 'penghapusan')
                                                        Penghapusan
                                                    @elseif($log->properties['attributes']['tipe'] === 'penambahan_titipan')
                                                        Penambahan Titipan
                                                    @elseif($log->properties['attributes']['tipe'] === 'pengambilan_titipan')
                                                        Pengambilan Titipan
                                                    @else
                                                        {{ $log->properties['attributes']['tipe'] }}
                                                    @endif
                                                    untuk barang {{ $log->subject?->barang->nama ?? \App\Models\Barang::find($log->properties['attributes']['barang_id'])->nama ?? 'Unknown' }} sebanyak {{ $log->properties['attributes']['jumlah'] }}
                                                @elseif($log->event === 'updated')
                                                    Diperbarui:
                                                    @foreach($log->properties['attributes'] as $key => $newValue)
                                                        @if(isset($log->properties['old'][$key]))
                                                            @if($key === 'tipe')
                                                                {{ $key }} dari 
                                                                @if($log->properties['old'][$key] === 'pembelian')
                                                                    Pembelian
                                                                @elseif($log->properties['old'][$key] === 'penghapusan')
                                                                    Penghapusan
                                                                @elseif($log->properties['old'][$key] === 'penambahan_titipan')
                                                                    Penambahan Titipan
                                                                @elseif($log->properties['old'][$key] === 'pengambilan_titipan')
                                                                    Pengambilan Titipan
                                                                @else
                                                                    {{ $log->properties['old'][$key] }}
                                                                @endif
                                                                menjadi 
                                                                @if($newValue === 'pembelian')
                                                                    Pembelian
                                                                @elseif($newValue === 'penghapusan')
                                                                    Penghapusan
                                                                @elseif($newValue === 'penambahan_titipan')
                                                                    Penambahan Titipan
                                                                @elseif($newValue === 'pengambilan_titipan')
                                                                    Pengambilan Titipan
                                                                @else
                                                                    {{ $newValue }}
                                                                @endif
                                                            @else
                                                                {{ $key }} dari "{{ $log->properties['old'][$key] }}" menjadi "{{ $newValue }}"
                                                            @endif
                                                            ;
                                                        @endif
                                                    @endforeach
                                                @elseif($log->event === 'deleted')
                                                    Dihapus: 
                                                    @if($log->properties['old']['tipe'] === 'pembelian')
                                                        Pembelian
                                                    @elseif($log->properties['old']['tipe'] === 'penghapusan')
                                                        Penghapusan
                                                    @elseif($log->properties['old']['tipe'] === 'penambahan_titipan')
                                                        Penambahan Titipan
                                                    @elseif($log->properties['old']['tipe'] === 'pengambilan_titipan')
                                                        Pengambilan Titipan
                                                    @else
                                                        {{ $log->properties['old']['tipe'] }}
                                                    @endif
                                                    untuk barang {{ \App\Models\Barang::find($log->properties['old']['barang_id'])->nama ?? 'Unknown' }} sebanyak {{ $log->properties['old']['jumlah'] }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-2 text-theme-black border border-theme-primary">Tidak ada histori perubahan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div class="flex space-x-2">
                            <button wire:click="previousHistoryPage" {{ $activityLogs->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs"><</button>
                            @foreach ($activityLogs->getUrlRange(1, $activityLogs->lastPage()) as $page => $url)
                                <button wire:click="gotoHistoryPage({{ $page }})" class="px-3 py-1 {{ $activityLogs->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-theme-light text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white text-xs">{{ $page }}</button>
                            @endforeach
                            <button wire:click="nextHistoryPage" {{ $activityLogs->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs">></button>
                        </div>
                        <span class="text-xs text-theme-black">
                            Menampilkan {{ $activityLogs->firstItem() ?: 0 }} - {{ $activityLogs->lastItem() ?: 0 }} dari {{ $activityLogs->total() }} histori
                        </span>
                    </div>
                @endif
            </div>
            
        </div>
    </div>

    <!-- JavaScript untuk menangani SweetAlert dan Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search_barang');
            const jumlahInput = document.getElementById('jumlah');
            const dropdown = document.querySelector('[x-ref="dropdown"]');
            if (searchInput) {
                searchInput.focus();
            }

            function adjustDropdownWidth() {
                if (!dropdown) return;
                const items = dropdown.querySelectorAll('li');
                if (items.length === 0) return;

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                context.font = '12px sans-serif';
                let maxWidth = 0;

                items.forEach(item => {
                    const text = item.textContent;
                    const textWidth = context.measureText(text).width;
                    maxWidth = Math.max(maxWidth, textWidth);
                });

                const extraWidth = maxWidth * 0.05;
                const totalWidth = maxWidth + extraWidth + 32;
                const inputWidth = searchInput.getBoundingClientRect().width;

                dropdown.style.width = `${Math.min(totalWidth, inputWidth)}px`;
            }

            new MutationObserver(adjustDropdownWidth).observe(dropdown, { childList: true, subtree: true });

            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !e.target.closest('.absolute.z-50')) {
                    Alpine.data('searchOpen', () => false);
                }
            });

            window.addEventListener('barangSelected', () => {
                if (jumlahInput) {
                    jumlahInput.focus();
                    jumlahInput.select();
                }
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:confirmSave', () => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data persediaan akan dicatat.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007022',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, catat!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('proceedSave');
                    }
                });
            });

            Livewire.on('swal:confirmUpdatePersediaan', () => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data persediaan akan diperbarui.',
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

            Livewire.on('swal:confirmDeletePersediaan', (data) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data persediaan akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#007022',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deletePersediaan', { id: data.id });
                    }
                });
            });

            Livewire.on('swal:success', (data) => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#007022',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reset form setelah sukses
                    document.querySelector('[x-ref="persediaanForm"]').reset();
                    resetCalculatorFields();
                    Livewire.dispatch('set', { 
                        search_query_form: '',
                        barang_id: null,
                        tipe: '',
                        tanggal: new Date().toISOString().split('T')[0],
                        jumlah: '',
                        harga_beli: '',
                        alasan: '',
                        use_calculator: false,
                        pack_amount: '',
                        items_per_pack: '',
                        total_harga: '',
                        use_discount: false,
                        discount_amount: ''
                    });
                    document.getElementById('search_barang').focus();
                });
            });

            Livewire.on('swal:error', (data) => {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            });

            Livewire.on('resetForm', () => {
                document.querySelector('[x-ref="persediaanForm"]').reset();
                resetCalculatorFields();
                Livewire.dispatch('set', { 
                    search_query_form: '',
                    barang_id: null,
                    tipe: '',
                    tanggal: '',
                    jumlah: '',
                    harga_beli: '',
                    alasan: '',
                    use_calculator: false,
                    pack_amount: '',
                    items_per_pack: '',
                    total_harga: '',
                    use_discount: false,
                    discount_amount: ''
                });
                document.getElementById('search_barang').focus();
            });
        });

        let originalTotalPrice = 0;

        function updateOriginalTotalPrice() {
            originalTotalPrice = parseFloat(document.getElementById('total_harga').value) || 0;
        }

        function calculate() {
            const packAmount = parseInt(document.getElementById('pack_amount').value) || 0;
            const itemsPerPack = parseInt(document.getElementById('items_per_pack').value) || 0;
            const totalPrice = originalTotalPrice; // Gunakan originalTotalPrice sebagai dasar
            const useDiscount = document.getElementById('use_discount').checked;
            const discountAmount = useDiscount ? parseFloat(document.getElementById('discount_amount').value) || 0 : 0;

            const totalStock = packAmount * itemsPerPack;
            const adjustedTotalPrice = Math.max(0, totalPrice - discountAmount);
            const unitPrice = totalStock > 0 ? (adjustedTotalPrice / totalStock).toFixed(2) : 0;

            document.getElementById('jumlah').value = totalStock;
            document.getElementById('harga_beli_calc').value = unitPrice;
            document.getElementById('total_harga').value = adjustedTotalPrice; // Update UI dengan harga setelah potongan

            // Kirim nilai ke server
            Livewire.dispatch('set', { 
                jumlah: totalStock,
                harga_beli: unitPrice,
                total_harga: adjustedTotalPrice
            });
        }

        function resetDiscount() {
            if (!document.getElementById('use_discount').checked) {
                document.getElementById('discount_amount').value = 0;
            }
            document.getElementById('total_harga').value = originalTotalPrice; // Kembalikan ke originalTotalPrice
            calculate();
        }

        document.getElementById('pack_amount')?.addEventListener('input', calculate);
        document.getElementById('items_per_pack')?.addEventListener('input', calculate);
        document.getElementById('total_harga')?.addEventListener('input', () => {
            updateOriginalTotalPrice();
            calculate();
        });
        document.getElementById('use_discount')?.addEventListener('change', resetDiscount);
        document.getElementById('discount_amount')?.addEventListener('input', calculate);
    </script>
</div>