@props(['page_active', 'breadcrumbs'])

<!--begin::Title-->
<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ $page_active }}</h1>
<!--end::Title-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
    @foreach ($breadcrumbs as $index => $item)
        <!--end::Item-->
        @if($index > 0)
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
        @endif
        @if ($loop->last)
            <li class="breadcrumb-item text-muted">Dashboards</li>
        @else
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ $item['link'] }}" class="text-muted text-hover-primary">{{ $item['name'] }}</a>
            </li>
            <!--begin::Item-->
        @endif
    @endforeach
</ul>
<!--end::Breadcrumb-->