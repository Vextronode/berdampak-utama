@props(['problem', 'partner'])

<section class="bg-surface border border-outline-variant rounded-xl p-6 sm:p-8 flex flex-col gap-4">
    <h2 class="font-headline font-bold text-xl sm:text-2xl text-primary">
        Latar Belakang & Masalah di Desa Mitra
    </h2>
    <div class="prose max-w-none text-on-surface-variant font-body text-sm sm:text-base leading-relaxed space-y-3">
        <p>
            {{ $problem ?? 'Aplikasi ini dirancang berdasarkan hasil survei lapangan dan koordinasi intensif bersama perangkat desa dan masyarakat setempat untuk menyelesaikan kendala nyata di lapangan secara berkelanjutan.' }}
        </p>
    </div>
</section>
