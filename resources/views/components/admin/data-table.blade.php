@props([
    'data' => [],
    'columns' => [],
    'actions' => [],
])

<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
    <div class="grid grid-cols-12 gap-5 px-6 mt-6">
        <div class="col-span-4">
            <div class="dataTables_length" id="DataTables_Table_0_length">
                <label>Show
                    <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> entries
                </label>
            </div>
        </div>
        <div class="col-span-8 flex justify-end">
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>Search:<input type="search" class="" placeholder="" aria-controls="DataTables_Table_0"></label>
            </div>
        </div>
        <div id="pagination" class="flex items-center"></div>
    </div>
    <div class="min-w-full">
        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table dataTable no-footer" id="DataTables_Table_0">
            <thead class=" bg-slate-200 dark:bg-slate-700">
            <tr>
                @foreach ($columns as $column)
                    <th scope="col" class="table-th sorting @if($column['sortable']) sorting_{{ $column['sortDirection'] ?? 'none' }} @endif" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="{{ $column['title'] }}: activate to sort column {{ $column['sortDirection'] === 'asc' ? 'descending' : 'ascending' }}" style="width: {{ $column['width'] ?? 'auto' }};">
                        {{ $column['title'] }}
                    </th>
                @endforeach
                @if (!empty($actions))
                    <th scope="col" class="table-th sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 193.25px;">Action</th>
                @endif
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
            @forelse ($data as $item)
                <tr class="{{ $loop->iteration % 2 === 0 ? 'even' : 'odd' }}">
                    @foreach ($columns as $column)
                        <td class="table-td @if($column['type'] === 'text') text-gray-500 @else font-medium text-gray-900 @endif">
                            {{ $item[$column['key']] }}
                        </td>
                    @endforeach
                    @if (!empty($actions))
                        <td class="table-td">
                            <div class="flex space-x-3 rtl:space-x-reverse">
                                @foreach ($actions as $action)
                                    <button class="action-btn" type="button" onclick="{{ $action['callback']($item) }}">
                                        <iconify-icon icon="{{ $action['icon'] }}"></iconify-icon>
                                    </button>
                                @endforeach
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                {{ __('Nothing to show') }}
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex justify-end items-center">
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            <a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" aria-disabled="true" aria-role="link" data-dt-idx="previous" tabindex="-1" id="DataTables_Table_0_previous">
                <iconify-icon icon="ic:round-keyboard-arrow-left"></iconify-icon>
            </a>
            <span>
                <a class="paginate_button current" aria-controls="DataTables_Table_0" aria-role="link" aria-current="page" data-dt-idx="0" tabindex="0">1</a>
                <a class="paginate_button " aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="1" tabindex="0">2</a>
                <a class="paginate_button " aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="2" tabindex="0">3</a>
                <a class="paginate_button " aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="3" tabindex="0">4</a>
                <a class="paginate_button " aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="4" tabindex="0">5</a>
            </span>
            <a class="paginate_button next" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="next" tabindex="0" id="DataTables_Table_0_next">
                <iconify-icon icon="ic:round-keyboard-arrow-right"></iconify-icon>
            </a>
        </div>
    </div>
</div>
