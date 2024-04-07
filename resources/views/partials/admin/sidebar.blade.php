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
            <x-sidebar-link route="admin.index" icon="heroicons-outline:home">
                {{ __('Home') }}
            </x-sidebar-link>
            <li class="">
                <a href="javascript:void(0)" class="navItem">
                  <span class="flex items-center">
                    <iconify-icon class=" nav-icon" icon="heroicons-outline:credit-card"></iconify-icon>
                    <span>{{ __('Shop') }}</span>
                  </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul class="sidebar-submenu" style="display: none;">
                    <li>
                        <a href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a>
                    </li>
                </ul>
            </li>
            <x-sidebar-link route="admin.users.index" icon="heroicons-outline:users">
                {{ __('Users') }}
            </x-sidebar-link>

            <x-sidebar-link route="admin.mail-items.index" icon="heroicons-outline:envelope">
                {{ __('Mail Items') }}
            </x-sidebar-link>
        </ul>
    </div>
</div>
