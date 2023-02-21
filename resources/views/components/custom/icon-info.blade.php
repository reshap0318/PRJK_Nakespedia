@props(['title'])

<i {{ $attributes->merge(['class' => 'fas fa-exclamation-circle ms-1 fs-7', 'data-bs-toggle' => 'popover', 'data-bs-trigger' => 'hover', 'data-bs-html' => 'true', ' data-bs-content' => $title]) }}></i>