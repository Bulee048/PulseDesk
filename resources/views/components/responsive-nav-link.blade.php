@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-signal text-start text-base font-medium text-signal bg-indigo-50 focus:outline-none focus:text-signal focus:bg-signal focus:border-signal transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate hover:text-slate hover:bg-cloud hover:border-line focus:outline-none focus:text-slate focus:bg-cloud focus:border-line transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
