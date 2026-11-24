<section id="tentang" class="py-20 sm:py-24 lg:py-28 bg-surface border-b border-outline-variant scroll-mt-16 sm:scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Top: Editorial Split (5 : 7) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-start">
            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="inline-flex items-center gap-2 text-xs font-semibold tracking-wider text-vibrant-utama-orange uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-vibrant-utama-orange" aria-hidden="true"></span>
                    <span>Tentang Kampus Berdampak</span>
                </div>

                <h2 class="font-serif font-bold text-3xl sm:text-4xl lg:text-5xl text-primary leading-[1.15] text-balance">
                    Bukan Sekadar Proyek Tugas Akhir, Ini Solusi Digital yang Bekerja Nyata di Lapangan.
                </h2>

                <div class="pt-2">
                    <a href="#portofolio" 
                       data-scroll-to="portofolio" 
                       class="group inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-vibrant-utama-orange transition-colors cursor-pointer">
                        <span>Lihat Daftar Proyek Mahasiswa</span>
                        <svg class="w-4 h-4 text-primary group-hover:text-vibrant-utama-orange group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 flex flex-col gap-5 text-on-surface-variant font-body text-base sm:text-lg leading-relaxed">
                <p class="text-primary font-medium text-lg sm:text-xl leading-relaxed">
                    Lewat program <strong class="text-primary font-semibold">Kampus Berdampak</strong> bersama Diktisaintek, mahasiswa Universitas Widyatama membawa keahlian teknologi terapan langsung ke tengah masyarakat.
                </p>
                <p>
                    Seluruh aplikasi dirancang dan dikembangkan murni oleh mahasiswa, didampingi dosen sebagai pembina. Setiap karya dibangun dari riset persoalan di lapangan, diuji bersama perangkat desa, hingga aktif beroperasi melayani kebutuhan warga mitra.
                </p>
                <p class="text-sm sm:text-base text-on-surface-variant/80">
                    Platform ini menjadi bukti akuntabilitas karya akademik. Publik dapat langsung membuka dan menguji setiap sistem yang sudah berjalan, lengkap dengan transparansi identitas mahasiswa pembuatnya.
                </p>
            </div>
        </div>

        {{-- Divider & 3 Cards with Section Header --}}
        <div class="mt-14 sm:mt-18 pt-10 sm:pt-12 border-t border-outline-variant">
            {{-- Header untuk 3 Kartu --}}
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8 sm:mb-10">
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-wider text-vibrant-utama-orange uppercase mb-1">
                        Landasan Program
                    </span>
                    <h3 class="font-serif font-bold text-2xl sm:text-3xl text-primary">
                        Tiga Standar Utama di Setiap Karya
                    </h3>
                </div>
                <p class="text-sm text-on-surface-variant max-w-md leading-relaxed">
                    Prinsip yang memastikan setiap aplikasi tidak berhenti sebagai tugas kuliah, melainkan sistem andal yang dapat diakses dan diuji publik.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                {{-- Card 1: Aplikasi --}}
                <div class="p-6 sm:p-7 rounded-2xl border border-outline-variant bg-surface-variant/40 hover:bg-surface-variant hover:border-outline transition-all duration-300 flex flex-col justify-between group">
                    <div class="flex flex-col gap-3.5">
                        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
                            <div class="w-10 h-10 rounded-xl bg-vibrant-utama-orange/10 flex items-center justify-center text-vibrant-utama-orange">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0H3" />
                                </svg>
                            </div>
                            <span class="font-mono text-xs font-bold text-vibrant-utama-orange tracking-widest">01</span>
                        </div>
                        <h3 class="font-headline font-bold text-lg text-primary group-hover:text-vibrant-utama-orange transition-colors">
                            Aplikasi Aktif Berjalan
                        </h3>
                        <p class="font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Website dan sistem informasi sudah live serta bisa langsung dicoba publik, bukan sekadar mockup atau gambar desain.
                        </p>
                    </div>

                    <div class="mt-5 pt-3.5 border-t border-outline-variant/60 flex items-center gap-2 text-xs font-semibold text-emerald-600">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
                        <span>Live & Siap Diakses</span>
                    </div>
                </div>

                {{-- Card 2: Dampak --}}
                <div class="p-6 sm:p-7 rounded-2xl border border-outline-variant bg-surface-variant/40 hover:bg-surface-variant hover:border-outline transition-all duration-300 flex flex-col justify-between group">
                    <div class="flex flex-col gap-3.5">
                        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
                            <div class="w-10 h-10 rounded-xl bg-diktisaintek-blue/10 flex items-center justify-center text-diktisaintek-blue">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <span class="font-mono text-xs font-bold text-diktisaintek-blue tracking-widest">02</span>
                        </div>
                        <h3 class="font-headline font-bold text-lg text-primary group-hover:text-vibrant-utama-orange transition-colors">
                            Menjawab Kebutuhan Warga
                        </h3>
                        <p class="font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Fitur dibangun dari masalah nyata di lapangan untuk membantu aktivitas warga dan operasional desa mitra.
                        </p>
                    </div>

                    <div class="mt-5 pt-3.5 border-t border-outline-variant/60 flex items-center gap-2 text-xs font-semibold text-diktisaintek-blue">
                        <span class="w-2 h-2 rounded-full bg-diktisaintek-blue" aria-hidden="true"></span>
                        <span>Terap Guna di Desa Mitra</span>
                    </div>
                </div>

                {{-- Card 3: Talenta --}}
                <div class="p-6 sm:p-7 rounded-2xl border border-outline-variant bg-surface-variant/40 hover:bg-surface-variant hover:border-outline transition-all duration-300 flex flex-col justify-between group">
                    <div class="flex flex-col gap-3.5">
                        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
                            <div class="w-10 h-10 rounded-xl bg-warm-gold/10 flex items-center justify-center text-warm-gold">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-5.25 6.557q.154.408.337.808" />
                                </svg>
                            </div>
                            <span class="font-mono text-xs font-bold text-warm-gold tracking-widest">03</span>
                        </div>
                        <h3 class="font-headline font-bold text-lg text-primary group-hover:text-vibrant-utama-orange transition-colors">
                            Identitas Mahasiswa Jelas
                        </h3>
                        <p class="font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Apresiasi penuh bagi mahasiswa pembuatnya, lengkap dengan nama, nomor pokok mahasiswa (NPM), serta dosen pembina.
                        </p>
                    </div>

                    <div class="mt-5 pt-3.5 border-t border-outline-variant/60 flex items-center gap-2 text-xs font-semibold text-tertiary">
                        <span class="w-2 h-2 rounded-full bg-warm-gold" aria-hidden="true"></span>
                        <span>Karya Resmi Ber-NPM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
