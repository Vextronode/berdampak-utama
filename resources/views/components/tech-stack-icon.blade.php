@props([
    'stack',
    'class' => 'w-8 h-8',
])

@php
    $type = $stack->icon_type ?? 'monogram';
    $val = $stack->icon_value ?? null;
    $color = $stack->brand_color ?? '#1E1B64';
    $name = $stack->name ?? 'Tech';
    $monogram = $stack->monogram ?? strtoupper(substr($name, 0, 2));
@endphp

@if ($type === 'svg_raw' && !empty($val))
    <div class="{{ $class }} flex items-center justify-center shrink-0 [&>svg]:w-full [&>svg]:h-full" style="color: {{ $color }};" aria-hidden="true">
        {!! $val !!}
    </div>
@elseif ($type === 'cdn_url' && !empty($val))
    <img src="{{ $val }}" alt="{{ $name }}" class="{{ $class }} object-contain shrink-0" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
    <div class="{{ $class }} hidden items-center justify-center rounded-lg text-white text-xs font-bold shrink-0 tracking-wider" style="background-color: {{ $color }};" aria-hidden="true">
        {{ $monogram }}
    </div>
@elseif ($type === 'custom_upload' && !empty($val))
    <img src="{{ $val }}" alt="{{ $name }}" class="{{ $class }} object-contain shrink-0" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
    <div class="{{ $class }} hidden items-center justify-center rounded-lg text-white text-xs font-bold shrink-0 tracking-wider" style="background-color: {{ $color }};" aria-hidden="true">
        {{ $monogram }}
    </div>
@else
    <div class="{{ $class }} flex items-center justify-center rounded-lg text-white text-xs font-bold shrink-0 shadow-xs tracking-wider" style="background-color: {{ $color }};" aria-hidden="true">
        {{ $monogram }}
    </div>
@endif
