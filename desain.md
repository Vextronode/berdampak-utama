# Panduan Desain & Prompt Google Stitch — Berdampak Utama
**Target Domain:** `berdampak.widyatama.ac.id`  
**Brand Identity:** Universitas Widyatama (UTama) × Diktisaintek Berdampak  
**Tujuan Dokumen:** Spesifikasi desain prototype bersih, simpel (anti "AI slop"), dan kumpulan prompt siap pakai untuk dieksekusi di **Google Stitch** atau AI UI Prototyping tools.

---

## 1. Perubahan Desain Terbaru (Changelog Revisi 2)

1. **Hero Background Foto Gedung Mainhall Widyatama:**
   - Background hero menggunakan foto asli gedung utama kampus Universitas Widyatama (*L'Arc d'Academia / Mainhall* dengan pilar lengkung putih dan bendera merah-putih) yang dilapisi overlay gradasi navy transparan elegan agar teks judul berwarna putih dan aksen oranye kontras dan tajam.
2. **Foto Profil, NPM, & Jurusan Kontributor pada Kartu Proyek:**
   - Pada setiap kartu proyek di halaman utama, ditambahkan baris kontributor berisi avatar foto profil melingkar bertumpuk (*stacked circular avatars*), disertai nama lengkap kontributor, nomor pokok mahasiswa (**NPM**), dan **Jurusan / Program Studi** (misal: S1 Teknik Informatika).
3. **Pemberhentian Tombol Portal Admin di Navbar (Akses via URL Rahasia):**
   - Tombol "Portal Admin" di navbar publik **dihapus total** demi kebersihan tampilan dan keamanan institusi. Admin masuk langsung melalui rute URL khusus (`/admin/login`).
   - Dibuatkan halaman khusus **Admin Login** dan **Halaman Admin Input/CMS Data Proyek**.
4. **Halaman Detail: Hapus Tombol "Buka Aplikasi Web":**
   - Pada halaman detail proyek (`/projek/:slug`), tombol *"Buka Aplikasi Web"* di header atas maupun di sidebar kanan **dihapus**. Halaman kini berfokus penuh pada judul proyek, dokumentasi akademis, dan cerita dampak.
5. **Tech Stack Berupa Logo Resmi (Bukan Teks Biasa):**
   - Tech stack pada halaman detail kini ditampilkan menggunakan logo/ikon resmi berwarna (misal: logo Next.js, Tailwind CSS, PostgreSQL, Node.js) bukan pill teks biasa.
6. **Pergantian Section Kemitraan Menjadi Profil Tim & Dosen Pembimbing:**
   - Box "Program Kemitraan" di sidebar kanan diganti dengan kartu profil berfoto untuk:
     - **Foto Dosen Pembimbing:** Nama lengkap, gelar, dan peran (*Dosen Pembimbing / Penanggung Jawab Proyek*).
     - **Foto Tim Mahasiswa Pengembang:** Foto profil lingkaran tiap mahasiswa, nama lengkap, NPM, program studi, serta peran spesifik masing-masing (contoh: *Tech Lead, Full Stack Developer, Frontend Developer, Backend & Database Engineer*).

---

## 2. Design System & Identitas Visual

### 2.1 Palet Warna Resmi
- **Widyatama Navy:** `#1E1B64` (Warna dominan institusi, header, teks judul)
- **Widyatama Accent Orange:** `#F15A24` (Aksen dinamis Widyatama, badge aktif, tombol primer)
- **Diktisaintek Cyan Blue:** `#0088FF` / `#0284C7` (Aksen resmi Diktisaintek Berdampak)
- **Diktisaintek Warm Gold:** `#FFB300` / `#F59E0B` (Badge tahun pengerjaan & highlight)
- **Latar Belakang:** Putih Bersih (`#FFFFFF`) & Slate Halus (`#F8FAFC`)
- **Teks:** Slate Gelap (`#0F172A`) & Muted Slate (`#64748B`)

