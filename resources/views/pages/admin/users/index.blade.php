<x-admin-layout>
    <div class="max-h-[600px] overflow-y-auto bg-gray-100">
        <div class="py-10">

            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">{{ __('Users') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add user</button>
                    </div>
                </div>
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                                <x-admin.data-table
                                    :data="$users"
                                    :columns="[
                                        ['key' => 'name', 'title' => __('Name'), 'type' => 'text'],
                                        ['key' => 'email', 'title' => 'Email', 'type' => 'text'],
                                        ['key' => 'role', 'title' => __('Role'), 'type' => 'text'],
                                    ]"
                                    :actions="[
                                        'title' => __('Edit'),
                                        'url' => fn($user) => route('admin.users.edit', $user),
                                    ]"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
