@props(['current' => 'dashboard'])

<aside id="sidebar" class="w-[200px] bg-[#0a0a0a] border-r border-[#1f1f1f] min-h-screen flex flex-col fixed top-0 left-0 z-[100] transition-transform duration-300 max-md:-translate-x-full">
    <div class="p-4 border-b border-[#1f1f1f]">
        <img src="{{ asset('/images/signal.png') }}" alt="Logo" class="w-[140px] h-auto block">
    </div>
    <nav class="flex-1 py-2">
        <x-sidebar-link href="{{ route('dashboard') }}" :active="$current === 'dashboard'" icon="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z">Dashboard</x-sidebar-link>
        <x-sidebar-link href="{{ route('receiving') }}" :active="$current === 'receiving'" icon="M5 5h2v2H5zm0 4h2v2H5zm0 4h2v2H5zm0 4h2v2H5zm4-12h12v2H9zm0 4h12v2H9zm0 4h12v2H9zm0 4h12v2H9z">Receiving</x-sidebar-link>
        <x-sidebar-link href="{{ route('tracking') }}" :active="$current === 'tracking'" icon="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H4V4h16v16zM6 6h12v2H6zm0 4h12v2H6zm0 4h8v2H6z">Tracking</x-sidebar-link>
        <x-sidebar-link href="{{ route('maintenance') }}" :active="$current === 'maintenance'" icon="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z">Maintenance</x-sidebar-link>
        <x-sidebar-link href="{{ route('issuance') }}" :active="$current === 'issuance'" icon="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z">Issuance</x-sidebar-link>
        <x-sidebar-link href="{{ route('audit') }}" :active="$current === 'audit'" icon="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z">Audit</x-sidebar-link>

    </nav>
    <div class="p-3 border-t border-[#1f1f1f] relative">
        <button id="profileBtn" class="flex items-center gap-2 text-[#555] text-xs w-full hover:text-white cursor-pointer bg-none border-none font-sans text-left">
            <div class="w-7 h-7 bg-[#1a1a1a] flex items-center justify-center text-xs text-[#FF8C00] font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <span class="flex-1">{{ auth()->user()->name }}</span>
            <svg class="w-3 h-3 fill-current transition-transform" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
        </button>
        <div id="profileDropdown" class="absolute bottom-full left-2 right-2 mb-2 bg-[#0d0d0d] border border-[#1f1f1f] shadow-lg hidden">
            <a href="{{ route('profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs text-[#ccc] hover:bg-[#111] no-underline border-b border-[#1f1f1f]">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                Profile Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2.5 text-xs text-[#ccc] hover:bg-[#111] w-full text-left cursor-pointer bg-none border-none font-sans">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
