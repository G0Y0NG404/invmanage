<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issuance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/issuance.css') }}">
</head>
<body class="bg-[#121212] text-[#ccc] min-h-screen flex font-sans">

<x-sidebar-overlay />
<x-sidebar :current="'issuance'" />

<div class="ml-[200px] flex-1 p-5 max-md:ml-0 max-md:p-3.5 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="hidden max-md:block bg-none border-none text-white text-[22px] cursor-pointer">&#9776;</button>
            <h1 class="text-lg font-bold text-black"><span class="text-black">ISSUANCE / <span class="text-black">DEPLOYMENT</h1>
        </div>

    </div>

    @if (session('success'))
        <div class="bg-[#081a08] border border-[#0f2a0f] px-4 py-2.5 text-sm text-black mb-4">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="bg-[#1a0808] text-black px-3.5 py-2.5 mb-4 text-sm border border-[#2a0f0f]">{{ $errors->first() }}</div>
    @endif

    <div class="bg-white border border-[#1f1f1f]">
        <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black"><span class="text-black"></span> Check Out Equipment</div>
        <div class="p-4">
            <form method="POST" action="{{ route('issuance.checkout') }}">
                @csrf

                <div class="grid grid-cols-2 gap-3.5 max-md:grid-cols-1">
                    <div class="mb-3">
                        <label for="item_id" class="block text-xs font-semibold text-black mb-1">Equipment *</label>
                        <select id="item_id" name="item_id" required class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                            <option value="">-- Select --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->serial_number ?? 'no SN' }}) &mdash; Qty: {{ $item->quantity }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="block text-xs font-semibold text-black mb-1">Quantity *</label>
                        <input type="number" id="quantity" name="quantity" min="1" required class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="assigned_personnel" class="block text-xs font-semibold text-black mb-1">Assigned Personnel *</label>
                        <input type="text" id="assigned_personnel" name="assigned_personnel" required class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                    <div class="mb-3">
                        <label for="location_battalion" class="block text-xs font-semibold text-black mb-1">Battalion / Company *</label>
                        <input type="text" id="location_battalion" name="location_battalion" required class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#1f1f1f] text-black text-sm outline-none focus:border-[#003366]">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="px-6 py-2.5 bg-[#003366] text-white font-bold text-sm border border-[#002244] cursor-pointer font-sans">CHECK OUT</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
