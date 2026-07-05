<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tracking.css') }}">
</head>
<body class="bg-[#121212] text-[#ccc] min-h-screen flex font-sans">

<x-sidebar-overlay />
<x-sidebar :current="'tracking'" />

<div class="ml-[200px] flex-1 p-5 max-md:ml-0 max-md:p-3.5 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="hidden max-md:block bg-none border-none text-white text-[22px] cursor-pointer">&#9776;</button>
            <h1 class="text-lg font-bold text-black"><span class="text-black">TRACKING</h1>
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
            <a href="{{ route('tracking') }}" class="px-4 py-2 bg-gray-200 text-black text-sm font-bold border border-gray-300 no-underline cursor-pointer text-center whitespace-nowrap">Clear</a>
        @endif
    </form>

    <div class="bg-[#003366] border border-[#002244]">
        <div class="px-4 py-3 border-b border-[#002244] text-sm font-semibold text-white"><span class="text-white"></span> All Equipment</div>
        <div class="p-0 bg-white">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Name</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Serial</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Status</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Location</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Personnel</th>
                        <th class="text-right px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Qty</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-black border-b border-[#1f1f1f] font-semibold"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="hover:bg-[#e8f0fe]">
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black">{{ $item->name }}</td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->serial_number ?? '--' }}</td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black">
                                <x-status-badge :status="$item->status" />
                            </td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->location_battalion ?? '--' }}</td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->assigned_personnel ?? '--' }}</td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-right">{{ $item->quantity }}</td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black align-top">
                                <div class="flex items-center gap-1.5 mb-1.5">
                                    <a href="{{ route('tracking.edit', $item) }}" class="text-black text-[11px] font-semibold no-underline cursor-pointer hover:underline">Edit</a>
                                    <span class="text-black text-[11px]">|</span>
                                    <a href="#" onclick="event.preventDefault();document.getElementById('move-{{ $item->id }}').style.display='flex';this.style.display='none';" class="text-black text-[11px] font-semibold no-underline cursor-pointer hover:underline">Move</a>
                                    <span class="text-black text-[11px]">|</span>
                                    <form method="POST" action="{{ route('tracking.destroy', $item) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" data-confirm="Delete this item?" class="text-black text-[11px] font-semibold bg-none border-none cursor-pointer font-sans hover:underline">Delete</button>
                                    </form>
                                </div>
                                <form id="move-{{ $item->id }}" method="POST" action="{{ route('tracking.update', $item) }}" class="flex-col gap-1 hidden" style="display:none;">
                                    @csrf
                                    <select name="status" class="px-2 py-1 text-[11px] bg-[#0a0a0a] border border-[#1f1f1f] text-black font-sans outline-none focus:border-[#003366]">
                                        <option value="In-Warehouse">In-Warehouse</option>
                                        <option value="Deployed">Deployed</option>
                                        <option value="Under Repair">Under Repair</option>
                                        <option value="Decommissioned">Decommissioned</option>
                                    </select>
                                    <input type="text" name="location_battalion" class="px-2 py-1 text-[11px] bg-[#0a0a0a] border border-[#1f1f1f] text-black font-sans outline-none focus:border-[#003366]" placeholder="Battalion">
                                    <input type="text" name="assigned_personnel" class="px-2 py-1 text-[11px] bg-[#0a0a0a] border border-[#1f1f1f] text-black font-sans outline-none focus:border-[#003366]" placeholder="Personnel">
                                    <button type="submit" class="px-2.5 py-1 bg-[#003366] text-white border border-[#002244] text-[11px] font-semibold cursor-pointer font-sans">Save</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-3.5 py-5 text-center text-black text-sm">No equipment in the system.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if (method_exists($items, 'links'))
        <div class="mt-[18px]">{{ $items->links('vendor.pagination.default') }}</div>
    @endif

    @if ($trashed->isNotEmpty())
        <div class="bg-[#1a0808] border border-[#2a0f0f] mt-5">
            <div class="px-4 py-3 border-b border-[#2a0f0f] text-sm font-semibold text-black">Recently Deleted ({{ $trashed->count() }})</div>
            <div class="p-0 bg-white">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Name</th>
                            <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Serial</th>
                            <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Deleted</th>
                            <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashed as $item)
                            <tr class="hover:bg-[#e8f0fe] opacity-60">
                                <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black">{{ $item->name }}</td>
                                <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->serial_number ?? '--' }}</td>
                                <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->deleted_at->diffForHumans() }}</td>
                                <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black">
                                    <form method="POST" action="{{ route('tracking.restore', $item) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 bg-[#003366] text-white border border-[#002244] text-[11px] font-semibold cursor-pointer font-sans">Restore</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
