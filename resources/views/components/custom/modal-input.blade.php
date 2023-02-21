@props(['name', 'mw' => '650', 'titleStatus' => 'Create', 'discard' => 'true'])

<div class="modal fade" id="modal_input" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-{{ $mw }}px">
        <div class="modal-content rounded">
            <div class="modal-header">
                <h2 class="fw-bold"><span id="title_status">{{ $titleStatus }}</span> {{ Str::headline($name) }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-comp-modal-action="close">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-1">
                {{ $information ?? null }}
                <form id="modal_input_form" class="form" action="#">
                    {{ $slot }}
                    <div class="text-center pt-5">
                        @if ($discard == 'true')
                            <button type="reset" class="btn btn-light me-3" data-comp-modal-action="cancel">Discard</button>
                        @endif
                        <button type="submit" class="btn btn-primary" data-comp-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>