@props(['required' => 'required', 'value' => null])

<label {{ $attributes->merge(['class' => 'fs-6 fw-semibold form-label mb-2']) }}>
    <span class="{{ $required }}">
        {{ $value ?? $slot }}
    </span>
    {{ $optional ?? null }}
</label>