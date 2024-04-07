<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark block w-full text-center ']) }}>
    {{ $slot }}
</button>
