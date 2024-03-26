<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Donate') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Donate') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('You can financially support our server and get bonuses for it.') }}
                    </p>
                </header>
                <div class="max-w-xl">
                    <form method="post" action="{{ route('donate') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" :value="old('amount', 1)" autocomplete="amount" />
                            <x-input-error :messages="$errors->create->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="currency" :value="__('Currency')" />
                            <x-select-input
                                name="currency"
                                :options="[
                                    'RUB' => 'RUB',
                                    'USD' => 'USD',
                                ]"
                                :value="old('currency')"
                                class="mt-1 block w-full"
                            />
                            <x-input-error :messages="$errors->store->get('currency')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="payment_system" :value="__('Payment System')" />
                            <x-select-input
                                name="payment_system"
                                    :options="[
                                    'palych' => 'Palych.io',
                                ]"
                                :value="old('payment_system')"
                                class="mt-1 block w-full"
                            />
                            <x-input-error :messages="$errors->store->get('payment_system')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'donate-error')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
