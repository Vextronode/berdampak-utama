@props(['project'])

<header class="bg-surface border border-outline-variant rounded-2xl p-6 sm:p-8 flex flex-col gap-4 shadow-xs">
    <div class="flex flex-wrap items-center gap-2">
        <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-container text-on-primary-container font-body text-xs font-semibold tabular-nums">
            Tahun {{ $project->year }}
        </span>
        <span class="inline-flex items-center px-3 py-1 rounded-full bg-diktisaintek-container text-on-diktisaintek-container font-body text-xs font-semibold">
            Mitra: {{ $project->partner_name }}
        </span>
        <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-container text-on-surface-container font-body text-xs font-semibold capitalize">
            {{ str_replace('-', ' ', $project->category) }}
        </span>
    </div>

    <h1 class="font-headline font-bold text-3xl sm:text-4xl lg:text-5xl text-primary tracking-tight">
        {{ $project->title }}
    </h1>

    <p class="font-body text-base sm:text-lg text-on-surface-variant leading-relaxed max-w-4xl text-pretty">
        {{ $project->summary }}
    </p>
</header>