### 2.2 Tipografi
- **Headings:** `Poppins` (Semi-Bold 600 / Bold 700)
- **Body & Controls:** `Inter` (Regular 400 / Medium 500)

---

## 3. Struktur Layar Antarmuka (Screen Breakdown)

### Layar 1: Landing Page (`/`)
1. **Header / Navbar Bersih:**
   - **Kiri:** Logo Universitas Widyatama + Logo Diktisaintek Berdampak + Teks *"Kampus Berdampak Widyatama"*.
   - **Tengah:** Menu navigasi (*Beranda, Portofolio Proyek, Catatan Lapangan & Blog, Tentang*).
   - **Kanan:** *(Kosong / tidak ada tombol admin)*.
2. **Hero Section dengan Foto Mainhall Widyatama:**
   - **Background:** Foto asli gedung Mainhall Universitas Widyatama (*L'Arc d'Academia*) dengan overlay navy gelap transparan (`rgba(30, 27, 100, 0.82)`).
   - **Teks Putih Kontras:**
     - Tagline: *"Program Inovasi & Pengabdian Masyarakat Sivitas Akademika"*.
     - H1: *"Etalase Proyek Digital Berdampak Universitas Widyatama"*.
     - Subtitle: *"Menghubungkan inovasi teknologi mahasiswa dan dosen untuk memajukan digitalisasi Desa Cibenda dan layanan publik terintegrasi."*
     - Input pencarian proyek langsung di dalam Hero.
3. **Katalog Proyek dengan Filter Tahun & Kategori:**
   - **Filter Terpadu:** Filter Tahun (`Semua Tahun`, `2026`, `2025`, `2024`) dan Filter Kategori (`Semua`, `Sistem Informasi Desa`, `Layanan Darurat`, `Profil Desa`).
   - **Kartu Proyek (Kaya Informasi Kontributor):**
     - Tangkapan layar dashboard aplikasi rasio 16:9.
     - Chip badge tahun (`2026`) dan mitra (`Desa Cibenda`).
     - Judul Proyek (misal: **SIGAP**, **SIDUtama**, **SI Desa Cibenda**).
     - Deskripsi singkat fungsi sistem (1 kalimat).
     - **Baris Kontributor Mahasiswa (Sesuai Referensi):**
       - Deretan avatar foto profil melingkar bertumpuk (*stacked circle avatars*).
       - Teks detail: *"Kontributor: Naufal Fadhiil (NPM: 230611103 - Teknik Informatika), Raka Pratama (NPM: 230611115 - Teknik Informatika), Siti Nurhaliza (NPM: 230611120 - Teknik Informatika)"*.
     - Tombol: *"Lihat Detail Proyek"* dan *"Kunjungi Web ↗"*.
4. **Section Catatan Lapangan & Dokumentasi Tim:**
   - 3 kartu artikel blog dengan foto-foto asli mahasiswa saat sosialisasi, pelatihan operator, dan serah terima sistem di Balai Desa Cibenda.
5. **Footer:** Co-branding Universitas Widyatama & Diktisaintek Berdampak.

---

### Layar 2: Halaman Detail Proyek (`/projek/:slug`)
1. **Breadcrumb:** `Beranda / Portofolio Proyek / SIGAP`
2. **Header Proyek (Fokus Teks, Tanpa Tombol Buka Web):**
   - Judul Utama: *"SIGAP — Sistem Informasi Tanggap Darurat & Pengaduan Warga"*
   - Metadata: `Tahun Pengerjaan: 2026` • `Mitra: Desa Cibenda, Bandung Barat` • `Status: 🟢 Aktif / Terimplementasi`
   - *(Tombol "Buka Aplikasi Web" di header atas telah dihapus)*.
3. **Showcase Dashboard Web (Flat 16:9):**
   - Bingkai browser minimalis resolusi tinggi menampilkan dashboard utama SIGAP.
