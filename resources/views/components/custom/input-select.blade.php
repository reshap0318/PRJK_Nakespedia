@props(['name'])

<select {{ $attributes->merge(['class' => 'form-select form-select-solid', 'name' => $name, 'id' => $name]) }}>
    {{ $slot }}
</select>
<div class="fv-plugins-message-container invalid-feedback" id="error_{{ $name }}"></div>