@props([
    'headers' => [], // Array header: ['key' => 'field_name', 'label' => 'Display Name', 'format' => 'type', 'align' => 'left|center|right']
    'data' => null, // Data: bisa Paginator, Collection, atau array
    'actions' => [], // Array tombol aksi: ['label' => 'Text', 'wire:click' => 'method', 'class' => 'css', 'icon' => 'svg_path']
    'perPage' => 10, // Jumlah data per halaman (jika paginasi)
    'tableId' => 'table-' . Str::random(8), // ID unik untuk tabel
])


<div class="relative rounded-s shadow-lg overflow-y-auto max-h-[calc(100vh-400px)] scrollbar-thin scrollbar-thumb-theme-primary scrollbar-track-theme-surface border border-theme-primary">
    <table class="w-full table-auto border-collapse text-xs">
        <thead class="sticky top-0 bg-theme-primary text-white z-10">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-2 py-2 border border-theme-dark {{ $header['align'] ?? 'text-center' }}">{{ $header['label'] }}</th>
                @endforeach
                @if (!empty($actions))
                    <th class="px-2 py-2 border border-theme-dark text-center">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody id="{{ $tableId }}">
            @forelse ($data as $item)
                <tr class="border border-theme-dark hover:bg-theme-light">
                    @foreach ($headers as $header)
                        <td class="px-2 py-2 text-theme-black border border-theme-primary {{ $header['align'] ?? 'text-left' }}">
                            @php
                                $value = is_array($item) ? ($item[$header['key']] ?? null) : ($item->{$header['key']} ?? null);
                            @endphp
                            @if (isset($header['format']))
                                @if ($header['format'] === 'currency')
                                    Rp {{ number_format($value, 2, ',', '.') }}
                                @elseif ($header['format'] === 'ucfirst')
                                    {{ ucfirst($value) }}
                                @elseif ($header['format'] === 'boolean')
                                    {{ $value ? 'Ya' : 'Tidak' }}
                                @elseif ($header['format'] === 'relation')
                                    @if ($header['key'] === 'karyawan' && is_object($item) && isset($item->karyawan))
                                        {{ $item->karyawan->nama ? $item->karyawan->nama . ' (' . ucfirst($item->karyawan->role ?? '') . ')' : 'Tidak Diketahui' }}
                                    @elseif ($header['key'] === 'admin' && is_object($item) && isset($item->admin))
                                        {{ $item->admin->nama ?? 'Tidak Diketahui' }}
                                    @elseif ($header['key'] === 'user' && is_object($item) && isset($item->user))
                                        {{ $item->user->nama ?? 'Tidak Diketahui' }}
                                    @elseif ($header['key'] === 'hasil_bagi' && is_object($item) && isset($item->hasilBagi))
                                        {{ $item->hasilBagi->tipe ?? '-' }}
                                    @elseif ($header['key'] === 'barang' && is_object($item) && isset($item->barang))
                                        {{ $item->barang->kode_barang }} - {{ $item->barang->nama }}
                                    @elseif ($header['key'] === 'kelola' && is_object($item) && isset($item->kelola))
                                        {{ $item->kelola->nama }}
                                    @else
                                        {{ $value ?? '-' }}
                                    @endif
                                @elseif ($header['format'] === 'status')
                                    <span class="{{ $value ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2 py-1 rounded">
                                        {{ $value ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                
                                @elseif ($header['format'] === 'tanggal')
                                    {{ $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : '-' }}
                                @elseif ($header['format'] === 'datetime')
                                    {{ $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : '-' }}
                                @elseif ($header['format'] === 'tanggal_transaksi')
                                    {{ $value ? \Carbon\Carbon::parse($value)->translatedFormat('d F Y') : '-' }}
                                @elseif ($header['format'] === 'transaction_details' && is_object($item) && $item->details)
                                    <ul class="list-decimal pl-5">
                                        @foreach($item->details as $detail)
                                            <li>
                                                @if($detail->barang_id && $detail->barang)
                                                    {{ $detail->barang->nama }} ({{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }})
                                                @elseif($detail->keterangan)
                                                    {{ $detail->keterangan }}: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                @else
                                                    Item tidak dikenal
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @elseif ($header['format'] === 'boolean_titipan' && is_object($item) && $item->details)
                                    <div class="text-left">
                                        <ul class="list-disc pl-4 space-y-1">
                                            @foreach($item->details as $detail)
                                                <li class="text-xs">
                                                    @if($detail->barang_id && $detail->barang)
                                                        {{ $detail->barang->nama }} ({{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}) = Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    @elseif($detail->keterangan)
                                                        {{ $detail->keterangan }}: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    @else
                                                        Item tidak dikenal
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @elseif ($header['format'] === 'count')
                                    {{ is_object($item) ? ($item->barangs->count() ?? 0) : ($value ?? 0) }}
                                @elseif ($header['format'] === 'tipe_persediaan')
                                    @if($value === 'pembelian')
                                        Pembelian
                                    @elseif($value === 'penghapusan')
                                        Penghapusan
                                    @elseif($value === 'penambahan_titipan')
                                        Penambahan Titipan
                                    @elseif($value === 'pengambilan_titipan')
                                        Pengambilan Titipan
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $value)) }}
                                    @endif
                                @elseif ($header['format'] === 'currency_no_decimal')
                                    Rp {{ number_format($value, 0, ',', '.') }}
                                @else
                                    {{ $value ?? '-' }}
                                @endif
                            @else
                                {{ $value ?? '-' }}
                            @endif
                        </td>
                    @endforeach
                    @if (!empty($actions))
                        <td class="px-2 py-2 text-theme-black border border-theme-primary text-center">
                            <div class="flex justify-center space-x-1">
                                @foreach ($actions as $action)
                                    @php
                                        $label = $action['label'];
                                        $class = $action['class'];
                                        $itemId = is_array($item) ? ($item['id'] ?? null) : ($item->id ?? null);
                                        if (strpos($label, 'is_active') !== false && is_object($item)) {
                                            $label = $item->is_active ? 'Nonaktifkan' : 'Aktifkan';
                                        }
                                        if (strpos($class, 'is_active') !== false && is_object($item)) {
                                            $class = $item->is_active ? 'bg-red-400 hover:bg-red-500 text-white' : 'bg-green-400 hover:bg-green-500 text-white';
                                        }
                                    @endphp
                                    <button wire:click="{{ $action['wire:click'] }}({{ $itemId }})" class="{{ $class }} py-1 px-2 rounded flex items-center space-x-1 text-xs">
                                        @if (!empty($action['icon']))
                                            @php
                                                $icon = $action['icon'];
                                                if (strpos($icon, 'is_active') !== false && is_object($item)) {
                                                    $icon = $item->is_active ? 'M6 18L18 6M6 6l12 12' : 'M5 13l4 4L19 7';
                                                }
                                            @endphp
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                                            </svg>
                                        @endif
                                        <span>{{ $label }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + (!empty($actions) ? 1 : 0) }}" class="text-center py-2 text-theme-black border border-theme-primary">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex space-x-2">
            <button wire:click="previousPage" {{ $data->onFirstPage() ? 'disabled' : '' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs"><</button>
            @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 {{ $data->currentPage() === $page ? 'bg-theme-primary text-white' : 'bg-theme-light text-theme-black' }} rounded hover:bg-theme-secondary hover:text-white text-xs">{{ $page }}</button>
            @endforeach
            <button wire:click="nextPage" {{ $data->hasMorePages() ? '' : 'disabled' }} class="px-3 py-1 bg-theme-primary text-white rounded hover:bg-theme-secondary disabled:bg-gray-300 text-xs">></button>
        </div>
        <span class="text-xs text-theme-black">
            Menampilkan {{ $data->firstItem() ?: 0 }} - {{ $data->lastItem() ?: 0 }} dari {{ $data->total() }} data
        </span>
    </div>
@endif

<style>
    [x-cloak] {
        display: none !important;
    }
    .scrollbar-thin {
        scrollbar-width: thin;
    }
    .scrollbar-thumb-theme-primary {
        scrollbar-color: #007022 #f1f5f9;
    }
    .scrollbar-track-theme-surface {
        background: rgb(249, 243, 241);
    }
    thead.sticky th {
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>