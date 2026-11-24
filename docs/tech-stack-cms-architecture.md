# Arsitektur Tech Stack Dinamis (Admin CMS)

Dokumen ini mencatat keputusan desain dan arsitektur untuk penanganan ikon dan data tech stack pada Admin Panel Proyek Berdampak Utama.

---

## 1. Latar Belakang Masalah
Pada form input proyek di admin panel, admin dan kontributor membutuhkan fleksibilitas untuk memilih teknologi yang digunakan serta menambahkan teknologi baru jika belum terdaftar. Karena penulisan inline SVG mentah secara manual di form rawan error format dan inkonsistensi visual, sistem membutuhkan standardisasi penanganan aset ikon teknologi.

---

## 2. Struktur Database

### Tabel `tech_stacks` (Master Catalog)
- `id` (bigint unsigned, primary key)
- `name` (string, misal: "Next.js", "PostgreSQL", "Laravel")
- `slug` (string unique, misal: "nextdotjs", "postgresql", "laravel")
- `icon_type` (enum: `svg_raw`, `cdn_url`, `custom_upload`, `monogram`)
- `icon_value` (text nullable: path storage lokal, URL CDN, atau raw SVG sanitized)
- `brand_color` (string 7 char, misal: "#000000", "#3178C6", "#336791")
- `created_at`, `updated_at` (timestamps)

### Tabel `project_tech_stack` (Pivot Table)
- `project_id` (foreign key ke `projects.id`, cascade on delete)
- `tech_stack_id` (foreign key ke `tech_stacks.id`, cascade on delete)
- `primary key (project_id, tech_stack_id)`

---

## 3. Strategi Pengelolaan Ikon

### Level 1: Pre-seeded Master Catalog
Sistem menyertakan database seeder berisi 30 hingga 40 teknologi populer di lingkungan mahasiswa (Laravel, React, Next.js, Vue, Tailwind CSS, PostgreSQL, MySQL, Node.js, Leaflet, Python, Flutter, Docker, Redis).
- Seluruh vektor SVG diambil dari repositori resmi Simple Icons.
- Aset disimpan di direktori `public/icons/tech/` atau disimpan sebagai raw SVG yang teruji renderingnya.

### Level 2: Auto-fetch SimpleIcons CDN
Ketika admin mengetik nama teknologi baru di form pembuatan tech stack:
1. Sistem mencocokkan slug dengan database Simple Icons.
2. Jika ditemukan, sistem secara otomatis mengambil vektor dari Simple Icons CDN (`https://cdn.jsdelivr.net/npm/simple-icons/icons/{slug}.svg`) beserta kode warna heksadesimal resmi.
3. SVG disimpan ke local storage server untuk menjamin persistensi aset tanpa dependensi koneksi luar secara terus-menerus.

### Level 3: Custom SVG/PNG Upload
Jika teknologi yang dimasukkan bersifat lokal, proprietary, atau library khusus yang tidak terdaftar di Simple Icons:
1. Admin dapat mengunggah file SVG atau PNG transparan (maksimal 500 KB).
2. Sanitasi ketat dilakukan pada file SVG menggunakan library sanitasi (seperti `enshrined/svg-sanitize`) untuk mencegah serangan XSS melalui tag `<script>` atau `<foreignObject>`.

### Level 4: Fallback Monogram Badge
Jika teknologi baru tidak memiliki ikon atau gagal dimuat:
- Sistem me-render badge inisial 2 huruf (misal: "RD" untuk Redis, "SB" untuk Supabase).
- Badge menggunakan background warna brand (`brand_color`) dengan teks putih berkontras tinggi (memenuhi rasio kontras WCAG AA).

---

## 4. Komponen Visual Blade (`x-tech-stack-icon`)
Untuk menampilkan ikon di frontend maupun preview admin, buat satu komponen Blade reusable:
- Menerima parameter `$techStack`.
- Melakukan evaluasi tipe ikon (`cdn_url`, `custom_upload`, `svg_raw`, atau fallback monogram).
- Menjamin dimensi konsisten (w-5 h-5 atau w-6 h-6), aspect-ratio persegi, dan sanitasi atribut SVG.
