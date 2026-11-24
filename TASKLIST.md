# Tasklist Implementasi Landing Page: Berdampak Utama

Dokumen pelacak pengerjaan Landing Page (`berdampak.widyatama.ac.id`) menggunakan **Laravel 13 + Tailwind CSS + MySQL**, dengan target visual 100% sama persis (*pixel-perfect*) terhadap prototipe `assets/landing_page.html`.

---

## 🎯 Aturan & Keputusan Kunci
1. **Strictly NO EMOJI:** Dilarang menggunakan emoji Unicode di seluruh tampilan (badge status, tombol, heading). Semua representasi visual wajib menggunakan icon SVG resmi (Lucide / Simple Icons).
2. **Modularitas (Anti-Godfile):** Seluruh tampilan dipecah ke Blade Components terfokus di `resources/views/components/` (`<x-project-card>`, `<x-navbar>`, `<x-footer>`, `<x-hero>`, dll.). Controller tetap ramping (*skinny controller*).
3. **Pragmatis & No Overengineering:** Menggunakan standar native Laravel yang elegan (Eloquent ORM, Query Scopes, Blade Components). Tidak membuat abstraction layer berlapis yang mempersulit maintenance.
4. **No Hardcoded APIs / Data:** Seluruh data katalog, kontributor, dan catatan lapangan bersumber murni dari database MySQL.
5. **Filter Tahun Dinamis:** Diambil dinamis dari data `projects` (`SELECT DISTINCT year FROM projects ORDER BY year DESC`). Saat ini menampilkan tahun sekarang (**2026**). Begitu admin menambah proyek tahun/angkatan baru di masa depan, filter otomatis bertambah.
6. **Proyek Aktif 2026:** Tiga proyek unggulan pertama: **SIGAP**, **SIDUtama**, dan **CiMart** (mitra angkatan saat ini: Desa Cibenda).
7. **Kartu Proyek Ber-NPM:** Menampilkan screenshot 16:9, badge mitra desa, avatar melingkar bertumpuk, nama lengkap mahasiswa, **nomor NPM**, dan jurusan.
8. **Header Publik Bersih:** Menampilkan logo resmi Widyatama & Diktisaintek Berdampak, **tanpa tombol admin**.
9. **Hero Mainhall Widyatama & Efek TV Tabung (CRT Screen):** Foto resmi gedung *L'Arc d'Academia* (`assets/image/hero.jpg` / `public/images/hero.jpg`) dengan tekstur layar TV tabung CRT (halftone dot matrix + horizontal scanlines + vignette), overlay navy elegan, bebas em dash, dan form search bar terintegrasi.
10. **Code Comment Hygiene (`antislop-code`):** Bebas dari banner dekoratif, restatement obvious, workflow step narration, empty labels, dan AI meta markers.

---

## 📋 Tahapan Pengerjaan

### [x] Tahap 1: Setup Frontend Theme & Aset Brand
- [x] Daftarkan token warna institusi di `resources/css/app.css` / Tailwind menggunakan CSS Variables murni di `:root` (`--color-primary-navy-blue: #1E1B64`, dll.) sesuai `assets/design_system.md`.
- [x] Konfigurasi font Google Fonts (`Poppins` untuk headings, `Inter` untuk body/UI).
- [x] Salin logo resmi Widyatama (`assets/image/logo-widyatama.jpg`) dan Diktisaintek Berdampak (`assets/image/diktisaintek-berdampak-logo.png`) ke direktori `public/images/`.
- [x] Verifikasi build asset Vite (`npm run build` berhasil 100%).

### [x] Tahap 2: Database Schema & Seeder Proyek 2026
- [x] Buat migration tabel `projects`:
  - `id`, `title`, `slug`, `year` (integer), `summary`, `description`, `partner_name`, `category`, `tech_stacks` (json), `dashboard_thumbnail`, `live_url`, `is_published`.
- [x] Buat migration tabel `project_contributors`:
  - `id`, `project_id` (foreign key), `name`, `npm`, `major`, `role`, `avatar_url`, `sort_order`.
- [x] Buat migration tabel `field_posts` (Catatan Lapangan):
  - `id`, `project_id`, `title`, `slug`, `activity_date`, `cover_image`, `summary`, `content`.
- [x] Buat Seeder riil 2026:
  - Proyek **SIGAP** (2026, Desa Cibenda, kontributor Naufal Fadhiil, Raka Pratama, Siti Nurhaliza).
  - Proyek **SIDUtama** (2026, Desa Cibenda, kontributor Ahmad Fauzi, Dinda Kirana).
  - Proyek **CiMart** (2026, Desa Cibenda, kontributor Farhan Maulana, Budi Santoso).
  - 3 artikel catatan lapangan dokumentasi di Desa Cibenda.
