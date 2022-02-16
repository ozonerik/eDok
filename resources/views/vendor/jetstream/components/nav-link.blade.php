@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active font-weight-bolder border border-3  border-info border-start-0 border-top-0 border-end-0'
            : 'nav-link';
@endphp

<li class="nav-item">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
