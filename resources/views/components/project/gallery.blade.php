@props(['images', 'partner'])

@if(!empty($images))
<section class="bg-surface border border-outline-variant rounded-xl p-6 sm:p-8 flex flex-col gap-5">
    <div class="flex flex-col gap-1">
        <h2 class="font-headline font-bold text-xl sm:text-2xl text-primary">
            Galeri Dokumentasi Tim di Desa
        </h2>
        <p class="font-body text-sm text-on-surface-variant">
            Dokumentasi mahasiswa pengembang saat berkoordinasi, melatih staf desa, dan menguji sistem bersama masyarakat {{ $partner }}.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
        @foreach($images as $img)
            @php
                $imgSrc = $img['image_url'] ?? $img['url'] ?? '';
                $imgCaption = $img['caption'] ?? 'Dokumentasi lapangan proyek';
            @endphp
            @if(!empty($imgSrc))
                <figure class="border border-outline-variant rounded-lg overflow-hidden bg-surface-variant flex flex-col">
                    <div class="aspect-video overflow-hidden bg-surface-container">
                        <img src="{{ $imgSrc }}" 
                             alt="{{ $imgCaption }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <figcaption class="p-3.5 font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed border-t border-outline-variant bg-surface">
                        {{ $imgCaption }}
                    </figcaption>
                </figure>
            @endif
        @endforeach
    </div>
</section>
@endif
