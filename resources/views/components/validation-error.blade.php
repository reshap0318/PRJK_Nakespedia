@error($name)
    <div class="fv-plugins-message-container invalid-feedback" id="{{ $name }}">{{ $message }}</div>
@else
    <div class="fv-plugins-message-container invalid-feedback" id="error_{{ $name }}"></div>
@enderror