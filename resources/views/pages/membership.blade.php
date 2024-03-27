<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Membership') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Membership') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('You can financially support our server and get bonuses for it.') }}
                    </p>
                </header>
                <div class="max-w-xl">
                    <form method="post" action="{{ route('membership') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="membership_type" :value="__('Type')" />
                            <x-select-input
                                name="membership_type"
                                :options="[
                                    '1' => 'VIP',
                                    '2' => 'PREMIUM',
                                ]"
                                :value="old('membership_type')"
                                class="mt-1 block w-full"
                            />
                            <x-input-error :messages="$errors->get('membership_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="duration" :value="__('Duration')" />
                            <x-select-input
                                name="duration"
                                    :options="[
                                    '30' => __('30 days'),
                                ]"
                                :value="old('duration')"
                                class="mt-1 block w-full"
                            />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Buy') }}</x-primary-button>

                            @session('balance'))
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    class="text-sm text-red-600 dark:text-red-400"
                                >{{ session('balance') }}</p>
                            @endsession

                            @session('success'))
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    class="text-sm text-green-600 dark:text-green-400"
                                >{{ session('success') }}</p>
                            @endsession
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
