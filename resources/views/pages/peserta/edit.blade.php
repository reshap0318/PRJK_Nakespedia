<x-template-layout>
    @slot('title') Participant edit @endslot
    
    <div class="card card-flush h-lg-100" id="">
        <div class="card-header pt-7" id="">
            <div class="card-title">
                <span class="svg-icon svg-icon-2 me-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                    </svg>
                </span>
                <h2>Edit Participant</h2>
            </div>
        </div>
        <div class="card-body pt-5">
            {{ Form::model($peserta, ['method' => 'PATCH', 'url' => route('peserta.update', $peserta), 'files' => true, 'autocomplete' => 'off']) }}
                @include('pages.peserta._form')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('peserta.index') }}" type="reset" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</x-template-layout>