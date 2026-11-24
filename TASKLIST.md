# Tasklist Implementasi Landing Page — Berdampak Utama

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
9. **Hero Mainhall Widyatama:** Foto resmi gedung *L'Arc d'Academia* dengan overlay navy elegan + search bar.

---

## 📋 Tahapan Pengerjaan

### [ ] Tahap 1: Setup Frontend Theme & Aset Brand
- [ ] Daftarkan token warna institusi di `resources/css/app.css` / Tailwind (`primary-navy-blue: #1E1B64`, `vibrant-utama-orange: #F15A24`, `diktisaintek-blue: #0088FF`, `warm-gold: #F7931E`, Slate/White neutrals) sesuai `assets/design_system.md`.
- [ ] Konfigurasi font Google Fonts (`Poppins` untuk headings, `Inter` untuk body/UI).
- [ ] Salin logo resmi Widyatama (`assets/image/logo-widyatama.jpg`) dan Diktisaintek Berdampak (`assets/image/diktisaintek-berdampak-logo.png`) ke direktori `public/images/`.

### [ ] Tahap 2: Database Schema & Seeder Proyek 2026
- [ ] Buat migration tabel `projects`:
  - `id`, `title`, `slug`, `year` (integer), `summary` (short text), `description` (long text), `partner_name`, `category`, `tech_stacks` (json/array), `dashboard_thumbnail`, `live_url`, `is_published`.
- [ ] Buat migration tabel `project_contributors`:
  - `id`, `project_id` (foreign key), `name`, `npm`, `major`, `role`, `avatar_url`.
- [ ] Buat migration tabel `field_posts` (Catatan Lapangan):
  - `id`, `title`, `slug`, `activity_date`, `cover_image`, `content`.
- [ ] Buat Seeder riil 2026:
  - Proyek **SIGAP** (2026, Desa Cibenda, kontributor Naufal Fadhiil, Raka Pratama, Siti Nurhaliza).
  - Proyek **SIDUtama** (2026, Desa Cibenda, kontributor Ahmad Fauzi, Dinda Kirana).
  - Proyek **CiMart** (2026, Desa Cibenda, kontributor Farhan Maulana, Budi Santoso).
  - 3 artikel catatan lapangan dokumentasi di Desa Cibenda.

### [ ] Tahap 3: Controller & Logika Filter Dinamis
- [ ] Buat `LandingController`:
  - Query mengambil daftar tahun aktif secara dinamis: `$availableYears = Project::where('is_published', true)->distinct()->orderBy('year', 'desc')->pluck('year')`.
  - Query filter berdasarkan tahun yang dipilih (`?year=2026`).
  - Query filter berdasarkan kategori (`?category=...`).
  - Query pencarian keyword di hero section (`?q=...`).
  - Query mengambil 3 catatan lapangan terbaru untuk section dokumentasi.

### [ ] Tahap 4: Blade Views & Components (1:1 Prototipe)
- [ ] Master Layout (`resources/views/layouts/app.blade.php`):
  - Co-branding Header (Logo Widyatama + Logo Diktisaintek Berdampak, links menu, tanpa tombol admin).
  - Footer institusi lengkap (alamat kampus Cikutra 204A Bandung, kontak, copyright 2026).
- [ ] Hero Section:
  - Background gedung Mainhall Widyatama dengan overlay navy transparan.
  - Headline resmi & form pencarian terintegrasi.
- [ ] Katalog & Filter Proyek:
  - Baris filter tahun dinamis (Semua Tahun + daftar tahun dari database) & filter kategori.
  - Grid kartu proyek rasio 16:9, chip badge, avatar bertumpuk, nama, NPM, jurusan, dan action buttons.
- [ ] Section Catatan Lapangan & Dokumentasi Tim:
  - 3 kartu artikel kegiatan tim lapangan di balai desa.

### [ ] Tahap 5: Verifikasi & Pixel-Perfect Check
- [ ] Jalankan aplikasi lokal (`php artisan serve`).
- [ ] Validasi visual dan layout berdampingan dengan `assets/landing_page.html`.
- [ ] Uji fungsionalitas interaksi: filter tahun dinamis, filter kategori, dan pencarian keyword.
