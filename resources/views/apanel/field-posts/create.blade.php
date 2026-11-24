<x-apanel-layout title="Tulis Catatan Lapangan Baru">
    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-8 lg:py-10">
        <section class="flex flex-col gap-2 mb-8">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                <a href="{{ route('apanel.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span class="text-outline">/</span>
                <a href="{{ route('apanel.field-posts.index') }}" class="hover:text-primary transition-colors">Catatan Lapangan</a>
                <span class="text-outline">/</span>
                <span class="text-primary font-semibold">Tulis Catatan Baru</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="font-['Poppins'] font-bold text-2xl lg:text-3xl text-primary tracking-tight">Tulis Catatan Lapangan</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Dokumentasikan aktivitas lapangan, pelatihan operator desa, dan kolaborasi mahasiswa bersama masyarakat mitra.</p>
                </div>
                <a href="{{ route('apanel.field-posts.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors shrink-0 whitespace-nowrap self-start sm:self-center py-2 px-3.5 rounded-xl border border-outline-variant bg-surface shadow-xs hover:border-primary/40">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Kembali ke Daftar</span>
                </a>
            </div>
        </section>

        @include('apanel.field-posts._form', ['post' => null])
    </div>
</x-apanel-layout>
