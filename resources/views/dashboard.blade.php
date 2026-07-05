<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="bg-[#121212] text-[#ccc] min-h-screen flex font-sans">

<x-sidebar-overlay />
<x-sidebar :current="'dashboard'" />

<div class="ml-[200px] flex-1 p-5 max-md:ml-0 max-md:p-3.5 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="hidden max-md:block bg-none border-none text-white text-[22px] cursor-pointer">&#9776;</button>
            <h1 class="text-lg font-bold text-black"><span class="text-black">DASHBOARD</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-[#081a08] border border-[#0f2a0f] px-4 py-2.5 text-sm text-black mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-4 gap-3 mb-5 max-lg:grid-cols-2 max-md:grid-cols-1">
        <div class="bg-white border border-[#1f1f1f] p-[18px]">
            <div class="text-[11px] text-black mb-1.5">Total Active Units</div>
            <div class="text-[28px] font-bold text-black">{{ number_format($totalActive) }}</div>
            <div class="flex gap-3 mt-1.5 text-[11px]">
                @foreach ($catBreakdown as $name => $qty)
                    <span class="text-black">{{ $name }}: <strong class="text-black">{{ $qty }}</strong></span>
                @endforeach
            </div>
        </div>
        <div class="bg-white border border-[#1f1f1f] p-[18px]">
            <div class="text-[11px] text-black mb-1.5">Items in Field</div>
            <div class="text-[28px] font-bold text-black">{{ number_format($deployed) }}</div>
            <div class="text-[11px] text-black mt-1">Deployed</div>
        </div>
        <div class="bg-white border border-[#1f1f1f] p-[18px]">
            <div class="text-[11px] text-black mb-1.5">Items in Repair</div>
            <div class="text-[28px] font-bold text-black">{{ number_format($inRepair) }}</div>
            <div class="text-[11px] text-black mt-1">Maintenance</div>
        </div>
        <div class="bg-white border border-[#1f1f1f] p-[18px]">
            <div class="text-[11px] text-black mb-1.5">Low Stock Alerts</div>
            <div class="text-[28px] font-bold text-black">{{ $lowStock }}</div>
            <div class="text-[11px] text-black mt-1">Critical</div>
        </div>
    </div>

    <div class="bg-white border border-[#1f1f1f]">
        <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black">High-Priority Items</div>
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Asset Name</th>
                    <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Category</th>
                    <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Status</th>
                    <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Last Update</th>
                    <th class="text-left px-4 py-2.5 text-xs text-white border-b border-[#1f1f1f] font-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($priorityItems as $item)
                    <tr class="hover:bg-[#080808]">
                        <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black">{{ $item->name }}</td>
                        <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black">{{ $item->category->name ?? '--' }}</td>
                        <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black">
                            <x-status-badge :status="$item->status" />
                        </td>
                        <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black">{{ $item->updated_at->diffForHumans() }}</td>
                        <td class="px-4 py-2.5 text-sm border-b border-[#0a0a0a] text-black">
                            <a href="{{ route('issuance') }}" class="inline-block px-2.5 py-1 text-[11px] font-semibold text-white bg-[#003366] no-underline cursor-pointer border border-[#002244] font-sans">Quick Issue</a>
                            @if ($item->status === 'Under Repair')
                                <form method="POST" action="{{ route('tracking.update', $item) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="In-Warehouse">
                                    <button type="submit" class="inline-block px-2.5 py-1 text-[11px] font-semibold text-white bg-[#003366] border border-[#002244] cursor-pointer font-sans">Mark Repaired</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-5 text-center text-black text-sm">All items are in good condition.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
