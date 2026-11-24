# Berdampak Utama — berdampak.widyatama.ac.id

Repositori ini ditujukan untuk portal etalase dan portofolio proyek pengabdian masyarakat **Kampus Berdampak Universitas Widyatama** yang didukung oleh program **Diktisaintek Berdampak** (Kementerian Pendidikan Tinggi, Sains, dan Teknologi).

## 🚀 Proyek Unggulan Terintegrasi
- **SIGAP** — Sistem Informasi Gawat Darurat & Pengaduan Warga Desa Cibenda
- **SIDUtama** — Sistem Informasi Desa Universitas Widyatama (Kependudukan & Administrasi)
- **Sistem Informasi Desa Cibenda** — Portal Informasi Profil, UMKM, dan Potensi Desa

---

## 📚 Dokumentasi Utama untuk Pengembang (Developer)

1. **[Product Requirements Document (PRD.md)](./PRD.md)** *(Versi 1.2 — Terkini & Approved)*
   - Visi & Tujuan Produk
   - Arsitektur, User Journey, & Functional Requirements
   - Filter Tahun (2024, 2025, 2026) & Kategori
   - Spesifikasi Kontributor (Foto, Nama, NPM, Jurusan, Peran)
   - Modul Catatan Lapangan / Blog Kegiatan Tim
   - Skema Database Lengkap (ERD) & Panduan API

2. **[Panduan Desain & Prompt Stitch (desain.md)](./desain.md)**
   - Design System (Widyatama Navy `#1E1B64`, Accent Orange `#F15A24`, Diktisaintek Cyan `#0088FF`)
   - Tipografi (Poppins & Inter)
   - Spesifikasi detail per layar dan panduan UI

---

## 🎨 Prototipe UI / Mockup Desain (Hasil Google Stitch)

Mockup HTML interaktif hasil generate Google Stitch tersedia di folder `assets/`:
- 🌐 **[Landing Page Prototype](./assets/landing_page.html)** — Tampilan utama (Hero Mainhall, Filter Tahun, Kartu Proyek dengan NPM, Catatan Lapangan).
- 📄 **[Detail Proyek SIGAP Prototype](./assets/sigap_detail_proyek.html)** — Halaman rincian proyek, galeri lapangan, logo tech stack, dan profil tim/dosen pembimbing.
- 🔐 **[Login Admin Portal Prototype](./assets/portal_pengelola_admin_login.html)** — Halaman autentikasi pengelola (akses via URL).
- 📐 **[Design System Export](./assets/design_system.md)** — Spesifikasi token CSS & warna dari Stitch.
- 🖼️ **[Asset Gambar & Foto](./assets/image/)** — Direktori gambar referensi & mockup.

---

## 💻 Panduan Singkat untuk Rekan Developer
- **Rekomendasi Stack:** Next.js 14/15 (App Router, TypeScript) + Tailwind CSS + shadcn/ui.
- **Database:** PostgreSQL (Supabase / Neon) dengan Prisma ORM.
- **Icons & Logos:** Lucide React + Simple Icons (untuk logo resmi tech stack).
- **Prosedur:** Silakan pelajari `PRD.md` untuk alur fungsionalitas dan buka file HTML di folder `assets/` di browser untuk melihat visual antarmuka yang harus di-code.
