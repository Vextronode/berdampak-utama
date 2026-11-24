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

### [x] Tahap 1: Routing & Controller Layer
- [x] Daftarkan route detail di `routes/web.php`:
  `Route::get('/proyek/{slug}', [ProjectController::class, 'show'])->name('projects.show');`
- [x] Buat `ProjectController` di `app/Http/Controllers/ProjectController.php`:
  - Method `show(string $slug)`:
  - Query proyek terpublikasi dengan eager loading `contributors`:
    `$project = Project::published()->with('contributors')->where('slug', $slug)->firstOrFail();`
  - Ambil daftar proyek lain untuk rekomendasi navigasi di bagian bawah.
- [x] Update link kartu proyek di `resources/views/components/project-card.blade.php`:
  - Ubah `href="/"` menjadi `href="{{ route('projects.show', $project->slug) }}"`.

### [x] Tahap 2: Database Schema & Data Detail Proyek
- [x] Siapkan kolom data detail di tabel `projects` melalui migration baru:
  - `problem_statement` (text nullable: narasi masalah riil di desa mitra).
  - `features` (json nullable: array fitur kunci `[{ icon, title, description }]`).
  - `gallery_images` (json nullable: array foto implementasi lapangan `[{ image_url, caption }]`).
- [x] Daftarkan atribut baru pada `$fillable` dan `$casts` di `app/Models/Project.php`.
- [x] Perbarui `database/seeders/ProjectSeeder.php` dengan data riil:
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
- [x] Jalankan migration dan seeder di MySQL database `test_berdampak_utama`.

### [x] Tahap 3: Master Detail View & Breadcrumb Navigation
- [x] Buat file tampilan utama `resources/views/projects/show.blade.php`.
- [x] Buat component Breadcrumb terarah (`components/project/breadcrumb.blade.php`):
  - Tautan kembali ke portofolio: `Beranda / Portofolio Proyek / [Nama Proyek]`.
  - Tombol panah kembali yang intuitif dan ramah aksesibilitas keyboard.
- [x] Header Proyek (Hero Header Metadata):
  - Badge tahun rilis (`2026`).
  - Badge nama mitra desa (`Desa Cibenda`).
  - Badge kategori proyek.
  - Judul proyek besar dengan font display Poppins tebal.
  - Ringkasan narasi proyek yang rapi dan kontekstual.

### [x] Tahap 4: Kolom Konten Utama (Main Left 8-Column)
- [x] **Showcase Dashboard Utama (16:9):**
  - Frame tangkapan layar dashboard asli rasio 16:9 dengan border halus, rounded-xl, dan efek bayangan elegan.
- [x] **Spotlight Kartu Tim Mahasiswa Pengembang (`components/project/team-showcase.blade.php`):**
  - Diposisikan tepat di bawah showcase mockup 16:9 sebelum narasi masalah.
  - Kartu foto potret rasio 4:5 resolusi tinggi (bukan avatar bulat kecil), badge NPM glassmorphic di sudut foto, nama lengkap Poppins tebal, program studi, dan badge peran teknis.
  - Grid adaptif dinamis untuk menangani jumlah tim berapapun: 1 orang (centered max-w-md), 2 orang (2 kolom max-w-2xl), 3 orang (3 kolom), 4 orang (grid 2x2 max-w-3xl agar peran tidak tertekan), 5+ orang (grid 3 kolom berulang rapi).
- [x] **Section Latar Belakang & Masalah Lapangan:**
  - Headline resmi dan narasi terstruktur mengenai masalah riil warga desa yang diselesaikan oleh sistem.
- [x] **Section Fitur Kunci Sistem:**
  - List kartu fitur modular dengan SVG icon khusus (darurat, GPS, notifikasi, dll.) dan teks penjelasan lugas.
- [x] **Section Galeri Dokumentasi Tim di Desa:**
  - Grid 2x2 responsif memuat 4 foto kegiatan mahasiswa di Balai Desa Cibenda.
  - Aspect-video cover dengan figcaption rapi di setiap foto.

### [x] Tahap 5: Sidebar Kolom Kanan (Sidebar Right 4-Column)
- [x] **Card Dosen Pembina:**
  - Foto profil dosen melingkar dengan ring halus.
  - Nama lengkap beserta gelar akademik (`Dr. Hendra Wijaya, M.Kom.`).
  - Label resmi: `Dosen Pembina & Penanggung Jawab Proyek`.