- [x] Jalankan `php artisan migrate --seed` berhasil di MySQL (`test_berdampak_utama`).

### [x] Tahap 3: Controller & Logika Filter Dinamis
- [x] Buat `LandingController`:
  - Query mengambil daftar tahun aktif secara dinamis: `$availableYears = Project::published()->distinct()->orderByDesc('year')->pluck('year')`.
  - Query filter berdasarkan tahun yang dipilih (`?year=2026`).
  - Query filter berdasarkan kategori (`?category=...`).
  - Query pencarian keyword di hero section (`?q=...`).
  - Query mengambil 3 catatan lapangan terbaru untuk section dokumentasi.

### [x] Tahap 4: Blade Views & Components (1:1 Prototipe)
- [x] Master Layout (`resources/views/layouts/app.blade.php` & `app/View/Components/AppLayout.php`):
  - Co-branding Dual-State Header (`components/navbar.blade.php`): Header atas persis widyatama.ac.id dengan co-branding emblem putih Widyatama dan logo Diktisaintek di tengah, ikut tenggelam secara natural bersama hero saat di-scroll. Setelah melewati jarak ~200px scroll, navbar normal sticky institusional (co-branding logo kiri & link kanan) meluncur turun secara mulus (*smooth slide down*). Dilengkapi mobile drawer 3D book-fold yang membuka seperti buku dengan animasi perspektif halus.
  - Footer institusi lengkap (`components/footer.blade.php`): Logo Widyatama non-transparan (jelas di atas dark navy) + Logo Diktisaintek transparan yang dibesarkan (`h-12 sm:h-16`).
- [x] Hero Section (`components/hero.blade.php`):
  - Latar belakang murni foto resmi gedung `hero.jpg` tanpa tint biru, diberi neutral opacity (`bg-black/55`) dan tekstur layar TV tabung CRT (dot matrix + scanline + vignette). Ukuran hero presisi full viewport (`h-screen h-[100dvh] min-h-[100dvh]`) tanpa celah putih di bawahnya.
  - Bersih dan elegan tanpa badge dan tanpa search bar, headline resmi anti-slop (bebas em dash) menggunakan tipografi serif elegan *Playfair Display* identik website resmi Widyatama, dilengkapi animasi entrance bertahap (*staggered smooth fade up* dan *subtle Ken Burns background zoom*) saat pertama dibuka.
- [x] Section Tentang Kampus Berdampak (`components/about.blade.php`):
  - Layout editorial non-sticky: baris atas berisi 2 kolom (kiri: headline resmi & tautan ke portofolio; kanan: narasi kontekstual pengabdian masyarakat).
  - Baris bawah memuat 3 kartu horizontal sejajar (`Aplikasi`, `Dampak`, `Talenta`) beraksen brand Widyatama/Diktisaintek dengan icon SVG terarah, monospace category tag, dan bebas dari jargon AI klise.
- [x] Katalog & Filter Proyek (`components/filter-bar.blade.php` & `components/project-card.blade.php`):
  - Filter tahun instan tanpa refresh/ngeblink (client-side DOM filter 60fps dengan sinkronisasi URL bersih tanpa karakter `#`). Teks "filter tahun aktif diterapkan" telah dihilangkan sepenuhnya.
  - Grid kartu proyek rasio 16:9, chip badge tahun & desa mitra, avatar bertumpuk, nama lengkap, NPM, jurusan, action button.
- [x] Section Catatan Lapangan & Dokumentasi Tim (`components/field-notes.blade.php`):
  - 3 kartu artikel kegiatan tim lapangan di balai desa mitra dengan format tanggal Indonesia dan SVG icon kalender.

### [x] Tahap 5: Verifikasi & Audit Hygiene (`antislop` & `antislop-code`)
- [x] Jalankan build test asset Vite (`npm run build`).
- [x] Uji cache Blade view (`php artisan view:cache` berhasil tanpa error).
- [x] Uji rendering endpoint GET `/`, filter kategori, search keyword, dan empty state.
- [x] Validasi audit `/antislop`: zero emoji, bebas em dash, CSS variables terdaftar di `:root`, kontras WCAG AA, modular tanpa godfile.
- [x] Validasi audit `/antislop-code`: sanitasi komentar kode (hapus AI slop, empty labels, step-by-step narration, meta tags; kode program 100% utuh tanpa perubahan logika).

