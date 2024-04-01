<x-admin-layout>
    <form class="space-y-8 divide-y divide-gray-200" action="
    {{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST"
    >
        @csrf
        @isset($category)
            @method('PATCH')
            <input type="hidden" name="edit" value="1">
        @endisset
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        text
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        description
                    </p>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Name') }}
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" name="name" id="name"
                                   class="max-w-lg block w-full shadow-sm focus:ring-indigo-500
                                   focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md"
                                   value="{{ isset($category->name) ? $category->name : old('name') }}"
                            >
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Parent') }}
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="parent_id" name="parent_id" class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                    <option value="">{{ __('No parent category') }}</option>
                                    @isset ($category->parent)
                                        <option value="{{ $category->parent->id }}" selected>{{ $category->parent->name }}</option>
                                    @endisset
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-admin-layout>
