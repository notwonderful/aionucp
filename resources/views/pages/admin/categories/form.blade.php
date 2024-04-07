<x-admin-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ isset($category->name) ? __('Edit') . ' ' . $category->name : __('Add category') }}</div>
                </div>
            </header>
            <div class="card-text h-full space-y-4">
                <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                    @csrf
                    @isset($category)
                        @method('PATCH')
                    @endisset
                    <div class="input-area">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') border-danger-500 pr-9 @enderror"
                               value="{{ isset($category->name) ? $category->name : old('name') }}">
                    </div>
                    @error('name')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="select" class="form-label">{{ __('Parent') }}</label>
                        <select id="select" name="parent_id" class="form-control">
                            @isset ($category->parent)
                                <option value="{{ $category->parent->id }}" selected>{{ $category->parent->name }}</option>
                            @endisset
                        </select>
                    </div>
                    @error('parent_id')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <button class="btn inline-flex justify-center btn-dark ml-28 mt-2">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