---

# Tasklist Implementasi Halaman Detail Proyek (/proyek/{slug})

Dokumen pelacak pengerjaan Halaman Detail Proyek (`/proyek/{slug}`) menggunakan **Laravel 13 + Tailwind CSS + MySQL**, dengan target visual 100% presisi mengacu pada prototipe `assets/sigap_detail_proyek.html` dan `docs/PRD.md` (FR-DET-01 s.d. FR-DET-04).

---

## Aturan & Keputusan Kunci Halaman Detail
1. **Strictly NO EMOJI:** Dilarang menggunakan emoji Unicode di seluruh tampilan (badge status, tombol, judul section, nama fitur). Semua representasi visual wajib menggunakan icon SVG resmi.
2. **Zero Em Dash:** Dilarang menggunakan tanda pisah em dash di seluruh judul, teks narasi, breadcrumb, dan komentar kode.
3. **Dosen sebagai Pembina / Pembimbing:** Posisi dosen dicantumkan secara presisi sebagai "Dosen Pembina & Penanggung Jawab Proyek" (bukan sebagai pengembang teknis/pembuat kode; mahasiswa adalah perancang dan pembangun utama sistem).
4. **Atribusi Mahasiswa Lengkap Ber-NPM:** Menampilkan foto profil melingkar, nama lengkap, **NPM**, program studi (*S1 Teknik Informatika* / *S1 Sistem Informasi*), dan pill role teknis (*Tech Lead*, *Full Stack*, *Frontend*, *Backend*, *UI/UX*).
5. **Tech Stack Berlogo Resmi Berwarna:** Menggunakan logo/ikon SVG resmi berwarna institusional (Next.js, Tailwind CSS, PostgreSQL, Node.js, Leaflet Maps, Laravel, MySQL, React).
6. **Fokus Akademis & Verifikasi Lapangan (FR-DET-01):** Header detail tidak memuat tombol eksternal "Buka Web" untuk menjaga fokus pembaca pada dampak riset, solusi lapangan, metodologi, dan pengujian sistem.
7. **Modularitas Blade (Anti-Godfile):** Halaman `/proyek/{slug}` dirakit dari Blade components terfokus di `resources/views/projects/` dan `resources/views/components/project/`.
8. **Code Comment Hygiene (`antislop-code`):** Bebas komentar narasi alur, banner dekoratif, atau meta tags AI.

---

## Rincian Tahapan Pengerjaan

### [ ] Tahap 1: Routing & Controller Layer
- [ ] Daftarkan route detail di `routes/web.php`:
  `Route::get('/proyek/{slug}', [ProjectController::class, 'show'])->name('projects.show');`
- [ ] Buat `ProjectController` di `app/Http/Controllers/ProjectController.php`:
  - Method `show(string $slug)`:
  - Query proyek terpublikasi dengan eager loading `contributors`:
    `$project = Project::published()->with('contributors')->where('slug', $slug)->firstOrFail();`
  - Ambil daftar proyek lain untuk rekomendasi navigasi di bagian bawah.
- [ ] Update link kartu proyek di `resources/views/components/project-card.blade.php`:
  - Ubah `href="/"` menjadi `href="{{ route('projects.show', $project->slug) }}"`.

### [ ] Tahap 2: Database Schema & Data Detail Proyek
- [ ] Siapkan kolom data detail di tabel `projects` melalui migration baru:
  - `problem_statement` (text nullable: narasi masalah riil di desa mitra).
  - `features` (json nullable: array fitur kunci `[{ icon, title, description }]`).
  - `gallery_images` (json nullable: array foto implementasi lapangan `[{ image_url, caption }]`).
- [ ] Daftarkan atribut baru pada `$fillable` dan `$casts` di `app/Models/Project.php`.
- [ ] Perbarui `database/seeders/ProjectSeeder.php` dengan data riil:
  - **SIGAP:**
    - Latar belakang darurat warga Desa Cibenda (kendala respons lambat, minim koordinat GPS).
    - Fitur kunci: Peringatan Panik Sekali Sentuh, Pemetaan Koordinat Insiden GPS, Notifikasi WhatsApp Otomatis ke RT/RW.
    - 4 foto galeri kegiatan di Balai Desa Cibenda beserta caption.
  - **SIDUtama:**
    - Latar belakang administrasi desa (arsip kependudukan manual dan birokrasi surat lambat).
    - Fitur kunci: Register Kependudukan Digital, Generator Surat Otomatis, Rekap Mutasi Warga.
    - 4 foto galeri pengujian di kantor desa.
  - **CiMart:**
    - Latar belakang pemasaran produk UMKM lokal Desa Cibenda.
    - Fitur kunci: E-Katalog Komoditas Desa, Profil Pelaku Usaha Mikro, Direktori Kontak Penjual.
    - 4 foto galeri kurasi produk UMKM warga.
