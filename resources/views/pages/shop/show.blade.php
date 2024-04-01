<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <section class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="font-manrope font-bold text-4xl text-black dark:text-gray-200 mb-8 max-xl:text-center">{{ $product->name }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
                test
            </div>
        </div>
    </section>

</x-app-layout>
