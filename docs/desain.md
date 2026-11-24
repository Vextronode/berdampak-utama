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
- Layout Admin Panel Full-Width (Tanpa Sidebar vertikal):
  - **Top Navbar:**
    - Kiri: Logo Universitas Widyatama & Logo Diktisaintek Berdampak + Teks *"Admin Berdampak Utama — Panel Pengelola"*.
    - Kanan: Profil Admin ("LPPM Widyatama") + **Tombol Logout**. *(Tombol Simpan Draft & Publikasikan di navbar dihapus)*.
- **Urutan 5 Kartu Form Input Data:**
  1. **Card 1 — Informasi Umum & Filter Proyek:** Judul Proyek, Slug URL, Filter Tahun (2026, 2025, 2024), Filter Kategori, Nama Mitra (Desa Cibenda), URL Web Live, dan Toggle Publikasi.
  2. **Card 2 — Deskripsi Proyek & Dokumentasi Lapangan:** Deskripsi Singkat, Deskripsi Lengkap & Cerita Dampak (Rich Text), dan Upload Galeri Foto Dokumentasi di Desa Cibenda (grid 4 placeholder + input caption).
  3. **Card 3 — Tangkapan Layar Dashboard Utama (16:9):** Area drag-and-drop placeholder cover screenshot aplikasi 16:9.
  4. **Card 4 — Pilihan Tech Stack:** Checkbox berikon logo resmi (Next.js, Tailwind, PostgreSQL, Node.js, dll.).
  5. **Card 5 — Tim Pengembang & Orang yang Terlibat:**
     - Sub-section Dosen Pembimbing (Foto profil, nama, gelar, peran).
     - Sub-section Kontributor Mahasiswa (Repeater list: Foto profil, nama lengkap, **NPM**, jurusan, dan pilihan peran: *Tech Lead, Full Stack, Frontend, Backend, UI/UX*).
- **Sticky Bottom Action Bar:** Tautan *"Batal & Kembali ke Daftar Proyek"*, tombol *"Simpan sebagai Draft"*, dan tombol oranye *"Publikasikan Proyek Sekarang"*.

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

