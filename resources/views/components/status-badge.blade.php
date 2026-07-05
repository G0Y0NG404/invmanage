@props(['status'])

@php
    $classes = match($status) {
        'Deployed' => 'bg-blue-100 text-blue-800 border-blue-300',
        'In-Warehouse' => 'bg-green-100 text-green-800 border-green-300',
        'Under Repair' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
        'Decommissioned' => 'bg-red-100 text-red-800 border-red-300',
        default => 'bg-gray-100 text-gray-800 border-gray-300',
    };
@endphp

<span class="inline-block px-2 py-0.5 text-[10px] font-semibold border rounded {{ $classes }}">
    {{ $status }}
</span>
