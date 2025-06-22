@props([
    'title' => 'Default Title',
    'icon' => null,
])

<h3 class="p-3 text-xl font-[500] text-white bg-theme-primary rounded-t-lg flex items-center border-b border-theme-primary">
        <svg class="w-6 h-6 p-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
        <span class="px-3">{{ $title }}</span>
    </h3>
    <div class="p-2">
        {{ $slot }}
    </div>
</h3>