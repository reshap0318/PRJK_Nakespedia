<x-template-layout>
    @slot('title') profile edit @endslot
    
    <div class="card card-flush h-lg-100" id="">
        <div class="card-header pt-7" id="">
            <div class="card-title">
                <span class="svg-icon svg-icon-2 me-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                    </svg>
                </span>
                <h2>Edit Profile</h2>
            </div>
        </div>
        <div class="card-body pt-5">
            {{ Form::model($user, ['method' => 'PATCH', 'url' => route('profile.update', $user), 'files' => true, 'autocomplete' => 'off']) }}
                <div class="mb-7 text-center">
                    <div class="mt-1">
                        <style>
                            .image-input-placeholder { 
                                background-image: url("{{ $img }}"); 
                            } 
                        </style>
                
                        <div class="image-input image-input-outline image-input-placeholder image-input-empty image-input-empty" data-kt-image-input="true">
                            <div class="image-input-wrapper w-100px h-100px" style=""></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        </div>
                    </div>
                    <label class="fs-6 fw-semibold mb-3">
                        <span>Change Avatar</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg."></i>
                    </label>
                </div>
                
                <div class="fv-row mb-7">
                    <x-custom.input-label value="Full Name"/>
                    <x-custom.input-form name="name" placeholder="Enter a user fullname"/>
                </div>
                
                <div class="fv-row mb-7">
                    <x-custom.input-label value="Username"/>
                    <x-custom.input-form name="username" placeholder="Enter a user username"/>
                </div>
                
                <div class="fv-row mb-7">
                    <x-custom.input-label value="Email"/>
                    <x-custom.input-form name="email" placeholder="Enter a user email" type="email"/>
                </div>
                
                <div class="fv-row mb-7">
                    <x-custom.input-label value="Password"/>
                    <x-custom.input-password name="password" placeholder="Enter a user password"/>
                </div>
                
                <div class="fv-row mb-7">
                    <x-custom.input-label value="Confirm Password"/>
                    <x-custom.input-password name="confirm_password" placeholder="Enter confirm password"/>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</x-template-layout>