- [x] **Scroll-Docking Tim Mahasiswa Pengembang:**
  - Tersembunyi saat kartu spotlight utama sedang terlihat di layar untuk menghindari duplikasi konten.
  - Otomatis meluncur turun (*smooth slide down & fade in* 300ms) saat kartu spotlight utama tergulir keluar dari viewport via `IntersectionObserver`.
  - Otomatis melipat kembali (*smooth slide up & fade out*) saat kartu spotlight kembali terlihat di layar.
  - Judul dilengkapi tautan interaktif panah untuk *smooth scroll* kembali ke kartu spotlight di atas.
  - Foto avatar melingkar, nama lengkap, **NPM**, jurusan (*S1 Teknik Informatika* / *S1 Sistem Informasi*), dan pill badge peran selaras dengan token tema.
- [x] **Card Tech Stack Resmi:**
  - Grid 2 kolom berisi logo SVG resmi berwarna (Next.js, Tailwind CSS, PostgreSQL, Node.js, Leaflet Maps, Laravel, MySQL, React).
  - Label nama teknologi yang bersih dan presisi.
- [x] **Card Metadata Ringkas:**
  - Baris informasi tahun rilis dan instansi mitra binaan.

### [x] Tahap 6: Navigasi Proyek Terkait & Footer
- [x] Section bawah berisi tautan ke proyek inovasi kampus berdampak lainnya (Next Project / Kembali ke Katalog).
- [x] Integrasikan footer institusi bersama Widyatama dan Diktisaintek (`components/footer.blade.php`).

### [x] Tahap 7: Responsive Polish, Verifikasi Build & Audit Hygiene
- [x] Uji responsivitas menyeluruh pada breakpoint mobile (<640px), tablet (768px), dan desktop (1024px+).
- [x] Jalankan kompilasi asset Vite (`npm run build`).
- [x] Jalankan pengecekan cache view Laravel (`php artisan view:cache`).
- [x] Uji akses HTTP endpoint `/proyek/sigap`, `/proyek/sidutama`, dan `/proyek/cimart` (pastikan status 200 OK dan 404 pada slug tidak valid).
- [x] Audit `/antislop`: pastikan zero emoji, zero em dash, kontras warna AA, dan tidak ada teks slop/klise.
- [x] Audit `/antislop-code`: pastikan seluruh blade view dan kode bersih dari komentar tutorial atau narrating comments.

---

## Catatan Keputusan Arsitektur Masa Depan (Admin CMS Tech Stack)
Dokumentasi lengkap tersimpan di `docs/tech-stack-cms-architecture.md`:
1. **Master Table & Pivot:** Tabel `tech_stacks` dan `project_tech_stack` untuk fleksibilitas many-to-many.
2. **Katalog Bawaan:** Pre-seed 30-40 stack teknologi populer dengan SVG resmi Simple Icons.
3. **Penambahan Stack Baru:**
   - Auto-fetch SVG dan kode warna via SimpleIcons CDN berdasarkan slug.
   - Opsi upload file custom SVG/PNG (sanitasi ketat, batas ukuran 500 KB).
   - Fallback otomatis ke badge inisial monogram jika ikon tidak tersedia.

---

## Tasklist Implementasi: Autentikasi Admin Panel (`/apanel/login`)

### Aturan & Perilaku Routing:
1. **Redirect `/apanel`:** Ketika pengunjung mengetik `/apanel`, sistem wajib melempar HTTP 302 redirect langsung ke `/apanel/login` (atau ke `/apanel/dashboard` jika sudah terotentikasi).
2. **Strictly NO EMOJI & Zero Em Dash:** Seluruh pesan form, badge, tombol, dan teks bantuan wajib bebas emoji dan tanda pisah em dash.
3. **Keamanan Login:** Proteksi rate-limiting (`throttle:5,1`), regenerasi ID sesi pasca login, pesan error generik anti-enumerasi akun, dan proteksi CSRF.

### Tahapan Pengerjaan:
- [x] **Tahap 1: Database & Seeder Kredensial Admin**
  - [x] Buat migration kolom role pada tabel `users`.
  - [x] Buat `AdminUserSeeder` dengan akun default `admin@widyatama.ac.id` (`PasswordBerdampak2026!`).
