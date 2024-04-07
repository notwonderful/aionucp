<x-admin-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ __('Mail Items') }}</div>
                </div>
            </header>
            <div class="card-text h-full space-y-4">
                <form action="{{ route('admin.mail-items.store') }}" method="POST">
                    @csrf
                    <div class="input-area">
                        <label for="name" class="form-label">{{ __('Player Name') }}</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') border-danger-500 pr-9 @enderror">
                    </div>
                    @error('name')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="item_id" class="form-label">{{ __('Item') }} ID</label>
                        <input id="item_id" name="item_id" type="number" class="form-control @error('item_id') border-danger-500 pr-9 @enderror"
                    </div>
                    @error('item_id')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="item_qty" class="form-label">{{ __('Item') }} {{ __('Quantity') }}</label>
                        <input id="item_qty" name="item_qty" type="number" class="form-control @error('item_qty') border-danger-500 pr-9 @enderror" value="1">
                    </div>
                    @error('item_qty')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <button class="btn inline-flex justify-center btn-dark ml-28 mt-2">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
