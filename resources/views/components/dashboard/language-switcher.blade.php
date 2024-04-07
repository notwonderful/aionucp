<div class="relative">
    <button class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center
                inline-flex items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <iconify-icon icon="circle-flags:{{ app()->getLocale() }}" class="mr-0 md:mr-2 rtl:ml-2 text-xl"></iconify-icon>
    </button>
    <div class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-900 !top-[25px] rounded-md
                overflow-hidden">
        <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
            <li>
                <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white">
                    <iconify-icon icon="circle-flags:uk" class="ltr:mr-2 rtl:ml-2 text-xl"></iconify-icon>
                    <span class="font-medium">English</span>
                </a>
            </li>
            <li>
                <a href="{{ route('lang.switch', ['locale' => 'ru']) }}" class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white">
                    <iconify-icon icon="emojione:flag-for-russia" class="ltr:mr-2 rtl:ml-2 text-xl"></iconify-icon>
                    <span class="font-medium">Русский</span>
                </a>
            </li>
        </ul>
    </div>
</div>
