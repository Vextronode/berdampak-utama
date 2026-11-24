@props(['project'])

<section class="bg-surface border border-outline-variant rounded-xl p-6 flex flex-col gap-4">
    <span class="font-headline text-xs font-semibold tracking-wider text-on-surface-variant uppercase">
        Dosen Pembimbing
    </span>

    <div class="flex items-center gap-3.5">
        @if($project->supervisor_photo_url)
            <img src="{{ $project->supervisor_photo_url }}" 
                 alt="{{ $project->supervisor_name }}" 
                 class="w-14 h-14 rounded-full object-cover border border-outline-variant shrink-0 ring-2 ring-primary/10">
        @else
            <div class="w-14 h-14 rounded-full bg-primary-container text-on-primary-container font-bold text-lg flex items-center justify-center shrink-0">
                {{ strtoupper(substr($project->supervisor_name ?? 'D', 0, 1)) }}
            </div>
        @endif
        <div class="flex flex-col gap-0.5 min-w-0">
            <h3 class="font-headline font-semibold text-base text-primary truncate">
                {{ $project->supervisor_name ?? 'Dr. Hendra Wijaya, M.Kom.' }}
            </h3>
            <p class="font-body text-xs text-on-surface-variant leading-tight">
                {{ $project->supervisor_title ?? 'Dosen Pembina & Penanggung Jawab Proyek' }}
            </p>
        </div>
    </div>
</section>
