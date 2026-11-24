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
