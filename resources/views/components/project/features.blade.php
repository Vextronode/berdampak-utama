@props(['features'])

<section class="bg-surface border border-outline-variant rounded-xl p-6 sm:p-8 flex flex-col gap-6">
    <h2 class="font-headline font-bold text-xl sm:text-2xl text-primary">
        Fitur Kunci Sistem
    </h2>

    <ul class="flex flex-col gap-5">
        @if(!empty($features))
            @foreach($features as $feature)
                <li class="flex items-start gap-4">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-primary-container text-on-primary-container shrink-0 mt-0.5">
                        @if(($feature['icon'] ?? '') === 'emergency')
                            <svg class="w-5 h-5 text-vibrant-utama-orange" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        @elseif(($feature['icon'] ?? '') === 'location')
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        @elseif(($feature['icon'] ?? '') === 'notification' || ($feature['icon'] ?? '') === 'chat')
                            <svg class="w-5 h-5 text-success" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        @elseif(($feature['icon'] ?? '') === 'document')
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        @elseif(($feature['icon'] ?? '') === 'database')
                            <svg class="w-5 h-5 text-primary-royal-indigo" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        @elseif(($feature['icon'] ?? '') === 'store')
                            <svg class="w-5 h-5 text-vibrant-utama-orange" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.614A2.996 2.996 0 009 9.35c.983-.913 2.502-.913 3.486 0a2.996 2.996 0 003.764-.614 3.001 3.001 0 003.75.614m-16.5 0L4.387 4.12A1.5 1.5 0 015.86 3h12.28a1.5 1.5 0 011.472 1.12l1.637 5.23" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </span>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-headline font-semibold text-base sm:text-lg text-primary">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="font-body text-sm text-on-surface-variant leading-relaxed">
                            {{ $feature['description'] }}
                        </p>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</section>