- [ ] Jalankan migration dan seeder di MySQL database `test_berdampak_utama`.

### [ ] Tahap 3: Master Detail View & Breadcrumb Navigation
- [ ] Buat file tampilan utama `resources/views/projects/show.blade.php`.
- [ ] Buat component Breadcrumb terarah (`components/project/breadcrumb.blade.php`):
  - Tautan kembali ke portofolio: `Beranda / Portofolio Proyek / [Nama Proyek]`.
  - Tombol panah kembali yang intuitif dan ramah aksesibilitas keyboard.
- [ ] Header Proyek (Hero Header Metadata):
  - Badge tahun rilis (`2026`).
  - Badge nama mitra desa (`Desa Cibenda`).
  - Badge kategori proyek.
  - Judul proyek besar dengan font display Poppins tebal.
  - Ringkasan narasi proyek yang rapi dan kontekstual.

### [ ] Tahap 4: Kolom Konten Utama (Main Left 8-Column)
- [ ] **Showcase Dashboard Utama (16:9):**
  - Frame tangkapan layar dashboard asli rasio 16:9 dengan border halus, rounded-xl, dan efek bayangan elegan.
- [ ] **Section Latar Belakang & Masalah Lapangan:**
  - Headline resmi dan narasi terstruktur mengenai masalah riil warga desa yang diselesaikan oleh sistem.
- [ ] **Section Fitur Kunci Sistem:**
  - List kartu fitur modular dengan SVG icon khusus (darurat, GPS, notifikasi, dll.) dan teks penjelasan lugas.
- [ ] **Section Galeri Dokumentasi Tim di Desa:**
  - Grid 2x2 responsif memuat 4 foto kegiatan mahasiswa di Balai Desa Cibenda.
  - Aspect-video cover dengan figcaption rapi di setiap foto.

### [ ] Tahap 5: Sidebar Kolom Kanan (Sidebar Right 4-Column)
- [ ] **Card Dosen Pembina:**
  - Foto profil dosen melingkar dengan ring halus.
  - Nama lengkap beserta gelar akademik (`Dr. Hendra Wijaya, M.Kom.`).
  - Label resmi: `Dosen Pembina & Penanggung Jawab Proyek`.
- [ ] **Card Tim Mahasiswa Pengembang:**
  - List seluruh anggota mahasiswa pembuat sistem.
  - Foto avatar melingkar, nama lengkap, **NPM**, jurusan (*S1 Teknik Informatika* / *S1 Sistem Informasi*).
  - Chip badge peran spesifik (*Tech Lead*, *Full Stack*, *Frontend*, *Backend*).
- [ ] **Card Tech Stack Resmi:**
  - Grid 2 kolom berisi logo SVG resmi berwarna (Next.js, Tailwind CSS, PostgreSQL, Node.js, Leaflet Maps, Laravel, MySQL, React).
  - Label nama teknologi yang bersih dan presisi.
- [ ] **Card Metadata Ringkas:**
  - Baris informasi tahun rilis dan instansi mitra binaan.

### [ ] Tahap 6: Navigasi Proyek Terkait & Footer
- [ ] Section bawah berisi tautan ke proyek inovasi kampus berdampak lainnya (Next Project / Kembali ke Katalog).
- [ ] Integrasikan footer institusi bersama Widyatama dan Diktisaintek (`components/footer.blade.php`).

### [ ] Tahap 7: Responsive Polish, Verifikasi Build & Audit Hygiene
- [ ] Uji responsivitas menyeluruh pada breakpoint mobile (<640px), tablet (768px), dan desktop (1024px+).
- [ ] Jalankan kompilasi asset Vite (`npm run build`).
- [ ] Jalankan pengecekan cache view Laravel (`php artisan view:cache`).
- [ ] Uji akses HTTP endpoint `/proyek/sigap`, `/proyek/sidutama`, dan `/proyek/cimart` (pastikan status 200 OK dan 404 pada slug tidak valid).
- [ ] Audit `/antislop`: pastikan zero emoji, zero em dash, kontras warna AA, dan tidak ada teks slop/klise.
- [ ] Audit `/antislop-code`: pastikan seluruh blade view dan kode bersih dari komentar tutorial atau narrating comments.
