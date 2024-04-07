<x-admin-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ __('Edit') }} {{ $user->name }}</div>
                </div>
            </header>
            <div class="card-text h-full space-y-4">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="input-area">
                        <label for="email" class="form-label">EMail</label>
                        <input id="email" name="email" type="text" class="form-control @error('email') border-danger-500 pr-9 @enderror" value="{{ $user->email }}">
                    </div>
                    @error('email')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="balance" class="form-label">{{ __('Balance') }}</label>
                        <input id="balance" name="balance" type="number" class="form-control" value="{{ $user->balance }}">
                    </div>
                    @error('balance')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="select" class="form-label">{{ __('Role') }}</label>
                        <select id="select" class="form-control">
                            @foreach(\App\Enums\UserRole::cases() as $role)
                                <option value="{{ $role->value }}" @selected($user->role->value == $role->value) class="dark:bg-slate-700">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('role')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <button class="btn inline-flex justify-center btn-dark ml-28 mt-2">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
