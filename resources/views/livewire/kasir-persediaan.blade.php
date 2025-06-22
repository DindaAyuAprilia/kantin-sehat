<div>
    <div class="p-6">

        <!-- Main Header -->
        <x-header 
            title="Daftar Persediaan" 
            icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
        />
        <section class="min-h-screen flex flex-col p-4 sm:p-6 overflow-hidden">
            <!-- Tabel Persediaan -->
            <div id="tabel-persediaan" class="w-full max-w-4xl p-6 bg-theme-surface rounded-lg shadow-lg border-2 border-theme-primary" style="border-color: #007022;">
                <h2 class="text-xl font-semibold text-theme-black mb-4">Daftar Persediaan Barang</h2>
                <div class="mb-4 relative">
                    <input wire:model.live="search_query" type="text" id="search" placeholder="Cari nama atau kode barang..."
                        class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-4 py-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>

                <div class="overflow-y-auto max-h-[calc(100vh-20rem)]">
                    <x-table
                        :headers="[
                            ['key' => 'kode_barang', 'label' => 'Kode Barang', 'align' => 'left'],
                            ['key' => 'nama', 'label' => 'Nama Barang', 'align' => 'left'],
                            ['key' => 'stok', 'label' => 'Stok', 'align' => 'right'],
                        ]"
                        :data="$barangs"
                        :actions="[]"
                        :perPage="10"
                        :tableId="'persediaan-table'"
                    />
                </div>
            </div>
        </section>
    </div>
</div>