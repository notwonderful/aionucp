<div class="sidebar-wrapper group">
    <div id="bodyOverlay"
         class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden"></div>
    <div class="logo-segment">

        <x-application-logo />

        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200"
                          icon="fa-regular:dot-circle"></iconify-icon>
            <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200"
                          icon="material-symbols:circle-outline"></iconify-icon>
        </div>
        <button class="sidebarCloseIcon text-2xl">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>
    <div id="nav_shadow" class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
      opacity-0"></div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50"
         id="sidebar_menus">
        <ul class="sidebar-menu">

            <li class="sidebar-menu-title">{{ __('Dashboard') }}</li>

            <x-sidebar-link route="dashboard" icon="heroicons-outline:home">
                {{ __('Home') }}
            </x-sidebar-link>

            <li>
                <a href="javascript:void(0)" class="navItem">
                  <span class="flex items-center">
                    <iconify-icon class=" nav-icon" icon="heroicons-outline:arrow-trending-up"></iconify-icon>
                    <span>{{ __('Rating') }}</span>
                  </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul class="sidebar-submenu" style="display: none;">
                    <li>
                        <a href="{{ route('rating.abyss') }}">{{ __('Abyss') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('rating.legion') }}">{{ __('Legions') }}</a>
                    </li>
                </ul>
            </li>

            <x-sidebar-link route="donate" icon="heroicons-outline:credit-card">
                {{ __('Donate') }}
            </x-sidebar-link>

            <x-sidebar-link route="shop.index" icon="heroicons-outline:shopping-cart">
                {{ __('Shop') }}
            </x-sidebar-link>

            <x-sidebar-link route="membership" icon="heroicons-outline:users">
                {{ __('Membership') }}
            </x-sidebar-link>

            <x-sidebar-link route="referral.index" icon="heroicons-outline:user-plus">
                {{ __('Referral Program') }}
            </x-sidebar-link>

            @can('admin')
                <x-sidebar-link route="admin.index" icon="heroicons-outline:cog-6-tooth">
                    {{ __('Admin Panel') }}
                </x-sidebar-link>
            @endcan
        </ul>

        @include('partials.dashboard.cards.membership')
    </div>
</div>
