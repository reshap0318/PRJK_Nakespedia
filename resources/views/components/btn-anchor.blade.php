@props(['value', 'href'])

<a href="{{ $href ?? "javascript:void(0)" }}" {{ $attributes->merge(['class' => 'btn btn-sm fw-bold']) }}>
    {{ $value ?? $slot }}
</a>
