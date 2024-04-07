<x-app-layout>
    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">
                {{ __('Abyss') }}
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
                                    {{ __('Rank') }}
                                </th>
                                <th scope="col" class=" table-th ">
                                    {{ __('AP') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @forelse($abyssRanks as $abyssRank)
                                    <tr>
                                        <td class="table-td">
                                            {{ $abyssRank->player->name }}
                                        </td>
                                        <td class="table-td">
                                            {{ $abyssRank->player->player_class }}
                                        </td>
                                        <td class="table-td">
                                            {{ $abyssRank->player->race }}
                                        </td>
                                        <td class="table-td">
                                            {{ $abyssRank->rank->getRankName() }}
                                        </td>
                                        <td class="table-td">
                                            {{ $abyssRank->ap }}
                                        </td>
                                    </tr>
                                @empty
                                    {{ __('Nothing to show') }}
                                @endforelse
                            </tbody>
                        </table>
                        {{ $abyssRanks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
