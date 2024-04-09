<x-app-layout>
    <div class="card">
        <header class="card-header noborder">
            <h4 class="card-title">
                {{ __('Referral Program') }}
            </h4>
        </header>
        <div class="card-body px-6 pb-6">
            <div class="overflow-x-auto -mx-6">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                            <thead class="bg-slate-200 dark:bg-slate-700">
                            <tr>
                                <th scope="col" class=" table-th ">
                                    {{ __('Your link') }}
                                </th>
                                <th scope="col" class=" table-th ">
                                    {{ __('Earned') }}
                                </th>
                                <th scope="col" class=" table-th ">
                                    {{ __('Number of registrations') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                <tr>
                                    <td class="table-td">
                                        {{ config('app.url') . '/ref/'. $referral->code }}
                                    </td>
                                    <td class="table-td">
                                        {{ $referral->earned }} Toll
                                    </td>
                                    <td class="table-td">
                                        {{ $referral->count }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
