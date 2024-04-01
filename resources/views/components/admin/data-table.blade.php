@props([
    'data' => [],
    'columns' => [],
    'actions' => null,
])

<div class="overflow-x-auto">
    <table class="min-w-full border-separate" style="border-spacing: 0">
        <thead class="bg-gray-50">
        <tr>
            @foreach ($columns as $column)
                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">
                    {{ $column['title'] }}
                </th>
            @endforeach
            @if ($actions)
                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                    <span class="sr-only">{{ $actions['title'] }}</span>
                </th>
            @endif
        </tr>
        </thead>
        <tbody class="bg-white">
        @forelse ($data as $item)
            <tr>
                @foreach ($columns as $column)
                    <td class="whitespace-nowrap sm:pl-6 lg:pl-8 border-b border-gray-200 px-3 py-4 text-sm @if($column['type'] === 'text') text-gray-500 @else font-medium text-gray-900 @endif">
                        {{ $item[$column['key']] }}
                    </td>
                @endforeach
                @if ($actions)
                    <td class="relative whitespace-nowrap sm:pl-6 lg:pl-8 border-b border-gray-200 py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                        <a href="{{ $actions['url']($item) }}" class="text-indigo-600 hover:text-indigo-900">{{ $actions['title'] }}<span class="sr-only">, {{ $item['name'] }}</span></a>
                    </td>
                @endif
            </tr>
            @empty
                {{ __('Nothing to show') }}
        @endforelse
        </tbody>
    </table>
</div>
