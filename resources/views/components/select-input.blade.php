@props(['disabled' => false, 'name', 'value' => null, 'options' => []])

@php
    $classes = ($disabled ? 'opacity-50 cursor-not-allowed' : '');
@endphp

<div>
    <select
        {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'.$classes]) !!}
        name="{{ $name }}"
    >
        <option value="">{{ __('Select an option') }}</option>
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @selected($value == $key)>{{ $option }}</option>
        @endforeach
    </select>
</div>