4. **Dua Kolom Konten:**
   - **Kolom Kiri (Latar Belakang, Fitur, & Galeri Lapangan):**
     - Latar Belakang & Urgensi Masalah di Desa Cibenda.
     - Fitur Utama Sistem (Pelaporan panik real-time, penandaan lokasi GPS, integrasi notifikasi WhatsApp).
     - Galeri 4 foto dokumentasi mahasiswa saat pengujian sistem dan wawancara perangkat desa.
   - **Kolom Kanan (Profil Dosen, Tim Mahasiswa, & Logo Tech Stack):**
     - **Dosen Pembimbing:** Foto profil melingkar, Nama: Dr. Hendra Wijaya, M.Kom., Peran: *Dosen Pembimbing / Penanggung Jawab*.
     - **Tim Mahasiswa Pengembang:**
       - Member 1: Foto profil bulat • Naufal Fadhiil • NPM: 230611103 • S1 Teknik Informatika • Peran: *Tech Lead & Full Stack Developer*.
       - Member 2: Foto profil bulat • Raka Pratama • NPM: 230611115 • S1 Teknik Informatika • Peran: *Frontend Developer*.
       - Member 3: Foto profil bulat • Siti Nurhaliza • NPM: 230611120 • S1 Teknik Informatika • Peran: *Backend & Database Engineer*.
     - **Tech Stack (Logo Ikon Resmi):** Menampilkan logo resmi berwarna Next.js, Tailwind CSS, PostgreSQL, Node.js, dan Leaflet Maps disertai nama teknologi di bawah tiap logo (bukan sekadar pil teks).
     - *(Tombol "Kunjungi Website Proyek" di bawah sidebar telah dihapus)*.

---

### Layar 3: Halaman Login Admin (`/admin/login`)
- Tampilan form login terpusat (*centered card*) dengan latar belakang slate netral bersih.
- Logo Universitas Widyatama berdampingan dengan logo Diktisaintek Berdampak.
- Judul: *"Portal Pengelola Kampus Berdampak"*.
- Input: Username / Email Institusi, Password, Checkbox *"Ingat sesi ini"*.
- Tombol: *"Masuk ke Panel Admin"* (Navy Blue Button).

---

### Layar 4: Halaman Admin Input & CMS Proyek (`/admin/projek/baru`)
- Layout Admin Panel dengan Sidebar (Dashboard, Kelola Proyek, Catatan Lapangan, Pengaturan Akun).
- Form Lengkap Input Proyek Baru:
  1. **Informasi Proyek:** Judul Proyek, Slug URL, Tahun Pengerjaan (dropdown: 2024, 2025, 2026), Kategori, Nama Desa Mitra (misal: Desa Cibenda), dan URL Aplikasi Web Live.
  2. **Upload Thumbnail Dashboard:** Area drag-and-drop untuk screenshot dashboard utama aplikasi rasio 16:9.
  3. **Manajemen Tim Mahasiswa (Dynamic Repeater):**
     - Input untuk menambahkan kontributor: Upload Foto Profil, Nama Lengkap, Nomor NPM, Program Studi/Jurusan, dan Pilihan Peran (*Tech Lead, Full Stack, Frontend, Backend, UI/UX Designer*).
  4. **Dosen Pembimbing:** Upload foto profil dosen, Nama Lengkap dengan gelar, dan jabatan.
  5. **Pemilihan Tech Stack:** Checkbox berikon logo (Next.js, React, Tailwind CSS, PostgreSQL, Node.js, Laravel, Flutter, dll.).
  6. **Cerita Dampak & Latar Belakang:** Rich text editor untuk penjelasan masalah dan solusi.
  7. **Multi-upload Galeri Lapangan:** Upload banyak foto kegiatan di desa dengan input caption.
  8. **Tombol Aksi:** *"Simpan sebagai Draft"* dan *"Publikasikan Proyek"*.

---

## 4. Kumpulan Prompt Siap Pakai untuk Google Stitch

Salin (*copy-paste*) prompt di bawah ini langsung ke **Google Stitch**:

