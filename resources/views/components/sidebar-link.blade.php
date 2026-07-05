@props(['href', 'active' => false, 'icon'])

<a href="{{ $href }}" @class([
    'flex items-center gap-2 px-4 py-2.5 text-sm hover:text-white hover:bg-[#111] border-l-2 transition-colors',
    'text-[#FF8C00] bg-[#111] border-[#FF8C00]' => $active,
    'text-[#555] border-transparent' => !$active,
])>
    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
    {{ $slot }}
</a>
