@props(['project'])

<section class="bg-surface border border-outline-variant rounded-xl p-6 flex flex-col gap-3 font-body text-sm">
    <div class="flex items-center justify-between gap-2 pb-3 border-b border-outline-variant">
        <span class="text-on-surface-variant">Tahun Pengerjaan</span>
        <span class="font-semibold text-primary tabular-nums">{{ $project->year }}</span>
    </div>
    <div class="flex items-center justify-between gap-2 pb-3 border-b border-outline-variant">
        <span class="text-on-surface-variant">Mitra Desa</span>
        <span class="font-semibold text-on-surface text-right">{{ $project->partner_name }}</span>
    </div>
    <div class="flex items-center justify-between gap-2">
        <span class="text-on-surface-variant">Kategori</span>
        <span class="font-semibold text-on-surface text-right capitalize">{{ str_replace('-', ' ', $project->category) }}</span>
    </div>
</section>
