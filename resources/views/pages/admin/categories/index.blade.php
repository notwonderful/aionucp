<x-admin-layout>
    <div class="card-body px-6 pb-6">
        <div class="overflow-x-auto -mx-6 dashcode-data-table">
            <span class=" col-span-8  hidden"></span>
            <span class="  col-span-4 hidden"></span>
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden ">
                    <div id="data-table_wrapper" class="dataTables_wrapper no-footer">
                        <div class="min-w-full">
                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 dataTable no-footer" id="data-table">
                                <div class="flex justify-end mt-1.5">
                                    <a href="{{ route('admin.categories.create') }}" class="btn inline-flex justify-center btn-outline-dark !bg-black-500 !text-white">
                                  <span class="flex items-center">
                                    <iconify-icon class="text-2xl ltr:mr-2 rtl:ml-2" icon="ic:round-plus"></iconify-icon>
                                    <span>{{ __('Add') }}</span>
                                  </span>
                                    </a>
                                </div>
                                <thead class="bg-slate-200 dark:bg-slate-700">
                                <tr>
                                    <th scope="col" class="table-th sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="table-th sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1">
                                        {{ __('Slug') }}
                                    </th>
                                    <th scope="col" class="table-th sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1">
                                        {{ __('Parent') }}
                                    </th>
                                    <th scope="col" class="table-th sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @forelse($categories as $category)
                                    <tr class="odd">
                                        <td class="table-td">{{ $category->name }}</td>
                                        <td class="table-td">{{ $category->slug }}</td>
                                        <td class="table-td">{{ $category->parent_id }}</td>
                                        <td class="table-td ">
                                            <div>
                                                <div class="relative">
                                                    <div class="dropdown relative">
                                                        <button class="text-xl text-center block w-full " type="button" id="tableDropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <iconify-icon icon="heroicons-outline:dots-vertical"></iconify-icon>
                                                        </button>
                                                        <ul class=" dropdown-menu min-w-[120px] absolute text-sm text-slate-700 dark:text-white hidden bg-white dark:bg-slate-700
                                  shadow z-[2] float-left overflow-hidden list-none text-left rounded-lg mt-1 m-0 bg-clip-padding border-none">
                                                            <li>
                                                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-slate-600 dark:text-white block font-Inter font-normal px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600
                                      dark:hover:text-white">{{ __('Edit') }}</a>
                                                            </li>
                                                            <li>
                                                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                <a href="{{ route('admin.categories.destroy', $category) }}" class="text-slate-600 dark:text-white block font-Inter font-normal px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600
                                      dark:hover:text-white"  onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Delete') }}</a>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{ __('Nothing to show') }}
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
