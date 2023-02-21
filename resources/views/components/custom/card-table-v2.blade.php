@props(['name'])
<div {{ $attributes->merge(['class' => 'col-md-12 mb-md-5 mb-xl-10']) }}>
    <div class="card">
        <div class="card-body py-4 dt-responsive table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="tbl_{{ Str::lower($name) }}">
                <thead>
                    {{ $header ?? null }}
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>