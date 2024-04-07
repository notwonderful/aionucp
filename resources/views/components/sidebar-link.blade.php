@props(['route', 'icon', 'active'])

@php
    $isActive = request()->routeIs($route);
@endphp

<li>
    <a {{ $attributes->merge(['class' => 'navItem ' . ($isActive ? 'active' : '')]) }} href="{{ route($route) }}">
        <span class="flex items-center">
            <iconify-icon class="nav-icon" icon="{{ $icon }}"></iconify-icon>
            <span>{{ $slot }}</span>
        </span>
    </a>
</li>
