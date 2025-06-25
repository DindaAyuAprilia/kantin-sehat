<div class="min-h-screen flex flex-col p-4 sm:p-[2%] overflow-hidden">

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
        title="Manajemen Karyawan" 
        icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
    />

    <!-- Konten Utama -->
    <div class="space-y-6 flex-1">

        <!-- Karyawan Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Form Karyawan -->
            <div id="form-karyawan" class="max-h-[calc(100vh-0.5vh)] overflow-y-auto bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <x-card-header 
                    title="{{ $isEditingKaryawan ? 'Edit Karyawan' : 'Tambah Karyawan' }}" 
                    icon="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" 
                />

                <form wire:submit.prevent="{{ $isEditingKaryawan ? 'confirmUpdate' : 'saveKaryawan' }}" x-data="{ showPassword: false }">
                    <div class="space-y-4 px-6">
                        
                        <!-- Input Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-theme-black">Nama</label>
                            <div class="relative">
                                <input wire:model="nama" id="nama" type="text" x-ref="nama" placeholder="Masukkan nama" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"  />
                                    </svg>
                                </span>
                            </div>
                            @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-theme-black">Email</label>
                            <div class="relative">
                                <input wire:model="email" id="email" type="email" x-ref="email" placeholder="Masukkan email" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </span>
                            </div>
                            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-theme-black">Password</label>
                            <div class="relative">
                                <input wire:model="password" id="password" :type="showPassword ? 'text' : 'password'" x-ref="password" placeholder="Masukkan password" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-10 text-base" autocomplete="off">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" @click="showPassword = !showPassword">
                                    <svg x-show="!showPassword" class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M10 3C5.5 3 1.6 6.1 0 10c1.6 3.9 5.5 7 10 7s8.4-3.1 10-7c-1.6-3.9-5.5-7-10-7zm0 12a5 5 0 01-5-5 5 5 0 0110 0 5 5 0 01-5 5z" clip-rule="evenodd" />
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5 text-theme-primary" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </span>
                            </div>
                            @if($isEditingKaryawan)
                                <p class="text-sm text-theme-black mt-1">*Kosongkan jika tidak diubah</p>
                            @endif
                            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-theme-black">Role</label>
                            <select wire:model="role" id="role" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary text-base">
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                            </select>
                            @error('role') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-theme-black">Status</label>
                            <select wire:model="status" id="status" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary text-base">
                                <option value="aktif">Aktif</option>
                                <option value="berhenti">Berhenti</option>
                            </select>
                            @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Tanggal Berhenti -->
                        <div x-data="{ status: @entangle('status') }" x-show="status === 'berhenti'">
                            <label for="tanggal_berhenti" class="block text-sm font-medium text-theme-black">Tanggal Berhenti</label>
                            <input wire:model="tanggal_berhenti" id="tanggal_berhenti" type="date" class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary text-base">
                            @error('tanggal_berhenti') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-4 flex justify-end space-x-2 px-6">
                        <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">Reset</button>
                        <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-md hover:bg-theme-secondary flex items-center space-x-2 text-sm w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $isEditingKaryawan ? 'Update Karyawan' : 'Tambah Karyawan' }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card Tabel Karyawan -->
            <div id="tabel-karyawan" class="lg:col-span-2 bg-theme-surface pb-6 rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <x-card-header 
                    title="Daftar Karyawan" 
                    icon="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" 
                />

                <!-- Dropdown Filter -->
                <div class="mb-4 px-6 flex flex-col gap-4 sm:flex-row sm:space-x-4">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.500ms="search" id="search" placeholder="Cari nama, email, role, status, atau tanggal berhenti..." class="block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2 text-base">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"  />
                            </svg>
                        </span>
                    </div>
                    <select wire:model.live="roleFilter" class="w-full sm:w-auto rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary text-base">
                        <option value="all">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>

                <!-- Tabel Karyawan -->
                <div class="px-6">
                    <x-table 
                        :headers="[
                            ['key' => 'nama', 'label' => 'Nama', 'align' => 'left'],
                            ['key' => 'email', 'label' => 'Email', 'align' => 'left'],
                            ['key' => 'role', 'label' => 'Role', 'format' => 'ucfirst', 'align' => 'center'],
                            ['key' => 'status', 'label' => 'Status', 'format' => 'ucfirst', 'align' => 'center'],
                            ['key' => 'tanggal_berhenti', 'label' => 'Tanggal Berhenti', 'format' => 'tanggal', 'align' => 'center'],
                        ]"
                        :data="$karyawan"
                        :actions="[
                            ['label' => 'Edit', 'wire:click' => 'edit', 'class' => 'bg-yellow-400 hover:bg-yellow-500 text-black', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                        ]"
                        per-page="10"
                        table-id="karyawanTable"
                    />
                </div>
                
            </div>
        </div>
    </div>

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
                    text: 'Apakah Anda yakin ingin memperbarui data karyawan?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('proceedUpdateKaryawan');
                    }
                });
            });
        });
    </script>
</div>