- [x] **Tahap 2: Controller & Logika Autentikasi (`Apanel\AuthController`)**
  - [x] Implementasikan `showLoginForm()`, `login()` dengan proteksi brute-force, regenerasi sesi, dan `intended()`, serta `logout()`.
  - [x] Buat `Apanel\DashboardController` dengan ringkasan metrik database riil.
- [x] **Tahap 3: Konfigurasi Routing & Dispatcher di `routes/web.php`**
  - [x] Route redirect `/apanel` -> `/apanel/login` (atau ke `/apanel/dashboard` jika terotentikasi).
  - [x] Route guest `/apanel/login` (GET `apanel.login` & POST `apanel.login.submit`).
  - [x] Route auth `/apanel/logout` (POST `apanel.logout`) & `/apanel/dashboard` (GET `apanel.dashboard`).
  - [x] Konfigurasi middleware redirect di `bootstrap/app.php`.
- [x] **Tahap 4: Desain Antarmuka Login (`apanel/auth/login.blade.php`)**
  - [x] Layout dark glassmorphism bertema Widyatama Deep Navy (`layouts/apanel-auth.blade.php`).
  - [x] Branding resmi Universitas Widyatama x Diktisaintek Berdampak.
  - [x] Form input email & password dengan toggle intip password (SVG mata tanpa dependensi berat).
  - [x] Checkbox "Ingat saya" dan alert box error berkontras tinggi.
- [x] **Tahap 5: Pengujian, Verifikasi Alur & Audit Anti-Slop**
  - [x] Uji redirect `/apanel` ke `/apanel/login` (HTTP 302 terverifikasi via curl & PHPUnit).
  - [x] Uji brute-force lock (RateLimiter lockout teruji via Feature Test).
  - [x] Uji login berhasil ke `/apanel/dashboard` dan pemutusan sesi via logout.
  - [x] 11 unit & feature test passed 100%.
  - [x] Verifikasi `npm run build` dan `php artisan view:cache` (0 error).
  - [x] Audit anti-slop: strictly zero emoji, zero em dash.

---

# Tasklist Implementasi Admin CMS: Tambah Proyek Baru & Dynamic Tech Stack

