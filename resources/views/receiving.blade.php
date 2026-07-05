<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiving</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/receiving.css') }}">
</head>
<body class="bg-[#121212] text-[#ccc] min-h-screen flex font-sans">

<x-sidebar-overlay />
<x-sidebar :current="'receiving'" />

@php $categories = App\Models\Category::orderBy('name')->get(); @endphp

<div class="ml-[200px] flex-1 p-5 max-md:ml-0 max-md:p-3.5 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="hidden max-md:block bg-none border-none text-white text-[22px] cursor-pointer">&#9776;</button>
            <h1 class="text-lg font-bold text-black"><span class="text-black">RECEIVING</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-[#081a08] border border-[#0f2a0f] px-4 py-2.5 text-sm text-black mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-[#1f1f1f]">
        <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black"><span class="text-black"></span> New Equipment Entry</div>
        <div class="p-4">
            <form method="POST" action="{{ route('receiving.store') }}">
                @csrf

                <div class="grid grid-cols-2 gap-3.5 max-md:grid-cols-1">
                    <div class="mb-3">
                        <label for="name" class="block text-xs font-semibold text-black mb-1">Equipment Name *</label>
                        <input type="text" id="name" name="name" required class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]" placeholder="Enter equipment name">
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="block text-xs font-semibold text-black mb-1">Category</label>
                        <select id="category_id" name="category_id" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="serial_number" class="block text-xs font-semibold text-black mb-1">Serial Number</label>
                        <input type="text" id="serial_number" name="serial_number" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="nsn" class="block text-xs font-semibold text-black mb-1">Specific Name / Model</label>
                        <input type="text" id="nsn" name="nsn" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="date_acquired" class="block text-xs font-semibold text-black mb-1">Date Acquired</label>
                        <input type="date" id="date_acquired" name="date_acquired" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="warranty_status" class="block text-xs font-semibold text-black mb-1">Warranty</label>
                        <select id="warranty_status" name="warranty_status" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                            <option value="">-- Select Warranty --</option>
                            <option value="Under Warranty">Under Warranty</option>
                            <option value="Expired">Expired</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="block text-xs font-semibold text-black mb-1">Status *</label>
                        <select id="status" name="status" required class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                            <option value="In-Warehouse">In-Warehouse</option>
                            <option value="Deployed">Deployed</option>
                            <option value="Under Repair">Under Repair</option>
                            <option value="Decommissioned">Decommissioned</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="block text-xs font-semibold text-black mb-1">Quantity *</label>
                        <input type="number" id="quantity" name="quantity" min="1" required class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="location_battalion" class="block text-xs font-semibold text-black mb-1">Battalion / Company</label>
                        <input type="text" id="location_battalion" name="location_battalion" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="location_storage" class="block text-xs font-semibold text-black mb-1">Storage Locker</label>
                        <input type="text" id="location_storage" name="location_storage" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="assigned_personnel" class="block text-xs font-semibold text-black mb-1">Assigned Personnel</label>
                        <input type="text" id="assigned_personnel" name="assigned_personnel" class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="px-6 py-2.5 bg-[#003366] text-white font-bold text-sm border border-[#002244] cursor-pointer font-sans">ADD EQUIPMENT</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
