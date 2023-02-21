@props([
    'name', 
    'label' => null, 
    'information' => null, 
    'label2' => 'Active', 
    'value' => 1, 
    'checked' => 1
])

<div class="me-5">
    @if ($label)
        <label class="fs-6 fw-semibold">{{ $label }}</label>
        @if ($information)        
            <div class="fs-7 fw-semibold text-muted">{{ $information }}</div>
        @endif
    @endif
</div>
<label class="form-check form-switch form-check-custom form-check-solid">
    <input {{ $attributes->merge(['class' => 'form-check-input', 'name' => $name, 'value' => $value, 'type' => 'checkbox', 'id' => $name]) }} {{ $checked ? 'checked' : '' }} />
    <span class="form-check-label fw-semibold text-muted">{{ $label2 }}</span>
</label>