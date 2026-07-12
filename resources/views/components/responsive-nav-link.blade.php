@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-3 rounded-xl text-start text-sm font-semibold text-primary-700 bg-primary-50 border border-primary-200/60 transition duration-150 ease-in-out'
            : 'block w-full px-4 py-3 rounded-xl text-start text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
