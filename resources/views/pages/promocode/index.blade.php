<x-app-layout>
    <div class="card">
        <header class="card-header noborder">
            <h4 class="card-title">
                {{ __('Promo Codes') }}
            </h4>
            <div class="flex justify-end mt-1.5">
                <a href="{{ route('promocode.create') }}" class="btn inline-flex justify-center btn-outline-dark !bg-black-500 !text-white">
                      <span class="flex items-center">
                            <iconify-icon class="text-2xl ltr:mr-2 rtl:ml-2" icon="ic:round-plus"></iconify-icon>
                            <span>{{ __('Add') }}</span>
                      </span>
                </a>
            </div>
        </header>
        <div class="card-body px-6 pb-6">
            <div class="overflow-x-auto -mx-6">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                            <thead class="bg-slate-200 dark:bg-slate-700">
                            <tr>
                                <th scope="col" class=" table-th ">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class=" table-th ">
                                    {{ __('Toll') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @forelse($promoCodes as $promoCode)
                                    <tr>
                                        <td class="table-td">
                                            {{ $promoCode->code }}
                                        </td>
                                        <td class="table-td">
                                            {{ $promoCode->toll }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>{{ __('Nothing to show') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white"> {{ __('Activate promo code') }}</div>
                </div>
            </header>
            <div class="card-text h-full space-y-4">
                <form action="{{ route('promocode.activate') }}" method="POST">
                    @csrf
                    <div class="input-area">
                        <label for="code" class="form-label">{{ __('Code') }}</label>
                        <input id="code" name="code" type="text" class="form-control @error('code') border-danger-500 pr-9 @enderror"
                               value="{{ old('code') }}">
                    </div>
                    @error('code')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <button class="btn inline-flex justify-center btn-dark ml-28 mt-2">{{ __('Activate') }}</button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
