@props(['title'])

<nav class="flex items-center gap-2 py-1" aria-label="Breadcrumb">
    <ol class="flex items-center flex-wrap gap-2 font-body text-xs sm:text-sm text-on-surface-variant">
        <li>
            <a href="{{ route('landing') }}" class="hover:text-primary transition-colors">
                Beranda
            </a>
        </li>
        <li class="text-outline" aria-hidden="true">/</li>
        <li>
            <a href="{{ route('landing') }}#portofolio" class="hover:text-primary transition-colors">
                Portofolio Proyek
            </a>
        </li>
        <li class="text-outline" aria-hidden="true">/</li>
        <li class="font-semibold text-primary truncate max-w-[200px] sm:max-w-xs" aria-current="page">
            {{ $title }}
        </li>
    </ol>
</nav>
