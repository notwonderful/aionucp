<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shop') }}
        </h2>
    </x-slot>

    <div x-data="{ open: false }" @keydown.window.escape="open = false" class="bg-white">
        <!-- Mobile menu -->

        <div x-show="open" class="fixed inset-0 flex z-40 lg:hidden" x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." x-ref="dialog" aria-modal="true">

            <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state." class="fixed inset-0 bg-black bg-opacity-25" @click="open = false" aria-hidden="true">
            </div>


            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-description="Off-canvas menu, show/hide based on off-canvas menu state." class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto">
                <div class="px-4 pt-5 pb-2 flex">
                    <button type="button" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-gray-400" @click="open = false">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Links -->
                <div class="mt-2" x-data="Components.tabs()" @tab-click.window="onTabClick" @tab-keydown.window="onTabKeydown">
                    <div class="border-b border-gray-200">
                        <div class="-mb-px flex px-4 space-x-8" aria-orientation="horizontal" role="tablist">

                            <button id="tabs-1-tab-1" class="text-gray-900 border-transparent flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium" x-state:on="Selected" x-state:off="Not Selected" :class="{ 'text-indigo-600 border-indigo-600': selected, 'text-gray-900 border-transparent': !(selected) }" x-data="Components.tab(0)" aria-controls="tabs-1-panel-1" role="tab" x-init="init()" @click="onClick" @keydown="onKeydown" @tab-select.window="onTabSelect" :tabindex="selected ? 0 : -1" :aria-selected="selected ? 'true' : 'false'" type="button">
                                Women
                            </button>

                            <button id="tabs-1-tab-2" class="text-gray-900 border-transparent flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium" x-state:on="Selected" x-state:off="Not Selected" :class="{ 'text-indigo-600 border-indigo-600': selected, 'text-gray-900 border-transparent': !(selected) }" x-data="Components.tab(0)" aria-controls="tabs-1-panel-2" role="tab" x-init="init()" @click="onClick" @keydown="onKeydown" @tab-select.window="onTabSelect" :tabindex="selected ? 0 : -1" :aria-selected="selected ? 'true' : 'false'" type="button">
                                Men
                            </button>

                        </div>
                    </div>


                    <div id="tabs-1-panel-1" class="pt-10 pb-8 px-4 space-y-10" x-description="'Women' tab panel, show/hide based on tab state." x-data="Components.tabPanel(0)" aria-labelledby="tabs-1-tab-1" x-init="init()" x-show="selected" @tab-select.window="onTabSelect" role="tabpanel" tabindex="0">
                        <div class="space-y-4">

                            <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden">
                                <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg" alt="Models sitting back to back, wearing Basic Tee in black and bone." class="object-center object-cover group-hover:opacity-75">
                                <div class="flex flex-col justify-end">
                                    <div class="p-4 bg-white bg-opacity-60 text-base sm:text-sm">
                                        <a href="#" class="font-medium text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            New Arrivals
                                        </a>
                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                    </div>
                                </div>
                            </div>

                            <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden">
                                <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg" alt="Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees." class="object-center object-cover group-hover:opacity-75">
                                <div class="flex flex-col justify-end">
                                    <div class="p-4 bg-white bg-opacity-60 text-base sm:text-sm">
                                        <a href="#" class="font-medium text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Basic Tees
                                        </a>
                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                    </div>
                                </div>
                            </div>

                            <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden">
                                <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-03.jpg" alt="Model wearing minimalist watch with black wristband and white watch face." class="object-center object-cover group-hover:opacity-75">
                                <div class="flex flex-col justify-end">
                                    <div class="p-4 bg-white bg-opacity-60 text-base sm:text-sm">
                                        <a href="#" class="font-medium text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Accessories
                                        </a>
                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-y-10">

                            <div>
                                <p id="women-shoes-heading-mobile" class="font-medium text-gray-900">
                                    Shoes &amp; Accessories
                                </p>
                                <ul role="list" aria-labelledby="women-shoes-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sneakers
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Boots
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Flats
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sandals
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Heels
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Socks
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <div>
                                <p id="women-collection-heading-mobile" class="font-medium text-gray-900">
                                    Shop Collection
                                </p>
                                <ul role="list" aria-labelledby="women-collection-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Everything
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Core
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            New Arrivals
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sale
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Accessories
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                        <div class="space-y-10">

                            <div>
                                <p id="women-clothing-heading-mobile" class="font-medium text-gray-900">
                                    All Clothing
                                </p>
                                <ul role="list" aria-labelledby="women-clothing-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Basic Tees
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Artwork Tees
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Tops
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Bottoms
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Swimwear
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Underwear
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <div>
                                <p id="women-accessories-heading-mobile" class="font-medium text-gray-900">
                                    All Accessories
                                </p>
                                <ul role="list" aria-labelledby="women-accessories-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Watches
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Wallets
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Bags
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sunglasses
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Hats
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Belts
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                        <div class="space-y-10">

                            <div>
                                <p id="women-brands-heading-mobile" class="font-medium text-gray-900">
                                    Brands
                                </p>
                                <ul role="list" aria-labelledby="women-brands-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Full Nelson
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            My Way
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Re-Arranged
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Counterfeit
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Significant Other
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                    </div>

                    <div id="tabs-1-panel-2" class="pt-10 pb-8 px-4 space-y-10" x-description="'Men' tab panel, show/hide based on tab state." x-data="Components.tabPanel(0)" aria-labelledby="tabs-1-tab-2" x-init="init()" x-show="selected" @tab-select.window="onTabSelect" role="tabpanel" tabindex="0">
                        <div class="space-y-4">

                            <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden">
                                <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-category-01.jpg" alt="Wooden shelf with gray and olive drab green baseball caps, next to wooden clothes hanger with sweaters." class="object-center object-cover group-hover:opacity-75">
                                <div class="flex flex-col justify-end">
                                    <div class="p-4 bg-white bg-opacity-60 text-base sm:text-sm">
                                        <a href="#" class="font-medium text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Accessories
                                        </a>
                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                    </div>
                                </div>
                            </div>

                            <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden">
                                <img src="https://tailwindui.com/img/ecommerce-images/product-page-04-detail-product-shot-01.jpg" alt="Drawstring top with elastic loop closure and textured interior padding." class="object-center object-cover group-hover:opacity-75">
                                <div class="flex flex-col justify-end">
                                    <div class="p-4 bg-white bg-opacity-60 text-base sm:text-sm">
                                        <a href="#" class="font-medium text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            New Arrivals
                                        </a>
                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                    </div>
                                </div>
                            </div>

                            <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden">
                                <img src="https://tailwindui.com/img/ecommerce-images/category-page-02-image-card-06.jpg" alt="Three shirts in gray, white, and blue arranged on table with same line drawing of hands and shapes overlapping on front of shirt." class="object-center object-cover group-hover:opacity-75">
                                <div class="flex flex-col justify-end">
                                    <div class="p-4 bg-white bg-opacity-60 text-base sm:text-sm">
                                        <a href="#" class="font-medium text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Artwork Tees
                                        </a>
                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-y-10">

                            <div>
                                <p id="men-shoes-heading-mobile" class="font-medium text-gray-900">
                                    Shoes &amp; Accessories
                                </p>
                                <ul role="list" aria-labelledby="men-shoes-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sneakers
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Boots
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sandals
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Socks
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <div>
                                <p id="men-collection-heading-mobile" class="font-medium text-gray-900">
                                    Shop Collection
                                </p>
                                <ul role="list" aria-labelledby="men-collection-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Everything
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Core
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            New Arrivals
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sale
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                        <div class="space-y-10">

                            <div>
                                <p id="men-clothing-heading-mobile" class="font-medium text-gray-900">
                                    All Clothing
                                </p>
                                <ul role="list" aria-labelledby="men-clothing-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Basic Tees
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Artwork Tees
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Pants
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Hoodies
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Swimsuits
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <div>
                                <p id="men-accessories-heading-mobile" class="font-medium text-gray-900">
                                    All Accessories
                                </p>
                                <ul role="list" aria-labelledby="men-accessories-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Watches
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Wallets
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Bags
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Sunglasses
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Hats
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Belts
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                        <div class="space-y-10">

                            <div>
                                <p id="men-brands-heading-mobile" class="font-medium text-gray-900">
                                    Brands
                                </p>
                                <ul role="list" aria-labelledby="men-brands-heading-mobile" class="mt-6 flex flex-col space-y-6">

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Re-Arranged
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Counterfeit
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            Full Nelson
                                        </a>
                                    </li>

                                    <li class="flow-root">
                                        <a href="#" class="-m-2 p-2 block text-gray-500">
                                            My Way
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                    </div>


                </div>

                <div class="border-t border-gray-200 py-6 px-4 space-y-6">

                    <div class="flow-root">
                        <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Company</a>
                    </div>

                    <div class="flow-root">
                        <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Stores</a>
                    </div>

                </div>

                <div class="border-t border-gray-200 py-6 px-4">
                    <a href="#" class="-m-2 p-2 flex items-center">
                        <img src="https://tailwindui.com/img/flags/flag-canada.svg" alt="" class="w-5 h-auto block flex-shrink-0">
                        <span class="ml-3 block text-base font-medium text-gray-900">
                  CAD
                </span>
                        <span class="sr-only">, change currency</span>
                    </a>
                </div>
            </div>

        </div>


        <header class="relative bg-white">
            <nav aria-label="Top" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="border-b border-gray-200">
                    <div class="h-16 flex items-center justify-between">
                        <div class="flex-1 flex items-center lg:hidden">
                            <button type="button" x-description="Mobile menu toggle, controls the 'mobileMenuOpen' state." class="-ml-2 bg-white p-2 rounded-md text-gray-400" @click="open = true">
                                <span class="sr-only">Open menu</span>
                                <svg class="h-6 w-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>

                            <a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Search</span>
                                <svg class="w-6 h-6" x-description="Heroicon name: outline/search" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Flyout menus -->
                        <div class="hidden lg:flex-1 lg:block lg:self-stretch" x-data="Components.popoverGroup()" x-init="init()">
                            <div class="h-full flex space-x-8">

                                <div class="flex" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                                    <div class="relative flex">
                                        <button type="button" x-state:on="Item active" x-state:off="Item inactive" class="text-gray-700 hover:text-gray-800 relative z-10 flex items-center justify-center transition-colors ease-out duration-200 text-sm font-medium" :class="{ 'text-indigo-600': open, 'text-gray-700 hover:text-gray-800': !(open) }" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
                                            Women
                                            <span class="absolute bottom-0 inset-x-0 h-0.5 transition-colors ease-out duration-200 sm:mt-5 sm:transform sm:translate-y-px" aria-hidden="true" x-state:on="Open" x-state:off="Closed" :class="{ 'bg-indigo-600': open }"></span>
                                        </button>
                                    </div>


                                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="'Women' flyout menu, show/hide based on flyout menu state." class="absolute z-20 top-full inset-x-0" x-ref="panel" @click.away="open = false">
                                        <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                                        <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true"></div>

                                        <div class="relative bg-white">
                                            <div class="max-w-7xl mx-auto px-8">
                                                <div class="grid grid-cols-2 gap-y-10 gap-x-8 py-16">
                                                    <div class="grid grid-rows-1 grid-cols-2 gap-8 text-sm">

                                                        <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden col-span-2 aspect-w-2">
                                                            <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg" alt="Models sitting back to back, wearing Basic Tee in black and bone." class="object-center object-cover group-hover:opacity-75">
                                                            <div class="flex flex-col justify-end">
                                                                <div class="p-4 bg-white bg-opacity-60 text-sm">
                                                                    <a href="#" class="font-medium text-gray-900">
                                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                                        New Arrivals
                                                                    </a>
                                                                    <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden ">
                                                            <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg" alt="Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees." class="object-center object-cover group-hover:opacity-75">
                                                            <div class="flex flex-col justify-end">
                                                                <div class="p-4 bg-white bg-opacity-60 text-sm">
                                                                    <a href="#" class="font-medium text-gray-900">
                                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                                        Basic Tees
                                                                    </a>
                                                                    <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden ">
                                                            <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-03.jpg" alt="Model wearing minimalist watch with black wristband and white watch face." class="object-center object-cover group-hover:opacity-75">
                                                            <div class="flex flex-col justify-end">
                                                                <div class="p-4 bg-white bg-opacity-60 text-sm">
                                                                    <a href="#" class="font-medium text-gray-900">
                                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                                        Accessories
                                                                    </a>
                                                                    <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="grid grid-cols-3 gap-y-10 gap-x-8 text-sm text-gray-500">

                                                        <div class="space-y-10">

                                                            <div>
                                                                <p id="women-shoes-heading" class="font-medium text-gray-900">
                                                                    Shoes &amp; Accessories
                                                                </p>
                                                                <ul role="list" aria-labelledby="women-shoes-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sneakers
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Boots
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Flats
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sandals
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Heels
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Socks
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                            <div>
                                                                <p id="women-collection-heading" class="font-medium text-gray-900">
                                                                    Shop Collection
                                                                </p>
                                                                <ul role="list" aria-labelledby="women-collection-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Everything
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Core
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            New Arrivals
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sale
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Accessories
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                        </div>

                                                        <div class="space-y-10">

                                                            <div>
                                                                <p id="women-clothing-heading" class="font-medium text-gray-900">
                                                                    All Clothing
                                                                </p>
                                                                <ul role="list" aria-labelledby="women-clothing-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Basic Tees
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Artwork Tees
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Tops
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Bottoms
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Swimwear
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Underwear
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                            <div>
                                                                <p id="women-accessories-heading" class="font-medium text-gray-900">
                                                                    All Accessories
                                                                </p>
                                                                <ul role="list" aria-labelledby="women-accessories-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Watches
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Wallets
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Bags
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sunglasses
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Hats
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Belts
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                        </div>

                                                        <div class="space-y-10">

                                                            <div>
                                                                <p id="women-brands-heading" class="font-medium text-gray-900">
                                                                    Brands
                                                                </p>
                                                                <ul role="list" aria-labelledby="women-brands-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Full Nelson
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            My Way
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Re-Arranged
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Counterfeit
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Significant Other
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="flex" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                                    <div class="relative flex">
                                        <button type="button" x-state:on="Item active" x-state:off="Item inactive" class="text-gray-700 hover:text-gray-800 relative z-10 flex items-center justify-center transition-colors ease-out duration-200 text-sm font-medium" :class="{ 'text-indigo-600': open, 'text-gray-700 hover:text-gray-800': !(open) }" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
                                            Men
                                            <span class="absolute bottom-0 inset-x-0 h-0.5 transition-colors ease-out duration-200 sm:mt-5 sm:transform sm:translate-y-px" aria-hidden="true" x-state:on="Open" x-state:off="Closed" :class="{ 'bg-indigo-600': open }"></span>
                                        </button>
                                    </div>


                                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="'Men' flyout menu, show/hide based on flyout menu state." class="absolute z-20 top-full inset-x-0" x-ref="panel" @click.away="open = false">
                                        <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                                        <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true"></div>

                                        <div class="relative bg-white">
                                            <div class="max-w-7xl mx-auto px-8">
                                                <div class="grid grid-cols-2 gap-y-10 gap-x-8 py-16">
                                                    <div class="grid grid-rows-1 grid-cols-2 gap-8 text-sm">

                                                        <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden col-span-2 aspect-w-2">
                                                            <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-category-01.jpg" alt="Wooden shelf with gray and olive drab green baseball caps, next to wooden clothes hanger with sweaters." class="object-center object-cover group-hover:opacity-75">
                                                            <div class="flex flex-col justify-end">
                                                                <div class="p-4 bg-white bg-opacity-60 text-sm">
                                                                    <a href="#" class="font-medium text-gray-900">
                                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                                        Accessories
                                                                    </a>
                                                                    <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden ">
                                                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-04-detail-product-shot-01.jpg" alt="Drawstring top with elastic loop closure and textured interior padding." class="object-center object-cover group-hover:opacity-75">
                                                            <div class="flex flex-col justify-end">
                                                                <div class="p-4 bg-white bg-opacity-60 text-sm">
                                                                    <a href="#" class="font-medium text-gray-900">
                                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                                        New Arrivals
                                                                    </a>
                                                                    <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="group relative aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden ">
                                                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-02-image-card-06.jpg" alt="Three shirts in gray, white, and blue arranged on table with same line drawing of hands and shapes overlapping on front of shirt." class="object-center object-cover group-hover:opacity-75">
                                                            <div class="flex flex-col justify-end">
                                                                <div class="p-4 bg-white bg-opacity-60 text-sm">
                                                                    <a href="#" class="font-medium text-gray-900">
                                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                                        Artwork Tees
                                                                    </a>
                                                                    <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="grid grid-cols-3 gap-y-10 gap-x-8 text-sm text-gray-500">

                                                        <div class="space-y-10">

                                                            <div>
                                                                <p id="men-shoes-heading" class="font-medium text-gray-900">
                                                                    Shoes &amp; Accessories
                                                                </p>
                                                                <ul role="list" aria-labelledby="men-shoes-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sneakers
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Boots
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sandals
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Socks
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                            <div>
                                                                <p id="men-collection-heading" class="font-medium text-gray-900">
                                                                    Shop Collection
                                                                </p>
                                                                <ul role="list" aria-labelledby="men-collection-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Everything
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Core
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            New Arrivals
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sale
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                        </div>

                                                        <div class="space-y-10">

                                                            <div>
                                                                <p id="men-clothing-heading" class="font-medium text-gray-900">
                                                                    All Clothing
                                                                </p>
                                                                <ul role="list" aria-labelledby="men-clothing-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Basic Tees
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Artwork Tees
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Pants
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Hoodies
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Swimsuits
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                            <div>
                                                                <p id="men-accessories-heading" class="font-medium text-gray-900">
                                                                    All Accessories
                                                                </p>
                                                                <ul role="list" aria-labelledby="men-accessories-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Watches
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Wallets
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Bags
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Sunglasses
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Hats
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Belts
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                        </div>

                                                        <div class="space-y-10">

                                                            <div>
                                                                <p id="men-brands-heading" class="font-medium text-gray-900">
                                                                    Brands
                                                                </p>
                                                                <ul role="list" aria-labelledby="men-brands-heading" class="mt-4 space-y-4">

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Re-Arranged
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Counterfeit
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            Full Nelson
                                                                        </a>
                                                                    </li>

                                                                    <li class="flex">
                                                                        <a href="#" class="hover:text-gray-800">
                                                                            My Way
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Company</a>

                                <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Stores</a>

                            </div>
                        </div>

                        <!-- Logo -->
                        <a href="#" class="flex">
                            <span class="sr-only">Workflow</span>
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&amp;shade=600" alt="">
                        </a>

                        <div class="flex-1 flex items-center justify-end">
                            <a href="#" class="hidden text-gray-700 hover:text-gray-800 lg:flex lg:items-center">
                                <img src="https://tailwindui.com/img/flags/flag-canada.svg" alt="" class="w-5 h-auto block flex-shrink-0">
                                <span class="ml-3 block text-sm font-medium">
                  CAD
                </span>
                                <span class="sr-only">, change currency</span>
                            </a>

                            <!-- Search -->
                            <a href="#" class="hidden ml-6 p-2 text-gray-400 hover:text-gray-500 lg:block">
                                <span class="sr-only">Search</span>
                                <svg class="w-6 h-6" x-description="Heroicon name: outline/search" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </a>

                            <!-- Account -->
                            <a href="#" class="p-2 text-gray-400 hover:text-gray-500 lg:ml-4">
                                <span class="sr-only">Account</span>
                                <svg class="w-6 h-6" x-description="Heroicon name: outline/user" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </a>

                            <!-- Cart -->
                            <div class="ml-4 flow-root lg:ml-6">
                                <a href="#" class="group -m-2 p-2 flex items-center">
                                    <svg class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/shopping-bag" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                                    <span class="sr-only">items in cart, view bag</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main class="pb-24">
            <div class="text-center py-16 px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Workspace</h1>
                <p class="mt-4 max-w-xl mx-auto text-base text-gray-500">The secret to a tidy desk? Don't get rid of anything, just put it in really really nice looking containers.</p>
            </div>

            <!-- Filters -->
            <section x-data="{ open: false }" aria-labelledby="filter-heading" class="relative z-10 border-t border-b border-gray-200 grid items-center">
                <h2 id="filter-heading" class="sr-only">Filters</h2>
                <div class="relative col-start-1 row-start-1 py-4">
                    <div class="max-w-7xl mx-auto flex space-x-6 divide-x divide-gray-200 text-sm px-4 sm:px-6 lg:px-8">
                        <div>
                            <button type="button" class="group text-gray-700 font-medium flex items-center" aria-controls="disclosure-1" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                <svg class="flex-none w-5 h-5 mr-2 text-gray-400 group-hover:text-gray-500" aria-hidden="true" x-description="Heroicon name: solid/filter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                </svg>
                                2 Filters
                            </button>
                        </div>
                        <div class="pl-6">
                            <button type="button" class="text-gray-500">Clear all</button>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-200 py-10" id="disclosure-1" x-show="open">
                    <div class="max-w-7xl mx-auto grid grid-cols-2 gap-x-4 px-4 text-sm sm:px-6 md:gap-x-6 lg:px-8">
                        <div class="grid grid-cols-1 gap-y-10 auto-rows-min md:grid-cols-2 md:gap-x-6">
                            <fieldset>
                                <legend class="block font-medium">
                                    Price
                                </legend>
                                <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="price-0" name="price[]" value="0" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="price-0" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            $0 - $25
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="price-1" name="price[]" value="25" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="price-1" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            $25 - $50
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="price-2" name="price[]" value="50" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="price-2" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            $50 - $75
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="price-3" name="price[]" value="75" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="price-3" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            $75+
                                        </label>
                                    </div>

                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="block font-medium">
                                    Color
                                </legend>
                                <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="color-0" name="color[]" value="white" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="color-0" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            White
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="color-1" name="color[]" value="beige" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="color-1" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Beige
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="color-2" name="color[]" value="blue" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" checked="">
                                        <label for="color-2" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Blue
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="color-3" name="color[]" value="brown" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="color-3" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Brown
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="color-4" name="color[]" value="green" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="color-4" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Green
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="color-5" name="color[]" value="purple" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="color-5" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Purple
                                        </label>
                                    </div>

                                </div>
                            </fieldset>
                        </div>
                        <div class="grid grid-cols-1 gap-y-10 auto-rows-min md:grid-cols-2 md:gap-x-6">
                            <fieldset>
                                <legend class="block font-medium">
                                    Size
                                </legend>
                                <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="size-0" name="size[]" value="xs" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="size-0" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            XS
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="size-1" name="size[]" value="s" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" checked="">
                                        <label for="size-1" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            S
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="size-2" name="size[]" value="m" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="size-2" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            M
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="size-3" name="size[]" value="l" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="size-3" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            L
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="size-4" name="size[]" value="xl" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="size-4" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            XL
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="size-5" name="size[]" value="2xl" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="size-5" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            2XL
                                        </label>
                                    </div>

                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="block font-medium">
                                    Category
                                </legend>
                                <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="category-0" name="category[]" value="all-new-arrivals" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="category-0" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            All New Arrivals
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="category-1" name="category[]" value="tees" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="category-1" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Tees
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="category-2" name="category[]" value="objects" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="category-2" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Objects
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="category-3" name="category[]" value="sweatshirts" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="category-3" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Sweatshirts
                                        </label>
                                    </div>

                                    <div class="flex items-center text-base sm:text-sm">
                                        <input id="category-4" name="category[]" value="pants-and-shorts" type="checkbox" class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="category-4" class="ml-3 min-w-0 flex-1 text-gray-600">
                                            Pants &amp; Shorts
                                        </label>
                                    </div>

                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-start-1 row-start-1 py-4">
                    <div class="flex justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative inline-block">
                            <div class="flex">
                                <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" id="menu-button" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
                                    Sort
                                    <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>


                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()">
                                <div class="py-1" role="none">

                                    <a href="#" class="font-medium text-gray-900 block px-4 py-2 text-sm" x-state:on="Active" x-state:off="Not Active" x-state:on:option.current="Selected" x-state:off:option.current="Not Selected" x-state-description="Selected: &quot;font-medium text-gray-900&quot;, Not Selected: &quot;text-gray-500&quot;" :class="{ 'bg-gray-100': activeIndex === 0 }" role="menuitem" tabindex="-1" id="menu-item-0" @mouseenter="activeIndex = 0" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">
                                        Most Popular
                                    </a>

                                    <a href="#" class="text-gray-500 block px-4 py-2 text-sm" x-state-description="undefined: &quot;font-medium text-gray-900&quot;, undefined: &quot;text-gray-500&quot;" :class="{ 'bg-gray-100': activeIndex === 1 }" role="menuitem" tabindex="-1" id="menu-item-1" @mouseenter="activeIndex = 1" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">
                                        Best Rating
                                    </a>

                                    <a href="#" class="text-gray-500 block px-4 py-2 text-sm" x-state-description="undefined: &quot;font-medium text-gray-900&quot;, undefined: &quot;text-gray-500&quot;" :class="{ 'bg-gray-100': activeIndex === 2 }" role="menuitem" tabindex="-1" id="menu-item-2" @mouseenter="activeIndex = 2" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">
                                        Newest
                                    </a>

                                    <a href="#" class="text-gray-500 block px-4 py-2 text-sm" x-state-description="undefined: &quot;font-medium text-gray-900&quot;, undefined: &quot;text-gray-500&quot;" :class="{ 'bg-gray-100': activeIndex === 3 }" role="menuitem" tabindex="-1" id="menu-item-3" @mouseenter="activeIndex = 3" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">
                                        Price: Low to High
                                    </a>

                                    <a href="#" class="text-gray-500 block px-4 py-2 text-sm" x-state-description="undefined: &quot;font-medium text-gray-900&quot;, undefined: &quot;text-gray-500&quot;" :class="{ 'bg-gray-100': activeIndex === 4 }" role="menuitem" tabindex="-1" id="menu-item-4" @mouseenter="activeIndex = 4" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">
                                        Price: High to Low
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            <!-- Product grid -->
            <section aria-labelledby="products-heading" class="max-w-7xl mx-auto overflow-hidden sm:px-6 lg:px-8">
                <h2 id="products-heading" class="sr-only">Products</h2>

                <div class="-mx-px border-l border-gray-200 grid grid-cols-2 sm:mx-0 md:grid-cols-3 lg:grid-cols-4">

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-01.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Organize Basic Set (Walnut)
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">5 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">38 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$149</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-02.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Organize Pen Holder
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">5 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">18 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$15</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-03.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Organize Sticky Note Holder
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">5 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">14 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$15</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-04.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Organize Phone Holder
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">4 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-gray-200 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">21 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$15</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-05.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Organize Small Tray
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">4 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-gray-200 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">22 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$15</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-06.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Organize Basic Set (Maple)
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">5 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">64 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$149</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-07.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Out and About Bottle
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">4 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-gray-200 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">12 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$25</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-08.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Daily Notebook Refill Pack
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">4 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-gray-200 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">41 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$14</p>
                        </div>
                    </div>

                    <div class="group relative p-4 border-r border-b border-gray-200 sm:p-6">
                        <div class="rounded-lg overflow-hidden bg-gray-200 aspect-w-1 aspect-h-1 group-hover:opacity-75">
                            <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-09.jpg" alt="TODO" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="pt-10 pb-4 text-center">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Leather Key Ring (Black)
                                </a>
                            </h3>
                            <div class="mt-3 flex flex-col items-center">
                                <p class="sr-only">5 out of 5 stars</p>
                                <div class="flex items-center">

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                    <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>

                                </div>
                                <p class="mt-1 text-sm text-gray-500">24 reviews</p>
                            </div>
                            <p class="mt-4 text-base font-medium text-gray-900">$32</p>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Pagination -->
            <nav aria-label="Pagination" class="max-w-7xl mx-auto px-4 mt-6 flex justify-between text-sm font-medium text-gray-700 sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        Previous
                    </a>
                </div>
                <div class="hidden space-x-2 sm:flex">
                    <!-- Current: "border-indigo-600 ring-1 ring-indigo-600", Default: "border-gray-300" -->
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        1
                    </a>
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        2
                    </a>
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-indigo-600 ring-1 ring-indigo-600 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        3
                    </a>
                    <span class="inline-flex items-center text-gray-500 px-1.5 h-10">
            ...
          </span>
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        8
                    </a>
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        9
                    </a>
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        10
                    </a>
                </div>
                <div class="min-w-0 flex-1 flex justify-end">
                    <a href="#" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                        Next
                    </a>
                </div>
            </nav>
        </main>

        <footer aria-labelledby="footer-heading" class="bg-white">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="border-t border-gray-200 py-20 grid grid-cols-2 gap-8 sm:gap-y-0 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="grid grid-cols-1 gap-y-10 lg:col-span-2 lg:grid-cols-2 lg:gap-y-0 lg:gap-x-8">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">
                                Account
                            </h3>
                            <ul role="list" class="mt-6 space-y-6">

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Manage Account
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Saved Items
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Orders
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Redeem Gift card
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">
                                Service
                            </h3>
                            <ul role="list" class="mt-6 space-y-6">

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Shipping &amp; Returns
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Warranty
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        FAQ
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Find a store
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Get in touch
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-10 lg:col-span-2 lg:grid-cols-2 lg:gap-y-0 lg:gap-x-8">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">
                                Company
                            </h3>
                            <ul role="list" class="mt-6 space-y-6">

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Who we are
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Press
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Careers
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Terms &amp; Conditions
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Privacy
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">
                                Connect
                            </h3>
                            <ul role="list" class="mt-6 space-y-6">

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Instagram
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Pinterest
                                    </a>
                                </li>

                                <li class="text-sm">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">
                                        Twitter
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 py-10 sm:flex sm:items-center sm:justify-between">
                    <div class="flex items-center justify-center text-sm text-gray-500">
                        <p>Shipping to Canada ($CAD)</p>
                        <p class="ml-3 border-l border-gray-200 pl-3">English</p>
                    </div>
                    <p class="mt-6 text-sm text-gray-500 text-center sm:mt-0">© 2021 Clothing Company, Ltd.</p>
                </div>
            </div>
        </footer>
    </div>
    <div class="relative isolate overflow-hidden bg-white px-6 py-24 sm:py-32 lg:overflow-visible lg:px-0">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-gray-200 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                    <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
                </svg>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
            <div class="lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                <div class="lg:pr-4">
                    <div class="lg:max-w-lg">
                        <p class="text-base font-semibold leading-7 text-indigo-600">Deploy faster</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">A better workflow</h1>
                        <p class="mt-6 text-xl leading-8 text-gray-700">Aliquet nec orci mattis amet quisque ullamcorper neque, nibh sem. At arcu, sit dui mi, nibh dui, diam eget aliquam. Quisque id at vitae feugiat egestas.</p>
                    </div>
                </div>
            </div>
            <div class="-ml-12 -mt-12 p-12 lg:sticky lg:top-4 lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:overflow-hidden">
                <img class="w-[48rem] max-w-none rounded-xl bg-gray-900 shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem]" src="https://tailwindui.com/img/component-images/dark-project-app-screenshot.png" alt="">
            </div>
            <div class="lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                <div class="lg:pr-4">
                    <div class="max-w-xl text-base leading-7 text-gray-700 lg:max-w-lg">
                        <p>Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque erat velit. Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id.</p>
                        <ul role="list" class="mt-8 space-y-8 text-gray-600">
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.5 17a4.5 4.5 0 01-1.44-8.765 4.5 4.5 0 018.302-3.046 3.5 3.5 0 014.504 4.272A4 4 0 0115 17H5.5zm3.75-2.75a.75.75 0 001.5 0V9.66l1.95 2.1a.75.75 0 101.1-1.02l-3.25-3.5a.75.75 0 00-1.1 0l-3.25 3.5a.75.75 0 101.1 1.02l1.95-2.1v4.59z" clip-rule="evenodd" />
                                </svg>
                                <span><strong class="font-semibold text-gray-900">Push to deploy.</strong> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                                <span><strong class="font-semibold text-gray-900">SSL certificates.</strong> Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M4.632 3.533A2 2 0 016.577 2h6.846a2 2 0 011.945 1.533l1.976 8.234A3.489 3.489 0 0016 11.5H4c-.476 0-.93.095-1.344.267l1.976-8.234z" />
                                    <path fill-rule="evenodd" d="M4 13a2 2 0 100 4h12a2 2 0 100-4H4zm11.24 2a.75.75 0 01.75-.75H16a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75V15zm-2.25-.75a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 00.75-.75V15a.75.75 0 00-.75-.75h-.01z" clip-rule="evenodd" />
                                </svg>
                                <span><strong class="font-semibold text-gray-900">Database backups.</strong> Ac tincidunt sapien vehicula erat auctor pellentesque rhoncus. Et magna sit morbi lobortis.</span>
                            </li>
                        </ul>
                        <p class="mt-8">Et vitae blandit facilisi magna lacus commodo. Vitae sapien duis odio id et. Id blandit molestie auctor fermentum dignissim. Lacus diam tincidunt ac cursus in vel. Mauris varius vulputate et ultrices hac adipiscing egestas. Iaculis convallis ac tempor et ut. Ac lorem vel integer orci.</p>
                        <h2 class="mt-16 text-2xl font-bold tracking-tight text-gray-900">No server? No problem.</h2>
                        <p class="mt-6">Id orci tellus laoreet id ac. Dolor, aenean leo, ac etiam consequat in. Convallis arcu ipsum urna nibh. Pharetra, euismod vitae interdum mauris enim, consequat vulputate nibh. Maecenas pellentesque id sed tellus mauris, ultrices mauris. Tincidunt enim cursus ridiculus mi. Pellentesque nam sed nullam sed diam turpis ipsum eu a sed convallis diam.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
