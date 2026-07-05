<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/maintenance.css') }}">
</head>
<body class="bg-[#121212] text-[#ccc] min-h-screen flex font-sans">

<x-sidebar-overlay />
<x-sidebar :current="'maintenance'" />

<div class="ml-[200px] flex-1 p-5 max-md:ml-0 max-md:p-3.5 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="hidden max-md:block bg-none border-none text-white text-[22px] cursor-pointer">&#9776;</button>
            <h1 class="text-lg font-bold text-black"><span class="text-black">MAINTENANCE</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-[#081a08] border border-[#0f2a0f] px-4 py-2.5 text-sm text-black mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-[#1f1f1f]">
        <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black"><span class="text-black"></span> Items Needing Attention</div>
        <div class="p-0">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Item</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Serial</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Warranty</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Status</th>
                        <th class="text-left px-3.5 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="hover:bg-[#080808]">
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black">{{ $item->name }}</td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black text-[11px]">{{ $item->serial_number ?? '--' }}</td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black">
                                <span class="inline-block px-2 py-0.5 text-[10px] font-semibold border bg-[#003366] text-white border-[#002244]">{{ $item->warranty_status ?? 'N/A' }}</span>
                            </td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black">
                                <span class="inline-block px-2 py-0.5 text-[10px] font-semibold border bg-[#003366] text-white border-[#002244]">{{ $item->status }}</span>
                            </td>
                            <td class="px-3.5 py-2.5 text-sm border-b border-[#0a0a0a] text-black align-top">
                                <a href="#" onclick="event.preventDefault();document.getElementById('repair-{{ $item->id }}').style.display='flex';this.style.display='none';" class="text-black text-[11px] font-semibold no-underline cursor-pointer hover:underline">Update</a>
                                <form id="repair-{{ $item->id }}" method="POST" action="{{ route('tracking.update', $item) }}" class="mt-1.5 flex-col gap-1 hidden" style="display:none;">
                                    @csrf
                                    <select name="status" class="px-2 py-1 text-[11px] bg-[#0a0a0a] border border-[#1f1f1f] text-black font-sans outline-none focus:border-[#003366]">
                                        <option value="Under Repair">Under Repair</option>
                                        <option value="In-Warehouse">In-Warehouse (Repaired)</option>
                                        <option value="Decommissioned">Decommissioned</option>
                                    </select>
                                    <button type="submit" class="px-2.5 py-1 bg-[#003366] text-white border border-[#002244] text-[11px] font-semibold cursor-pointer font-sans">Save</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3.5 py-5 text-center text-black text-sm">No items needing maintenance.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
