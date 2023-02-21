@props([
    'name', 
    'serachPlaceHolder' => null, 
    'createName' => null, 
    'tableId' => null, 
    'href' => null, 
    'permission' => false
])
<div class="col-md-12 mb-md-5 mb-xl-10">
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                @if ($permission)
                    <a href="{{ $href }}" class="btn btn-primary">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                        Add {{ $createName ?? Str::headline($name) }}
                    </a>
                @endif
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <input type="text" class="form-control form-control-solid w-md-250px ps-14" placeholder="Search {{ $serachPlaceHolder ?? Str::headline($name) }}" id="form-search"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table responsive align-middle table-row-dashed fs-6 gy-5 mb-0" id="{{ $tableId ?? "tbl_".Str::lower($name) }}" width="100%">
                    <thead>
                        {{ $slot }}
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        {{ $body ?? null }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>