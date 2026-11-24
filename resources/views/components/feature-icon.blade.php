@props([
    'icon' => 'check',
    'class' => 'w-5 h-5',
])

@php
    $meta = \App\Support\FeatureIcons::get((string) $icon);
@endphp

<svg class="{{ $class }} {{ $meta['color'] }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
    {!! $meta['paths'] !!}
</svg>