### Prompt 1: Landing Page (Hero Mainhall Widyatama, Profil Kontributor NPM di Card, Tanpa Tombol Admin)
```text
Create a clean, highly realistic, and professional web prototype landing page for "Berdampak Utama" (domain: berdampak.widyatama.ac.id), an academic impact portfolio website by Universitas Widyatama Bandung in partnership with Diktisaintek Berdampak.

Visual Style:
- Professional university website design: DO NOT use tilted 3D floating dashboard cards or generic AI slop. Keep all layouts flat, modern, and human-centric.
- Color Palette: Deep Institutional Navy Blue (#1E1B64), Vibrant Accent Orange (#F15A24), Diktisaintek Cyan (#0088FF), Clean White (#FFFFFF), and soft slate background (#F8FAFC).
- Typography: Poppins for headings, Inter for body text.

Page Components:
1. Header / Navbar:
   - Left side: Dual logos side-by-side — Universitas Widyatama logo and Diktisaintek Berdampak logo, with text "Kampus Berdampak Widyatama".
   - Center navigation links: "Beranda", "Portofolio Proyek", "Catatan Lapangan & Blog", "Tentang".
   - Right side: Empty / NO admin button (admin access is strictly via URL).

2. Hero Section (Featuring Universitas Widyatama Mainhall):
   - Background: Realistic photograph of Universitas Widyatama's iconic Mainhall building ("L'Arc d'Academia" white colonnade building with flags) covered with an elegant dark navy blue transparent overlay (rgba(30, 27, 100, 0.85)) for crisp text readability.
   - Text in pure white:
     * Small pill badge: "Program Inovasi & Pengabdian Masyarakat Sivitas Akademika"
     * Bold H1 Headline: "Etalase Proyek Digital Sivitas Akademika Universitas Widyatama"
     * Subheadline: "Menghadirkan dampak nyata melalui inovasi sistem informasi dan aplikasi terintegrasi karya mahasiswa dan dosen dalam mendukung digitalisasi Desa Cibenda dan pelayanan publik."
     * Integrated clean search bar with input: "Cari proyek berdasarkan nama, kategori, atau desa..." and a search button.

3. Project Portfolio Section:
   - Section Title: "Daftar Portofolio Proyek".
   - Filter Controls:
     * Year Filter pills: [Semua Tahun | 2026 | 2025 | 2024]
     * Category Filter pills: [Semua | Sistem Informasi Desa | Layanan Darurat | Profil Desa]
   - Grid with 3 realistic project cards:
     * Card 1 (SIGAP):
       - 16:9 flat dashboard screenshot preview of SIGAP emergency dispatcher system.
       - Badges: "2026" & "Desa Cibenda".
       - Title: "SIGAP" (Sistem Informasi Gawat Darurat & Pengaduan Warga).
       - Short description: "Sistem tanggap darurat real-time untuk penanganan insiden dan aduan warga Desa Cibenda."
       - Contributor section with circular profile photos: Overlapping circular avatar photos of 3 students, followed by readable text: "Kontributor: Naufal Fadhiil (NPM: 230611103 - Teknik Informatika), Raka Pratama (NPM: 230611115 - Teknik Informatika), Siti Nurhaliza (NPM: 230611120 - Teknik Informatika)".
       - Action buttons: "Lihat Detail Proyek" and "Kunjungi Web ↗".
     * Card 2 (SIDUtama):
       - 16:9 screenshot of SIDUtama population & administrative dashboard.
       - Badges: "2025" & "Desa Cibenda".
       - Title: "SIDUtama".
       - Short description: "Platform administrasi kependudukan dan tata kelola surat digital desa terintegrasi."
       - Contributor avatars and text: "Kontributor: Ahmad Fauzi (NPM: 220611045 - Teknik Informatika), Dinda Kirana (NPM: 220611088 - Sistem Informasi)".
       - Action buttons: "Lihat Detail Proyek" and "Kunjungi Web ↗".
     * Card 3 (SI Desa Cibenda):
       - 16:9 screenshot of Desa Cibenda official public web portal.
       - Badges: "2024" & "Desa Cibenda".
       - Contributor avatars and text: "Kontributor: Farhan Maulana (NPM: 210611012 - Teknik Informatika), Budi Santoso (NPM: 210611034 - Sistem Informasi)".
       - Action buttons: "Lihat Detail Proyek" and "Kunjungi Web ↗".

4. Field Documentation & Blog Section ("Catatan Lapangan"):
   - Section title: "Catatan Lapangan & Dokumentasi Tim".
   - 3 clean article cards featuring real photos of students and lecturers training village staff and presenting the software at Desa Cibenda village hall.
   - Button: "Lihat Semua Catatan Kegiatan →".

5. Footer:
   - Universitas Widyatama logo & Diktisaintek Berdampak logo.
   - Campus address: Jl. Cikutra No. 204A, Bandung, Jawa Barat.
   - Copyright © 2026 Universitas Widyatama.
```

