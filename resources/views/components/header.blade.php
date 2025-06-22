@props([
    'title' => 'Default Title',
    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
    'tabs' => [], // Array untuk tab navigation, kosong berarti tanpa tab
    'activeTab' => null // Menyimpan tab aktif
])

<div class="mb-6 bg-theme-surface text-theme-primary rounded-lg p-6 shadow-lg border-2 border-theme-primary">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>

            <div>
                <h2 class="text-3xl font-bold">{{ $title }}</h2>
                <p class="text-sm mt-1">{{ now()->format('l, F d, Y') }}</p>
            </div>
        </div>
        @if (!empty($tabs))
            <!-- Tab Navigation -->
            <div class="flex space-x-2">
                @foreach ($tabs as $tab)
                    <button wire:click="setActiveTab('{{ $tab['key'] }}')"
                            class="{{ $activeTab === $tab['key'] ? 'bg-theme-primary text-theme-white' : 'bg-gray-200 text-theme-primary' }} px-6 py-2 rounded-md font-semibold transition-all duration-300 hover:bg-gray-100 hover:text-theme-primary focus:outline-none focus:ring-2 focus:ring-theme-secondary border border-theme-primary border-2">
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>