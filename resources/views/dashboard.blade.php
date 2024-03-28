<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome, Daeva!") }}
                </div>
                <div class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800 border-gray-700">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-700 border border-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">{{ __('Membership') }}</span>
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">{{ __('Membership Expire') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($accountInfo as $account)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600 dark:text-gray-400">
                                        {{ $account->membership->label() }}
                                    </td>
                                    @if($account->membership->label() !== 'REGULAR')
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600 dark:text-gray-400">
                                            {{ $account->membership_expire }}
                                        </td>
                                        @else
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600 dark:text-gray-400">
                                            -
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                {{ __('Nothing to show') }}
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $accountInfo->links() }}
                    </div>
                </div>
            </div>
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('My characters') }}
                </div>
                <div class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800 border-gray-700">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-700 border border-gray-700">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">{{ __('Name') }}</span>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">{{ __('Class') }}</span>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">{{ __('Race') }}</span>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($account->players as $player)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600 dark:text-gray-400">
                                        {{ $player->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600 dark:text-gray-400">
                                        {{ $player->player_class }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600 dark:text-gray-400">
                                        {{ $player->race }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600 dark:text-gray-400">
                                        <form method="POST" action="{{ route('teleport', $player) }}">
                                            @csrf
                                            <x-primary-button>{{ __('Unstuck') }}</x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                {{ __('Nothing to show') }}
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $accountInfo->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
