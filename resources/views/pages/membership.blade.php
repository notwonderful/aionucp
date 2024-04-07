<x-app-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ __('Membership') }}</div>
                </div>
            </header>
            <form method="post" action="{{ route('membership') }}">
                @csrf
                <div class="card-text h-full space-y-4">
                    <div class="input-area">
                        <label for="membership_type" class="form-label">{{ __('Membership') }}</label>
                        <select id="membership_type" name="membership_type" class="form-control">
                            @foreach(\App\Enums\Game\MembershipType::cases() as $membership)
                                @if ($membership->value !== \App\Enums\Game\MembershipType::REGULAR->value)
                                    <option value="{{ $membership->value }}" class="dark:bg-slate-700">{{ $membership->label() }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('membership_type')
                        <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-area">
                        <label for="duration" class="form-label">{{ __('Duration') }}</label>
                        <select id="duration" name="duration" class="form-control">
                            @foreach(\App\Enums\Game\MembershipDuration::cases() as $duration)
                                <option value="{{ $duration->value }}" class="dark:bg-slate-700">{{ $duration->label() }}</option>
                            @endforeach
                        </select>
                        @error('duration')
                        <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn inline-flex justify-center btn-danger shadow-base2 mt-2">{{ __('Buy') }}</button>
            </form>
        </div>
    </div>
</x-app-layout>