---

### Prompt 2: Halaman Detail Proyek (`/projek/:slug` — Tanpa Tombol Buka Web, Tech Stack Logo, Foto Tim & Dosen Pembimbing)
```text
Design a clean, academically rigorous, and prototype-ready Project Detail Page for "SIGAP" on berdampak.widyatama.ac.id.

Visual Style:
- Clean institutional academic layout with Universitas Widyatama Navy (#1E1B64) and Accent Orange (#F15A24).

Page Structure:
1. Breadcrumb: Beranda > Portofolio Proyek > SIGAP.
2. Project Header Bar (Strictly Focused on Text & Title — NO "Buka Aplikasi Web" button):
   - Large Title: "SIGAP — Sistem Informasi Tanggap Darurat & Pengaduan Warga".
   - Metadata badges: "Tahun Pengerjaan: 2026" | "Mitra: Desa Cibenda, Bandung Barat" | "Status: 🟢 Aktif / Terimplementasi".
   - (NOTE: Do NOT include any "Buka Aplikasi Web" button in the header).

3. Main Showcase:
   - Full-width, clean 16:9 browser mockup displaying the real SIGAP application dashboard interface.

4. Two-Column Content Layout:
   - Left Content Column:
     * Section "Latar Belakang & Urgensi Masalah": Context on why emergency reporting was needed for Desa Cibenda residents.
     * Section "Fitur Utama Sistem": List of features (One-touch panic alert, GPS incident coordinates mapping, automatic WhatsApp notification to local RT/RW officers).
     * Section "Galeri Dokumentasi Tim di Desa": Responsive 4-photo gallery showing student developers training village staff, testing hardware, and interacting with village leaders.
   
   - Right Sidebar Column:
     * Dosen Pembimbing Section:
       - Circular portrait photo of the lecturer.
       - Name: Dr. Hendra Wijaya, M.Kom.
       - Subtitle: "Dosen Pembimbing & Penanggung Jawab Proyek".
     * Tim Mahasiswa Pengembang Section:
       - Member 1: Circular photo + Name: "Naufal Fadhiil" + "NPM: 230611103" + "S1 Teknik Informatika" + Role badge: "Tech Lead & Full Stack Developer".
       - Member 2: Circular photo + Name: "Raka Pratama" + "NPM: 230611115" + "S1 Teknik Informatika" + Role badge: "Frontend Developer".
       - Member 3: Circular photo + Name: "Siti Nurhaliza" + "NPM: 230611120" + "S1 Teknik Informatika" + Role badge: "Backend & Database Engineer".
     * Tech Stack Section (Using Official Colored Logos, NOT Plain Text):
       - A neat grid of official tech logos with labels underneath: Next.js logo icon, Tailwind CSS logo, PostgreSQL elephant logo, Node.js hexagon logo, and Leaflet Maps logo.
     * Metadata: "Tahun: 2026" | "Mitra: Pemerintah Desa Cibenda".
     * (NOTE: Do NOT add any "Kunjungi Website Proyek" button at the bottom of the sidebar. Keep the focus entirely on project showcase and documentation).
```

---

