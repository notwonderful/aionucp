<x-app-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ __('Donate') }}</div>
                    <p class="mt-1 text-slate-900 dark:text-white">
                        {{ __('You can financially support our server and get bonuses for it.') }}
                    </p>
                </div>
            </header>
            <form method="post" action="{{ route('donate') }}">
                @csrf
                <div class="card-text h-full space-y-4">
                    <div class="input-area">
                        <label for="amount" class="form-label">{{ __('Amount') }}</label>
                        <input id="amount" name="amount" type="number" class="form-control" value="{{ old('amount', 10) }}">
                        @error('amount')
                        <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-area">
                        <label for="currency" class="form-label">{{ __('Currency') }}</label>
                        <select id="currency" name="currency" class="form-control">
                            @foreach(\App\Enums\Currency::cases() as $currency)
                                <option value="{{ $currency->value }}" class="dark:bg-slate-700">{{ $currency }}</option>
                            @endforeach
                        </select>
                        @error('currency')
                        <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-area">
                        <label for="select" class="form-label">{{ __('Payment System') }}</label>
                        <select id="payment_system" name="payment_system" class="form-control">
                            <option value="">{{ __('Select an option') }}</option>
                            <option value="palych">Palych.io</option>
                            <option value="payop">PayOp.com</option>
                        </select>
                        @error('payment_system')
                        <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn inline-flex justify-center btn-danger shadow-base2 mt-2">{{ __('Donate') }}</button>
            </form>
        </div>
    </div>
</x-app-layout>
