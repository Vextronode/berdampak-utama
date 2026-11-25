# Berdampak Utama — berdampak.widyatama.ac.id

Repositori ini ditujukan untuk portal etalase dan portofolio proyek pengabdian masyarakat **Kampus Berdampak Universitas Widyatama** yang didukung oleh program **Diktisaintek Berdampak** (Kementerian Pendidikan Tinggi, Sains, dan Teknologi).

## 🚀 Proyek Unggulan Terintegrasi
- **SIGAP** — Sistem Informasi Gawat Darurat & Pengaduan Warga Desa Cibenda
- **SIDUtama** — Sistem Informasi Desa Universitas Widyatama (Kependudukan & Administrasi)
- **Sistem Informasi Desa Cibenda** — Portal Informasi Profil, UMKM, dan Potensi Desa

---

## 📚 Dokumentasi Utama untuk Pengembang (Developer)

1. **[Product Requirements Document (PRD.md)](./docs/PRD.md)** *(Versi 1.2 — Terkini & Approved)*
   - Visi & Tujuan Produk
   - Arsitektur, User Journey, & Functional Requirements
   - Filter Tahun (2024, 2025, 2026) & Kategori
   - Spesifikasi Kontributor (Foto, Nama, NPM, Jurusan, Peran)
   - Modul Catatan Lapangan / Blog Kegiatan Tim
   - Skema Database Lengkap (ERD) & Panduan API

2. **[Panduan Desain & Prompt Stitch (desain.md)](./docs/desain.md)**
   - Design System (Widyatama Navy `#1E1B64`, Accent Orange `#F15A24`, Diktisaintek Cyan `#0088FF`)
   - Tipografi (Poppins & Inter)
   - Spesifikasi detail per layar dan panduan UI

---

## 🎨 Referensi Desain (Hasil Google Stitch)

Prototipe HTML sudah diimplementasikan menjadi view Blade dan dihapus dari repo. Referensi yang tersisa di folder `assets/`:
- 📐 **[Design System Export](./assets/design_system.md)** — Spesifikasi token CSS & warna dari Stitch.
- 🖼️ **[Asset Gambar & Foto](./assets/image/)** — Direktori gambar referensi & mockup.

---

## 💻 Panduan Singkat untuk Rekan Developer
- **Stack:** Laravel 13 (PHP 8.4) + Blade, Tailwind CSS 4 + Vite, MySQL 8.4.
- **Icons & Logos:** SVG inline + Simple Icons (untuk logo resmi tech stack).
- **Setup lokal:** salin `.env.example` ke `.env` dan sesuaikan koneksi database, lalu jalankan `composer setup` dan `composer dev`. Akun admin lokal: `php artisan db:seed --class=AdminUserSeeder`.
- **Test:** `composer test`.
- **Deploy:** lihat [docs/DEPLOYMENT.md](./docs/DEPLOYMENT.md).
- **Prosedur:** Silakan pelajari `docs/PRD.md` untuk alur fungsionalitas.
