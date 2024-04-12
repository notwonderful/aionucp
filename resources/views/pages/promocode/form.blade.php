<x-app-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ isset($promoCode->code) ? __('Edit') . ' ' . $promoCode->code : __('Add promo code') }}</div>
                </div>
            </header>
            <div class="card-text h-full space-y-4">
                <form action="{{ isset($promoCode) ? route('promocode.update', $promoCode) : route('promocode.store') }}" method="POST">
                    @csrf
                    @isset($promoCode)
                        @method('PATCH')
                    @endisset
                    <div class="input-area">
                        <label for="code" class="form-label">{{ __('Code') }}</label>
                        <input id="code" name="code" type="text" class="form-control @error('code') border-danger-500 pr-9 @enderror"
                               value="{{ isset($promoCode->code) ?? old('code') }}">
                    </div>
                    @error('code')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="toll" class="form-label">Toll</label>
                        <input id="toll" name="toll" type="number" class="form-control @error('toll') border-danger-500 pr-9 @enderror"
                               value="{{ isset($promoCode->toll) ?? old('toll') }}">
                    </div>
                    @error('toll')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <input id="user_id" name="user_id" type="hidden" class="form-control @error('user_id') border-danger-500 pr-9 @enderror"
                               value="{{ isset($promoCode->user_id) ? $promoCode->user_id : auth()->id() }}">
                    </div>
                    @error('user_id')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <button class="btn inline-flex justify-center btn-dark ml-28 mt-2">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
