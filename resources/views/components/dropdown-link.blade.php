<li>
    <a {{ $attributes->merge(['class' => 'block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal']) }}>
        <iconify-icon icon="{{ $icon }}" class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
        <span class="font-Inter">{{ $slot }}</span>
    </a>
</li>
