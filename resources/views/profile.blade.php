<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body class="min-h-screen flex font-sans">

<div id="sidebarOverlay" class="fixed inset-0 z-[99] hidden"></div>

<x-sidebar :current="'profile'" />

<div class="ml-[200px] flex-1 p-5 max-md:ml-0 max-md:p-3.5 min-h-screen">
    <x-sidebar-overlay />
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="hidden max-md:block bg-none border-none text-black text-[22px] cursor-pointer">&#9776;</button>
            <h1 class="text-lg font-bold text-black"><span class="text-black">PROFILE SETTINGS</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-[#081a08] border border-[#0f2a0f] px-4 py-2.5 text-sm text-black mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-[1fr_1.5fr] gap-4 max-lg:grid-cols-1">
        <div class="space-y-4">
            <div class="bg-white border border-[#1f1f1f]">
                <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black">Account Info</div>
                <div class="p-4 space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-black mb-1">Name</label>
                        <div class="px-3 py-2 bg-white border border-[#ccc] text-black text-sm">{{ auth()->user()->name }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-black mb-1">Email</label>
                        <div class="px-3 py-2 bg-white border border-[#ccc] text-black text-sm">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-[#1f1f1f]">
                <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black">System Info</div>
                <div class="p-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-black">Laravel</span><span class="text-black">{{ $laravelVersion }}</span></div>
                    <div class="flex justify-between"><span class="text-black">PHP</span><span class="text-black">{{ $phpVersion }}</span></div>
                    <div class="flex justify-between"><span class="text-black">Database</span><span class="text-black">{{ strtoupper($dbConnection) }}</span></div>
                    <div class="flex justify-between"><span class="text-black">Last Login</span><span class="text-black">{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('M d, Y h:i A') : 'N/A' }}</span></div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full px-5 py-2.5 bg-[#1a0808] text-white font-bold text-sm border border-[#2a0f0f] cursor-pointer font-sans hover:bg-[#2a0f0f]">Logout</button>
            </form>
        </div>

        <div class="bg-white border border-[#1f1f1f]">
            <div class="px-4 py-3 border-b border-[#1f1f1f] text-sm font-semibold text-black">Activity Log</div>
            <div class="max-h-[400px] overflow-y-auto">
                @forelse ($logs as $log)
                    <div class="flex items-start gap-3 px-4 py-2.5 border-b border-[#1f1f1f] last:border-b-0">
                        <span class="text-[11px] text-black whitespace-nowrap min-w-[80px]">{{ $log->created_at->format('m/d H:i') }}</span>
                        <span class="text-[11px] font-semibold text-black whitespace-nowrap min-w-[90px]">{{ $log->action }}</span>
                        <span class="text-[12px] text-black">{{ $log->description }}</span>
                    </div>
                @empty
                    <div class="px-4 py-5 text-center text-black text-sm">No activity recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
