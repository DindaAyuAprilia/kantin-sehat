@props([
    'title' => 'Default Title',
    'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
])

<div class="bg-theme-surface rounded-lg shadow-lg border border-theme-primary">
    <h3 class="text-2xl font-semibold text-theme-black bg-theme-light rounded-t-lg px-4 py-3 flex items-center space-x-3 border-b border-theme-primary">
        <svg class="w-6 h-6 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
        <span>{{ $title }}</span>
    </h3>
    <div class="p-4">
        {{ $slot }}
    </div>
</div>