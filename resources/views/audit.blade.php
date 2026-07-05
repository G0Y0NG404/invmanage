<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/audit.css') }}">
</head>
<body class="bg-[#121212] text-[#ccc] min-h-screen flex font-sans">

<x-sidebar-overlay />
<x-sidebar :current="'audit'" />

<div class="ml-[200px] flex-1 p-5 max-md:ml-0 max-md:p-3.5 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="hidden max-md:block bg-none border-none text-white text-[22px] cursor-pointer">&#9776;</button>
            <h1 class="text-lg font-bold text-black"><span class="text-black"> AUDIT / REPORTING</h1>
        </div>

    </div>

    @if (session('success'))
        <div class="bg-[#081a08] border border-[#0f2a0f] px-4 py-2.5 text-sm text-black mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" class="flex items-end gap-2 mb-4 max-md:flex-col max-md:items-stretch">
        <div class="flex-1">
            <label class="block text-xs font-semibold text-black mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, serial, NSN, personnel..." class="w-full px-3 py-2 bg-white border border-[#ccc] text-black text-sm outline-none focus:border-[#003366]">
        </div>
        <div class="w-[180px] max-md:w-full">
            <label class="block text-xs font-semibold text-black mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 bg-white border border-[#ccc] text-black text-sm outline-none focus:border-[#003366]">
                <option value="">All Status</option>
                <option value="Deployed" {{ request('status') === 'Deployed' ? 'selected' : '' }}>Deployed</option>
                <option value="In-Warehouse" {{ request('status') === 'In-Warehouse' ? 'selected' : '' }}>In-Warehouse</option>
                <option value="Under Repair" {{ request('status') === 'Under Repair' ? 'selected' : '' }}>Under Repair</option>
                <option value="Decommissioned" {{ request('status') === 'Decommissioned' ? 'selected' : '' }}>Decommissioned</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-[#003366] text-white text-sm font-bold border border-[#002244] cursor-pointer font-sans whitespace-nowrap">Filter</button>
        @if (request('search') || request('status'))
            <a href="{{ route('audit') }}" class="px-4 py-2 bg-gray-200 text-black text-sm font-bold border border-gray-300 no-underline cursor-pointer text-center whitespace-nowrap">Clear</a>
        @endif
        <a href="{{ route('audit.export.csv') }}" class="px-4 py-2 bg-green-700 text-white text-sm font-bold border border-green-800 no-underline cursor-pointer text-center whitespace-nowrap">Export CSV</a>
    </form>

    <div class="flex border border-[#1f1f1f] mb-5 max-md:flex-col">
        <div class="flex-1 py-3.5 px-4 text-center border-r border-[#1f1f1f] max-md:border-r-0 max-md:border-b max-md:border-[#1f1f1f]">
            <span class="block text-[10px] text-black mb-1">TOTAL ITEMS</span>
            <span class="block text-2xl font-bold text-black">{{ number_format($totalQty) }}</span>
        </div>
        <div class="flex-1 py-3.5 px-4 text-center border-r border-[#1f1f1f] max-md:border-r-0 max-md:border-b max-md:border-[#1f1f1f]">
            <span class="block text-[10px] text-black mb-1">DEPLOYED</span>
            <span class="block text-2xl font-bold text-black">{{ number_format($deployed) }}</span>
        </div>
        <div class="flex-1 py-3.5 px-4 text-center border-r border-[#1f1f1f] max-md:border-r-0 max-md:border-b max-md:border-[#1f1f1f]">
            <span class="block text-[10px] text-black mb-1">IN-WAREHOUSE</span>
            <span class="block text-2xl font-bold text-black">{{ number_format($inWarehouse) }}</span>
        </div>
        <div class="flex-1 py-3.5 px-4 text-center border-r border-[#1f1f1f] max-md:border-r-0 max-md:border-b max-md:border-[#1f1f1f]">
            <span class="block text-[10px] text-black mb-1">UNDER REPAIR</span>
            <span class="block text-2xl font-bold text-black">{{ number_format($underRepair) }}</span>
        </div>
        <div class="flex-1 py-3.5 px-4 text-center">
            <span class="block text-[10px] text-black mb-1">DECOMMISSIONED</span>
            <span class="block text-2xl font-bold text-black">{{ number_format($decommissioned) }}</span>
        </div>
    </div>

    <div class="bg-white border border-[#1f1f1f]">
        <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black"><span class="text-black"></span> Master Inventory List</div>
        <div class="p-0">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Item</th>
                        <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Serial</th>
                        <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Status</th>
                        <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Location</th>
                        <th class="text-right px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="hover:bg-[#080808]">
                            <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black">{{ $item->name }}</td>
                            <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->serial_number ?? '--' }}</td>
                            <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black">
                                <x-status-badge :status="$item->status" />
                            </td>
                            <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->location_battalion ?? '--' }}</td>
                            <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-right">{{ $item->quantity }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-5 text-center text-black text-sm">No equipment in the system.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if (method_exists($items, 'links'))
        <div class="mt-[18px]">{{ $items->links('vendor.pagination.default') }}</div>
    @endif
</div>

</body>
</html>
