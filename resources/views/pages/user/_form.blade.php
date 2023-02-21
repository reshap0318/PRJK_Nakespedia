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
    <x-custom.input-label value="role"/>
    {!! Form::select('role', $role, null, ['class' => 'form-control form-control-solid select2', 'placeholder' => 'Selected a role']) !!}
    <x-validation-error name="role"></x-validation-error>
</div>

<div class="fv-row mb-7">
    <x-custom.input-label value="Password"/>
    <x-custom.input-password name="password" placeholder="Enter a user password"/>
</div>

<div class="fv-row mb-7">
    <x-custom.input-label value="Confirm Password"/>
    <x-custom.input-password name="confirm_password" placeholder="Enter confirm password"/>
</div>