### Prompt 4: Halaman Admin Input Data & CMS Proyek (`/admin/projek/baru` — Revisi: Tanpa Sidebar, Navbar dengan Logout, Urutan Baru)
```text
Design a clean, realistic, and modern Admin Panel CMS Data Entry page for adding a new project at /admin/projek/baru on the portal berdampak.widyatama.ac.id.

Visual Style:
- Professional university administration layout: FULL-WIDTH container (NO vertical left sidebar).
- Color Palette: Deep Institutional Navy Blue (#1E1B64), Vibrant Accent Orange (#F15A24), Clean White (#FFFFFF), and soft slate background (#F8FAFC).
- High prototype fidelity with visible dashed placeholder upload boxes, clear input labels, helper text, and well-structured card sections.

Layout & Structure:

1. Top Horizontal Navbar (Full-Width Navigation):
   - Left side: Dual logos side-by-side — Universitas Widyatama logo and Diktisaintek Berdampak logo, followed by bold text "Admin Berdampak Utama — Panel Pengelola".
   - Right side: Admin profile pill showing "LPPM Widyatama (Pengelola Konten)" and a red/outline "Logout" button with logout icon.
   - (NOTE: Do NOT add any vertical sidebar. Do NOT add "Simpan Draft" or "Publikasikan Proyek" in this top navbar; those action buttons belong at the bottom).

2. Breadcrumb & Page Header:
   - Breadcrumb: Admin > Kelola Proyek > Tambah Proyek Baru.
   - Large Page Title: "Input Data Proyek Baru".
   - Subtitle: "Lengkapi data proyek pengabdian masyarakat, deskripsi dampak, aset tangkapan layar, dan kontributor tim pengembang."

3. Main Form Area (Centered Structured Cards in Specific Order):

   - CARD 1: INFORMASI UMUM & FILTER PROYEK
     * Grid 2-column input layout:
       - "Judul Proyek": Text input with placeholder "Contoh: SIGAP - Sistem Informasi Tanggap Darurat".
       - "Slug URL": Disabled/auto-generated text input "/projek/sigap".
       - "Filter Tahun Pengerjaan": Dropdown selector with options [2026, 2025, 2024, 2023].
       - "Filter Kategori Proyek": Dropdown selector with options [Sistem Informasi Desa, Layanan Tanggap Darurat & Pengaduan, Tata Kelola Pemerintahan, Portal Profil Desa & UMKM].
       - "Nama Mitra / Desa Binaan": Text input with placeholder "Contoh: Pemerintah Desa Cibenda, Kab. Bandung Barat".
       - "URL Aplikasi Web Live": Text input with placeholder "https://sigap.desa-cibenda.id".
     * Toggle switch at bottom: "Status Publikasi: Langsung Tayangkan ke Website Publik" (Active green toggle).

   - CARD 2: DESKRIPSI PROYEK & DOKUMENTASI LAPANGAN (POSITIONED AS ITEM #2)
     * Field "Deskripsi Singkat": Textarea (maks. 200 karakter) for summary shown on landing page cards.
     * Field "Deskripsi Lengkap & Cerita Dampak": Rich Text WYSIWYG editor toolbar (Bold, Italic, Bullets, Numbers, Heading 2, Heading 3, Link, Quote) with content area for "Latar Belakang Masalah", "Solusi Sistem", and "Dampak Nyata bagi Warga".
     * Section "Upload Galeri Dokumentasi di Desa Cibenda":
       - Grid of 4 dashed photo placeholder upload boxes with plus icons for field documentation photos (students training village staff, testing hardware, etc.), each box having a small "Keterangan Foto / Caption" input underneath.

   - CARD 3: TANGKAPAN LAYAR DASHBOARD UTAMA (16:9)
     * Large 16:9 dashed drag-and-drop placeholder image upload container.
     * Center content inside container: Upload cloud icon, bold text "Tarik & Lepaskan Screenshot Dashboard Utama ke Sini", subtext "Format PNG, JPG, atau WebP (Rasio 16:9, Maksimal 3MB)", and a clean button "Pilih File Gambar".
     * Helper note: "Gambar ini akan menjadi cover kartu di halaman utama dan banner di halaman detail."

   - CARD 4: PILIHAN TECH STACK (DENGAN LOGO RESMI)
     * Section title: "Pilih Teknologi yang Digunakan".
     * Grid of multi-select checkbox cards featuring official color logos and tech names:
       - [x] Next.js (with black N logo)
       - [x] Tailwind CSS (with cyan wave logo)
       - [x] PostgreSQL (with blue elephant logo)
       - [x] Node.js (with green hexagon logo)
       - [ ] React (with blue atom logo)
       - [ ] Laravel (with red logo)
       - [ ] MySQL (with dolphin logo)
       - [ ] Leaflet / OpenStreetMap (with green map logo)
       - [ ] Flutter (with blue wing logo)
     * Custom input field at bottom: "Tech Stack Lainnya (pisahkan dengan koma)".

   - CARD 5: TIM PENGEMBANG & ORANG YANG TERLIBAT (MAHASISWA & DOSEN — POSITIONED AS ITEM #5)
     * Sub-section Dosen Pembimbing:
       - Row with circular dashed avatar upload placeholder (80x80px with user icon), Input "Nama Dosen & Gelar" (e.g. Dr. Hendra Wijaya, M.Kom.), and Input "Jabatan/Peran" (Dosen Pembimbing & Penanggung Jawab Proyek).
     * Sub-section Kontributor Mahasiswa (Repeater Card List):
       - Header: "Daftar Mahasiswa yang Terlibat" with a right button "+ Tambah Anggota Mahasiswa" (outline orange).
       - Row 1: Circular photo upload placeholder (64x64px), Input "Nama Lengkap" (Naufal Fadhiil), Input "Nomor NPM" (230611103), Dropdown "Jurusan" (S1 Teknik Informatika), and Dropdown "Peran" (Tech Lead & Full Stack Developer).
       - Row 2: Circular photo upload placeholder, Input "Nama Lengkap" (Raka Pratama), Input "Nomor NPM" (230611115), Dropdown "Jurusan" (S1 Teknik Informatika), and Dropdown "Peran" (Frontend Developer).
       - Row 3: Circular photo upload placeholder, Input "Nama Lengkap" (Siti Nurhaliza), Input "Nomor NPM" (230611120), Dropdown "Jurusan" (S1 Teknik Informatika), and Dropdown "Peran" (Backend & Database Engineer).

4. Sticky Bottom Action Bar:
   - Left side: "Batal & Kembali ke Daftar Proyek" (subtle gray link).
   - Right side:
     * Button "Simpan sebagai Draft" (clean white button with navy border).
     * Button "Publikasikan Proyek Sekarang" (vibrant orange button with checkmark icon).
```
