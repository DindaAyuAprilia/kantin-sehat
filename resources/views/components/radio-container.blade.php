@props([
    'label' => '',
    'name' => '',
    'model' => '',
    'options' => [],
    'show' => true
])

<div x-show="{{ $show }}">
    <label class="block text-sm font-medium text-theme-black">{{ $label }}</label>
    <div class="mt-1 space-x-6">
        @foreach($options as $value => $option)
            <label class="inline-flex items-center">
                <input 
                    type="radio" 
                    wire:model="{{ $model }}" 
                    value="{{ $value }}" 
                    class="form-radio text-theme-primary focus:ring-theme-secondary"
                    {{ $option['attributes'] ?? '' }}
                >
                <span class="ml-2 text-sm text-theme-black">{{ $option['label'] }}</span>
            </label>
        @endforeach
    </div>
    @error($model) <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
</div>