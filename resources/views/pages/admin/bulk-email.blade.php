<x-admin-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ __('Bulk Email') }}</div>
                </div>
            </header>
            <div class="card-text h-full space-y-4">
                <form action="{{ route('admin.bulk-email') }}" method="POST">
                    @csrf
                    <div class="input-area">
                        <label for="email_content" class="form-label">E-mail {{ __('Content') }}</label>
                        <textarea id="email_content" name="email_content" rows="5" class="form-control @error('email_content') border-danger-500 pr-9 @enderror"></textarea>
                    </div>
                    @error('email_content')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <button class="btn inline-flex justify-center btn-dark ml-28 mt-2">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
