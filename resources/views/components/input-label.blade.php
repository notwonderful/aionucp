@props(['value'])

<label class="block capitalize form-label">{{ $value ?? $slot }}</label>