Dokumen ini memuat rencana kerja teknis untuk mengimplementasikan fitur **Tambah Proyek Baru** pada Admin Panel (`/apanel/proyek/create`), mengacu penuh pada prototype visual [admin_cms_tambah_proyek_baru.html](file:///mnt/data/Projects/Web/Laravel/berdampak-utama/assets/admin_cms_tambah_proyek_baru.html) serta keputusan arsitektur [tech-stack-cms-architecture.md](file:///mnt/data/Projects/Web/Laravel/berdampak-utama/docs/tech-stack-cms-architecture.md).

---

## 1. Ringkasan Ruang Lingkup & Aturan Desain

1. **Struktur Halaman Utama (5 Kartu + Sticky Bottom Bar):**
   - **Header & Navigasi:** Top horizontal navbar bertema Widyatama Navy & Diktisaintek Berdampak (tanpa vertical sidebar).
   - **Card 1: Informasi Umum & Filter Proyek:** Judul proyek, slug otomatis, tahun pengerjaan, kategori proyek, nama mitra desa, URL aplikasi live, switch status publikasi.
   - **Card 2: Deskripsi Proyek & Dokumentasi Lapangan:** Deskripsi singkat (maks. 200 karakter dengan live counter), deskripsi lengkap & cerita dampak (latar belakang, solusi, dampak), galeri 4 foto dokumentasi lapangan beserta input caption.
   - **Card 3: Tangkapan Layar Dashboard Utama (16:9):** Area drag-and-drop file upload 16:9 dengan tombol "Pilih File Gambar" dan preview instan.
   - **Card 4: Pilihan Tech Stack (Dynamic Multi-Select):** Grid kartu interaktif teknologi pre-seeded dengan logo SVG resmi, modal "+ Tambah Stack Baru" (auto-fetch SimpleIcons CDN, custom upload sanitization, monogram badge fallback), serta input teks stack tambahan.
   - **Card 5: Tim Pengembang & Orang yang Terlibat:** Sub-card Dosen Pembimbing (foto avatar, nama lengkap & gelar, jabatan/peran) dan sub-card Mahasiswa Kontributor dengan tombol dinamis "+ Tambah Anggota Mahasiswa" (foto, nama, NPM, jurusan, peran).
   - **Sticky Bottom Action Bar:** Tautan "Batal & Kembali", tombol "Simpan sebagai Draft", dan tombol "Publikasikan Proyek Sekarang".

2. **Standar Anti-Slop:**
   - Strictly zero emoji di seluruh interface, kode, response, dan database seeder.
   - Strictly zero em dash (tanda pisah panjang). Gunakan titik dua, tanda kurung, atau koma.
   - Kontras warna teks dan latar belakang memenuhi standar WCAG AA.
   - Tidak ada narrating comments atau kode boilerplate generik.

---

## 2. Rincian Tahapan Kerja

### Tahap 1: Skema Database & Seeder Dynamic Tech Stack
- [ ] Buat file migration `create_tech_stacks_table`:
  - Kolom: `id`, `name`, `slug` (unique), `icon_type` (enum: `svg_raw`, `cdn_url`, `custom_upload`, `monogram`), `icon_value` (nullable text), `brand_color` (string 7, contoh: `#1E1B64`), `created_at`, `updated_at`.
- [ ] Buat file migration `create_project_tech_stack_table` (pivot table):
  - Kolom: `project_id` (foreign key ke `projects.id`, cascade on delete), `tech_stack_id` (foreign key ke `tech_stacks.id`, cascade on delete).
  - Primary key komposit: `['project_id', 'tech_stack_id']`.
- [ ] Buat Eloquent Model `TechStack` (`app/Models/TechStack.php`):
  - Konfigurasi fillable, casts, dan relasi `projects(): BelongsToMany`.
  - Tambahkan accessor helper untuk merender elemen SVG/ikon dan generator inisial monogram (2 huruf kapital) untuk fallback.
- [ ] Perbarui Eloquent Model `Project` (`app/Models/Project.php`):
  - Tambahkan relasi `techStacks(): BelongsToMany`.
  - Tambahkan event hook atau sync mutator untuk menyinkronkan array nama stack ke kolom JSON `tech_stacks` demi kompatibilitas mundur dengan katalog landing page dan detail publik.
- [ ] Buat `TechStackSeeder` (`database/seeders/TechStackSeeder.php`):
  - Pre-seed 30-40 teknologi mahasiswa populer (Laravel, React, Next.js, Vue.js, Tailwind CSS, Bootstrap, TypeScript, JavaScript, HTML5, CSS3, PHP, Node.js, Express, Python, Django, FastAPI, PostgreSQL, MySQL, MariaDB, SQLite, Redis, Supabase, Firebase, Flutter, Dart, React Native, Android, Docker, Git, GitHub, Leaflet, OpenStreetMap, Postman, Figma).
  - Menggunakan vektor SVG resmi dan kode warna heksadesimal standar Simple Icons.

### Tahap 2: Backend Controller, Request Validation & Endpoint API
- [ ] Buat Form Request `StoreProjectRequest` (`app/Http/Requests/Apanel/StoreProjectRequest.php`):
  - Validasi ketat field form Card 1: `title` (required, max 255), `slug` (required, unique:projects,slug), `year` (required, integer, min 2020), `category` (required), `partner_name` (required), `live_url` (nullable, url), `is_published` (boolean).
  - Validasi field Card 2: `summary` (required, max 200), `problem_statement` (nullable, string), `description` (nullable, string), `gallery_images.*` (nullable, image, mimes:jpeg,png,jpg,webp, max 3072), `gallery_captions.*` (nullable, string, max 255).
  - Validasi field Card 3: `dashboard_thumbnail` (nullable, image, mimes:jpeg,png,jpg,webp, max 3072).
  - Validasi field Card 4: `tech_stack_ids` (nullable, array), `tech_stack_ids.*` (exists:tech_stacks,id), `custom_tech_stacks` (nullable, string).
  - Validasi field Card 5: `supervisor_name` (nullable, string), `supervisor_title` (nullable, string), `supervisor_photo` (nullable, image, max 2048), `contributors` (nullable, array), `contributors.*.name`, `contributors.*.npm`, `contributors.*.major`, `contributors.*.role`, `contributors.*.photo`.
- [ ] Buat Controller `ProjectManagementController` (`app/Http/Controllers/Apanel/ProjectManagementController.php`):
  - Method `create()`: memuat seluruh koleksi `TechStack` dan merender view `apanel.projects.create`.
  - Method `store(StoreProjectRequest $request)`: eksekusi dalam DB transaction, proses penyimpanan file upload ke storage publik, insert entitas `Project`, sync pivot `project_tech_stack`, insert entitas `ProjectContributor`, dan redirect dengan session flash success.
- [ ] Buat Controller `TechStackController` (`app/Http/Controllers/Apanel/TechStackController.php`):
  - Method `store(Request $request)`: AJAX endpoint untuk menambahkan tech stack baru secara live dari modal:
    - Auto-fetch SVG dan kode warna brand dari SimpleIcons CDN jika ditemukan via slug.
    - Sanitasi file upload jika admin mengunggah file SVG/PNG custom.
    - Fallback ke badge monogram 2 huruf jika ikon tidak tersedia.
    - Mengembalikan response JSON `{success: true, tech_stack: {...}}`.
  - Method `search(Request $request)`: pencarian cepat tech stack untuk live filter di form.

### Tahap 3: Konfigurasi File Storage & Media Handling
- [ ] Pastikan storage symlink aktif via `php artisan storage:link` (`public/storage` mengarah ke `storage/app/public`).
- [ ] Siapkan struktur direktori penyimpanan:
  - `storage/app/public/projects/thumbnails/`
  - `storage/app/public/projects/gallery/`
  - `storage/app/public/projects/supervisors/`
  - `storage/app/public/projects/contributors/`
  - `storage/app/public/tech-stacks/`
- [ ] Helper sanitasi file SVG kustom untuk menghapus tag `<script>`, `<foreignObject>`, dan event handler inline (mencegah XSS).

### [x] Tahap 4: Routing & Layout Blade Admin
- [x] Buat layout admin utama `resources/views/layouts/apanel.blade.php`:
  - Top Horizontal Navbar dengan logo Universitas Widyatama dan Diktisaintek Berdampak.
  - User status pill, link ke Web Publik, dan tombol Logout aman.
  - Script pengaman anti-back-history (`pageshow` reload).
  - Komponen alert flash message (sukses dan error validasi).
- [x] Buat komponen Blade `x-tech-stack-icon` (`resources/views/components/tech-stack-icon.blade.php`):
  - Dukungan rendering untuk `svg_raw` (SimpleIcons resmi dengan warna brand), `cdn_url`, `custom_upload`, dan fallback monogram badge.
- [x] Konfigurasi routes di `routes/web.php` dalam grup middleware `['auth', 'prevent.back']`:
  - `GET /apanel/proyek/create` -> `ProjectManagementController@create` (nama: `apanel.projects.create`).
  - `POST /apanel/proyek` -> `ProjectManagementController@store` (nama: `apanel.projects.store`).
  - `POST /apanel/tech-stacks` -> `TechStackController@store` (nama: `apanel.tech-stacks.store`).
  - `GET /apanel/tech-stacks/search` -> `TechStackController@search` (nama: `apanel.tech-stacks.search`).

### [x] Tahap 5: Implementasi View Blade `apanel/projects/create.blade.php` (1:1 Match Prototype)
- [x] **Header Section:**
  - Breadcrumb: `Admin > Kelola Proyek > Tambah Proyek Baru`.
  - Judul halaman "Tambah Proyek Baru" dan subjudul penjelasan ringkas.
- [x] **Card 1: Informasi Umum & Filter Proyek:**
  - Input Judul Proyek dengan auto-slug generator.
  - Input Slug URL (disabled/read-only, otomatis mengikuti judul).
  - Input manual Tahun Pengerjaan (tipe number, bebas autofill dengan hint text placeholder).
  - Input manual Kategori Proyek (tipe text, bebas autofill dengan hint text placeholder).
  - Input Nama Mitra / Desa Binaan.
  - Input URL Aplikasi Web Live.
  - Toggle Switch Status Publikasi (Langsung Tayangkan vs Simpan Draft) tersinkronisasi dengan hidden input `is_published`.
- [x] **Card 2: Deskripsi Proyek & Dokumentasi Lapangan:**
  - Textarea Deskripsi Singkat dengan penghitung karakter live `0 / 200`.
  - Structured narrative editor untuk Latar Belakang Masalah, Solusi Sistem, dan Dampak Nyata bagi Warga.
  - Upload Galeri Dokumentasi Lapangan: grid 4 kartu foto dengan input file, tombol unggah, dan input caption per foto.
- [x] **Card 3: Tangkapan Layar Dashboard Utama (16:9):**
  - Area drag-and-drop rasio 16:9 dengan tombol "Pilih File Gambar".
  - Preview thumbnail instan pasca pemilihan gambar tanpa reload halaman.
- [x] **Card 4: Pilih Teknologi yang Digunakan (Dynamic Tech Stack):**
  - 26 Stack developer relevan dengan SVG resmi Simple Icons dan warna brand (Laravel, React, Go, Rust, Prisma, Vue, Tailwind, PostgreSQL, MySQL, Redis, Supabase, Flutter, Dart, dll.). Tool non-kode (Figma, GitHub, Git, Postman) disingkirkan.
  - Tombol "+ Tambah Stack Baru" yang memicu modal quick-add.
  - Modal quick-add: input nama, slug auto-match, live preview dari SimpleIcons atau opsi upload custom/monogram, dan tombol simpan via AJAX yang langsung menginjeksi kartu baru ke dalam grid.
  - Input teks tambahan untuk stack lainnya (comma-separated).
- [x] **Card 5: Tim Pengembang & Orang yang Terlibat:**
  - Dosen Pembimbing: uploader foto avatar, input nama dosen & gelar (tanpa autofill hardcode), input jabatan/peran dengan placeholder hint text.
  - Kontributor Mahasiswa: tombol "+ Tambah Anggota Mahasiswa" yang dapat menambah baris baru secara dinamis.
  - Per baris kontributor: tombol uploader foto, input nama lengkap, input NPM (font tabular-nums), input Angkatan (class_year), input manual Jurusan (text input), input manual Peran (text input), dan tombol hapus baris. Bebas dari data autofill hardcode.
- [x] **Sticky Bottom Action Bar:**
  - Tautan "Batal & Kembali ke Daftar Proyek".
  - Tombol sekunder "Simpan sebagai Draft" (mengirimkan form dengan `is_published = 0`).
  - Tombol primer "Publikasikan Proyek Sekarang" (mengirimkan form dengan `is_published = 1`).

### [x] Tahap 6: Interaktivitas Client-Side (Vanilla JavaScript)
- [x] Script real-time slug generator: mengubah spasi menjadi tanda strip dan karakter non-alphanumeric dihapus.
- [x] Script live character counter pada textarea deskripsi singkat (`short-desc-count`).
- [x] Script preview drag-and-drop file upload untuk screenshot dashboard 16:9 dan foto galeri.
- [x] Script dynamic row adder & remover untuk anggota mahasiswa kontributor (lengkap dengan 5 input manual: nama, npm, angkatan, jurusan, peran).
- [x] Script modal quick-add tech stack dengan integrasi fetch API dan DOM insertion.

### [x] Tahap 7: Automated Testing, Verifikasi & Audit Kualitas
- [x] Buat Feature Test `ApanelProjectCreateTest` (`tests/Feature/ApanelProjectCreateTest.php`):
  - Uji proteksi: guest diarahkan ke `/apanel/login`.
  - Uji akses: admin dapat membuka halaman `/apanel/proyek/create` (HTTP 200).
  - Uji validasi: gagal menyimpan jika field wajib kosong.
  - Uji simpan lengkap: berhasil menyimpan proyek dengan relasi pivot tech stack, file thumbnail, foto galeri, dan kontributor (termasuk field angkatan/class_year).
  - Uji draft vs published: status publikasi tersimpan sesuai tombol aksi yang diklik.
- [x] Buat Feature Test `TechStackManagementTest` (`tests/Feature/TechStackManagementTest.php`):
  - Uji endpoint penambahan tech stack baru via AJAX.
  - Uji sanitasi SVG custom upload.
- [x] Jalankan kompilasi asset Vite (`npm run build`).
- [x] Jalankan verifikasi cache view (`php artisan view:cache`).
- [x] Audit anti-slop: zero emoji, zero em dash, kontras warna AA, dan tidak ada teks slop/klise.

---

## 3. Titik Keputusan Teknis untuk Konfirmasi

1. **Struktur Route CMS:**
   - Rekomendasi: `GET /apanel/proyek/create` untuk form input dan `POST /apanel/proyek` untuk penyimpanan.
2. **Katalog Tech Stack Bawaan:**
   - 30-40 teknologi pre-seeded diambil langsung dari repositori resmi Simple Icons dengan format SVG standar dan warna resmi masing-masing brand.
3. **Penyimpanan Gambar:**
   - Seluruh berkas (thumbnail dashboard, galeri lapangan, foto dosen, foto mahasiswa) disimpan di disk `public` (`storage/app/public/projects/...`) agar dapat diakses publik secara optimal.

