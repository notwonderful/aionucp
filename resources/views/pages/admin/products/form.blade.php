<x-admin-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ isset($product->name) ? __('Edit') . ' ' . $product->name : __('Add product') }}</div>
                </div>
            </header>
            <div class="card-text h-full space-y-4">
                <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @isset($product)
                        @method('PATCH')
                        <input type="hidden" name="edit" value="1">
                    @endisset
                    <div class="input-area">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') border-danger-500 pr-9 @enderror"
                               value="{{ isset($product->name) ? $product->name : old('name') }}">
                    </div>
                    @error('name')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea id="description" name="description" rows="5" class="form-control">{{ isset($product->description) ? $product->description : old('description') }}</textarea>
                    </div>
                    @error('description')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="select" class="form-label">{{ __('Category') }}</label>
                        <select id="select" name="category_id" class="form-control">
                            @foreach(\App\Models\ProductCategory::get() as $category)
                                <option value="{{ $category->id }}" {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="item_id" class="form-label">{{ __('Item') }} ID</label>
                        <input id="item_id" name="item_id" type="number" class="form-control @error('item_id') border-danger-500 pr-9 @enderror"
                               value="{{ isset($product->item_id) ? $product->item_id : old('item_id') }}">
                    </div>
                    @error('item_id')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="item_qty" class="form-label">{{ __('Quantity') }}</label>
                        <input id="item_qty" name="item_qty" type="number" class="form-control @error('item_qty') border-danger-500 pr-9 @enderror"
                               value="{{ isset($product->item_qty) ? $product->item_qty : old('item_qty', 1) }}">
                    </div>
                    @error('item_qty')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="toll" class="form-label">{{ __('Price') }} Toll</label>
                        <input id="toll" name="toll" type="number" class="form-control @error('toll') border-danger-500 pr-9 @enderror"
                               value="{{ isset($product->toll) ? $product->toll : old('toll') }}">
                    </div>
                    @error('toll')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <div class="input-area">
                        <label for="image" class="form-label">{{ __('Image') }}</label>
                        @isset($product->image)
                            <img src="{{ $product->image_url }}">
                        @endisset
                        <input id="image" name="image" type="file" class="form-control @error('image') border-danger-500 pr-9 @enderror">
                    </div>
                    @error('image')
                    <span class="font-Inter text-sm text-danger-500 pt-2 inline-block">{{ $message }}</span>
                    @enderror
                    <button class="btn inline-flex justify-center btn-dark ml-28 mt-2">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