### Prompt 3: Halaman Login Admin (`/admin/login`)
```text
Design a minimalist, secure, and clean Admin Login Page for the portal berdampak.widyatama.ac.id.

Visual Style:
- Academic university portal authentication design. Clean soft-slate background (#F8FAFC) with a centered white card.
- Brand colors: Universitas Widyatama Navy (#1E1B64) and Accent Orange (#F15A24).

Layout Elements:
1. Centered Card:
   - Top: Universitas Widyatama logo and Diktisaintek Berdampak logo side-by-side.
   - Title: "Portal Pengelola Kampus Berdampak"
   - Subtitle: "Silakan masuk untuk mengelola portofolio proyek dan dokumentasi tim."
   - Form Inputs:
     * "Email Institusi / Username": Input field with user icon and placeholder "admin@widyatama.ac.id".
     * "Kata Sandi": Password input field with lock icon and show/hide password eye icon.
     * "Ingat sesi saya" checkbox and "Lupa kata sandi?" link.
   - Primary Action Button: "Masuk ke Panel Pengelola" in solid Widyatama Navy Blue.
   - Security Notice: "Akses terbatas hanya untuk tim pengelola LPPM dan IT Universitas Widyatama."
2. Bottom: Simple copyright notice © 2026 Universitas Widyatama.
```

---

### Prompt 4: Halaman Admin Input & CMS Proyek (`/admin/projek/baru`)
```text
Design a comprehensive, user-friendly CMS Data Entry page for adding a new project at /admin/projek/baru on berdampak.widyatama.ac.id.

Visual Style:
- University administration CMS layout: Deep Navy Blue (#1E1B64) vertical left sidebar, clean white form cards on a soft gray canvas, and vibrant orange (#F15A24) primary save button.

Page Components:
1. Admin Sidebar:
   - Universitas Widyatama logo + "Admin Berdampak".
   - Navigation links: Dashboard, Kelola Proyek (active), Catatan Lapangan / Blog, Pengaturan Akun, Keluar.
2. Top Bar:
   - Breadcrumb: Admin > Kelola Proyek > Tambah Proyek Baru.
   - Admin Profile badge with name "LPPM Widyatama".
3. Main Data Entry Form (Structured Cards):
   - Card 1: Informasi Dasar Proyek:
     * Field "Judul Proyek": Text input (e.g. SIGAP).
     * Field "Slug URL": Auto-generated (e.g. /projek/sigap).
     * Field "Tahun Pengerjaan": Dropdown selector (2026, 2025, 2024, 2023).
     * Field "Kategori / Mitra": Text input (e.g. Desa Cibenda - Sistem Informasi Desa).
     * Field "URL Aplikasi Live": Input link (e.g. https://sigap.desa-cibenda.id).
     * Field "Deskripsi Singkat": 1-2 sentence summary for project cards.
   - Card 2: Upload Tangkapan Layar Dashboard:
     * 16:9 Drag-and-drop cover photo uploader with preview frame.
   - Card 3: Manajemen Tim Pengembang & Dosen Pembimbing:
     * Dosen Pembimbing section: Photo uploader, Name input with academic title, and Role input.
     * Mahasiswa Contributors (Repeater list with "+ Tambah Kontributor"):
       - Row 1: Profile photo uploader, Nama Mahasiswa, Nomor NPM (e.g. 230611103), Jurusan (dropdown: Teknik Informatika, Sistem Informasi, dll.), and Role dropdown (Tech Lead, Full Stack, Frontend, Backend, UI/UX Designer).
   - Card 4: Pilihan Tech Stack (Multi-select with logo icons):
     * Checkbox list with official tech logos: Next.js, React, Tailwind CSS, PostgreSQL, Node.js, Express, Laravel, Python.
   - Card 5: Cerita Dampak & Dokumentasi Lapangan:
     * Rich text editor for "Latar Belakang", "Solusi", and "Fitur Utama".
     * Multi-image file uploader for field documentation photos at Desa Cibenda with caption inputs.
   - Form Actions at the bottom:
     * Toggle "Publikasikan ke Website".
     * "Simpan sebagai Draft" (outlined) and "Publikasikan Proyek" (solid orange).
```
