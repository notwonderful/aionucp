<div class="bg-slate-900 mb-10 mt-24 p-4 relative text-center rounded-2xl text-white" id="sidebar_bottom_wizard">
    <img src="{{ asset('dashboard/images/all-img/membership.webp') }}" alt="" class="mx-auto relative -mt-[73px]">
    <div class="max-w-[160px] mx-auto mt-6">
        <div class="widget-title font-Inter mb-1">{{ __('Membership') }}</div>
        <div class="text-xs font-light font-Inter">
            {{ __('Upgrade your account to get more in-game features') }}
        </div>
    </div>
    <div class="mt-6">
        <a href="{{ route('membership') }}" class="bg-white hover:bg-opacity-80 text-slate-900 text-sm font-Inter rounded-md w-full block py-2 font-medium">
            {{ __('Upgrade') }}
        </a>
    </div>
</div>
