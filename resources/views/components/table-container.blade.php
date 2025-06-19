@props([
    'headers' => [], // Array header: ['key' => 'field_name', 'label' => 'Display Name', 'format' => 'type', 'align' => 'left|center|right']
    'data' => null, // Data: bisa Paginator, Collection, atau array
    'actions' => [], // Array tombol aksi: ['label' => 'Text', 'wire:click' => 'method', 'class' => 'css', 'icon' => 'svg_path']
    'perPage' => 10, // Jumlah data per halaman (jika paginasi)
    'tableId' => 'table-' . Str::random(8), // ID unik untuk tabel
])
@props(['headers', 'data', 'actions', 'perPage' => 10, 'tableId' => 'table'])

<div class="overflow-x-auto">
    <table id="{{ $tableId }}" class="w-full table-auto border-collapse text-xs">
        <thead>
            <tr class="bg-theme-primary text-white">
                @foreach ($headers as $header)
                    <th class="px-2 py-2 border border-theme-primary {{ $header['align'] ?? 'left' }}">{{ $header['label'] }}</th>
                @endforeach
                @if (!empty($actions))
                    <th class="px-2 py-2 border border-theme-primary text-center">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr class="hover:bg-theme-light">
                    @foreach ($headers as $header)
                        <td class="border px-2 py-2 border-theme-primary {{ $header['align'] ?? 'left' }}">
                            @php
                                $value = data_get($item, $header['key']);
                            @endphp
                            @if (isset($header['format']))
                                @if ($header['format'] === 'datetime')
                                    {{ \Carbon\Carbon::parse($value)->format('d/m/Y H:i') }}
                                @elseif ($header['format'] === 'currency')
                                    Rp {{ number_format($value, 2, ',', '.') }}
                                @elseif ($header['format'] === 'ucfirst')
                                    {{ ucfirst($value) }}
                                @elseif ($header['format'] === 'boolean_titipan')
                                    @php
                                        $hasTitipan = $item->details->contains(function ($detail) {
                                            return $detail->barang && $detail->barang->status_titipan;
                                        });
                                    @endphp
                                    {{ $hasTitipan ? 'Ya' : 'Tidak' }}
                                @else
                                    {{ $value }}
                                @endif
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    @endforeach
                    @if (!empty($actions))
                        <td class="border px-2 py-2 border-theme-primary text-center">
                            <div class="flex justify-center space-x-1">
                                @foreach ($actions as $action)
                                    <button wire:click="{{ $action['method'] }}({{ $item->id }})" class="{{ $action['class'] }} py-1 px-2 rounded flex items-center space-x-1 text-xs">
                                        {!! $action['icon'] !!}
                                        <span>{{ $action['label'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + (empty($actions) ? 0 : 1) }}" class="border px-2 py-2 text-center border-theme-primary text-xs">
                        Tidak ada data.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    @endif
</div>