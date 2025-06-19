@props([
    'label' => '',
    'name' => '',
    'model' => '',
    'options' => [],
    'icon' => null,
    'placeholder' => 'Pilih opsi',
    'show' => true
])

<div x-show="{{ $show }}">
    <label for="{{ $name }}" class="block text-sm font-medium text-theme-black">{{ $label }}</label>
    <div class="mt-1 relative rounded-md shadow-sm border border-gray-300">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    {!! $icon !!}
                </svg>
            </div>
        @endif
        <select 
            wire:model="{{ $model }}" 
            id="{{ $name }}" 
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-theme-primary focus:ring-theme-primary focus:ring-opacity-50 text-sm {{ $icon ? 'pl-10' : '' }}"
        >
            <option value="">{{ $placeholder }}</option>
            @foreach($options as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>
    @error($model) <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
</div>