@props(['images', 'partner'])

<section class="bg-surface border border-outline-variant rounded-xl p-6 sm:p-8 flex flex-col gap-5">
    <div class="flex flex-col gap-1">
        <h2 class="font-headline font-bold text-xl sm:text-2xl text-primary">
            Galeri Dokumentasi Tim di Desa
        </h2>
        <p class="font-body text-sm text-on-surface-variant">
            Dokumentasi mahasiswa pengembang saat berkoordinasi, melatih staf desa, dan menguji sistem bersama masyarakat {{ $partner }}.
        </p>
    </div>

    @if(!empty($images))
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            @foreach($images as $img)
                <figure class="border border-outline-variant rounded-lg overflow-hidden bg-surface-variant flex flex-col">
                    <div class="aspect-video overflow-hidden bg-surface-container">
                        <img src="{{ $img['image_url'] }}" 
                             alt="{{ $img['caption'] }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <figcaption class="p-3.5 font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed border-t border-outline-variant bg-surface">
                        {{ $img['caption'] }}
                    </figcaption>
                </figure>
            @endforeach
        </div>
    @endif
</section>
