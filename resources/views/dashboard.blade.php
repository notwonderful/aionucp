<x-app-layout>
    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">
                {{ __('Account information') }}
            </h4>
        </header>
        <div class="card-body px-6 pb-6">
            <div class="overflow-x-auto -mx-6">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                            <thead class="bg-slate-200 dark:bg-slate-700">
                            <tr>
                                <th scope="col" class=" table-th ">
                                    {{ __('Membership') }}
                                </th>
                                <th scope="col" class=" table-th ">
                                    {{ __('Membership Expire') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                            @forelse($accountInfo as $account)
                                <tr>
                                    <td class="table-td">{{ $account->membership->label() }}</td>
                                    @if($account->membership->label() !== 'REGULAR')
                                        <td class="table-td">
                                            {{ $account->membership_expire }}
                                        </td>
                                    @else
                                        <td class="table-td">
                                            -
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                {{ __('Nothing to show') }}
                            @endforelse
                            </tbody>
                        </table>
                        {{ $accountInfo->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">
                {{ __('My characters') }}
            </h4>
        </header>
        <div class="card-body px-6 pb-6">
            <div class="overflow-x-auto -mx-6">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                            <thead class="bg-slate-200 dark:bg-slate-700">
                                <tr>
                                    <th scope="col" class=" table-th ">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class=" table-th ">
                                        {{ __('Class') }}
                                    </th>
                                    <th scope="col" class=" table-th ">
                                        {{ __('Race') }}
                                    </th>
                                    <th scope="col" class=" table-th ">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @forelse($account->players as $player)
                                    <tr>
                                        <td class="table-td">{{ $player->name }}</td>
                                        <td class="table-td">{{ $player->player_class }}</td>
                                        <td class="table-td">{{ $player->race }}</td>
                                        <td class="table-td">
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
                        {{ $accountInfo->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
