@props([
    'type' => 'success', // Tipe alert: 'success' atau 'error'
    'message' => null // Pesan alert dari session
])

@if ($message)
    <div class="p-4 rounded border-2 border-theme-primary {{ $type === 'success' ? 'bg-green-100 border-l-4 border-green-500 text-green-700' : 'bg-red-100 border-l-4 border-red-500 text-red-700' }}">
        {{ $message }}
    </div>
@endif