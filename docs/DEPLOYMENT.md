# Panduan Deployment Docker - Berdampak Utama

Panduan ini disusun langkah demi langkah agar aplikasi portal **Berdampak Utama** (`berdampak.widyatama.ac.id`) dapat dijalankan di server VPS atau komputer lokal memakai Docker, tanpa perlu menginstal PHP, Composer, Node.js, atau MySQL secara manual di mesin host.

---

## 1. Gambaran File yang Disiapkan

Repositori ini sudah dilengkapi empat komponen utama untuk deployment container:

1. `Dockerfile`: Membangun image multi-stage secara otomatis (Stage 1 build CSS/JS Vite dengan Node 22, Stage 2 install library PHP produksi dengan Composer, Stage 3 runtime PHP 8.4 + Apache).
2. `docker-compose.yml`: Menjalankan dua container sekaligus (`app` untuk Laravel dan `db` untuk MySQL 8.4) lengkap dengan volume penyimpanan permanen agar database dan foto upload tidak hilang saat update.
3. `.env.docker`: Daftar seluruh variabel konfigurasi siap pakai untuk lingkungan Docker.
4. `docker/entrypoint.sh`: Skrip otomatis saat container menyala yang menangani:
   - Pembuatan folder cache dan perizinan `storage`.
   - Pembuatan symlink `public/storage` agar foto upload tampil di web.
   - Pembuatan `APP_KEY` otomatis ke volume jika masih kosong.
   - Menunggu database MySQL siap menerima koneksi sebelum migrasi berjalan.
   - Menjalankan `php artisan migrate --force` dan mengisi katalog tech stack (`db:seed`) otomatis **hanya jika tabel `tech_stacks` masih kosong** (instalasi baru).

---

## 2. Syarat Minimal Server / Komputer

Pastikan mesin target sudah terpasang:

- **Git**
- **Docker Engine** dan **Docker Compose v2** (`docker compose version`)
- RAM minimal **1 GB** (disarankan **2 GB** saat proses build image di server).

Anda **tidak perlu** menginstal PHP 8.4, Composer, Node.js, atau Nginx/MySQL di sistem operasi host.

---

## 3. Cara Cepat Deploy (Paling Mudah via Docker Compose)

Ikuti langkah berurutan berikut tanpa ada yang terlewat:

### Langkah 1: Clone Repositori

```bash
git clone https://github.com/Vextronode/berdampak-utama.git
cd berdampak-utama
```

### Langkah 2: Sesuaikan File `.env.docker`

Buka file `.env.docker` menggunakan editor teks (`nano .env.docker` atau VS Code), lalu ubah bagian yang wajib disesuaikan:

```bash
nano .env.docker
```

Bagian minimal yang harus Anda periksa dan ganti sebelum server dibuka ke publik:

1. **`APP_URL`**: Isi sesuai alamat web atau IP server Anda (tanpa tanda `/` di belakang).
   - Uji coba lokal: `APP_URL=http://localhost:8080`
   - IP VPS port 8080: `APP_URL=http://103.xxx.xxx.xxx:8080`
   - Sudah pakai domain HTTPS: `APP_URL=https://berdampak.widyatama.ac.id`
2. **`APP_PORT`**: Port yang dibuka di komputer/VPS (default `8080`, ubah ke `80` jika langsung tanpa reverse proxy dan port 80 kosong).
3. **`DB_PASSWORD` dan `DB_ROOT_PASSWORD`**: Ganti dari nilai placeholder menjadi password acak yang kuat (hindari spasi atau tanda kutip agar mudah dipakai shell).
4. **`APP_KEY`** (disarankan diisi permanen): Jalankan perintah ini di terminal lalu tempel hasilnya ke `APP_KEY=`:

```bash
echo "base64:$(openssl rand -base64 32)"
```

> Catatan: Jika `APP_KEY` lupa diisi, container tetap bisa menyala karena skrip startup akan membuat kunci cadangan ke volume `storage/app/.docker_app_key`. Namun untuk produksi jangka panjang, selalu simpan `APP_KEY` Anda sendiri di `.env.docker`.

### Langkah 3: Build dan Jalankan Container

Jalankan perintah berikut dari root folder proyek:

```bash
docker compose --env-file .env.docker up -d --build
```

Penjelasan flag:
- `--env-file .env.docker`: Memastikan Compose membaca port dan password database dari `.env.docker` (bukan mencari `.env`).
- `-d`: Menjalankan container di latar belakang (*detached*).
- `--build`: Membangun image terbaru dari `Dockerfile`.

Proses pertama kali memakan waktu sekitar 1 sampai 3 menit untuk mengunduh base image serta build aset Tailwind/Vite dan vendor Composer.

### Langkah 4: Pantau Proses Startup

Pastikan migrasi database dan server web selesai tanpa error dengan melihat log:

```bash
docker compose logs -f app
```

Tunggu hingga muncul baris:

```text
[entrypoint] Aplikasi siap melayani request di port 80.
```

Tekan `Ctrl + C` untuk keluar dari tampilan log (container tetap berjalan). Cek status kedua container dengan:

```bash
docker compose ps
```

Keduanya (`berdampak_utama_app` dan `berdampak_utama_db`) harus berstatus `Up` dan `(healthy)`.

### Langkah 5: Akses Aplikasi

Setelah container berstatus `Up (healthy)`, buka browser dan akses:

- **Halaman Publik**: `http://localhost:8080` (atau sesuai `APP_PORT` dan domain Anda)
- **Panel Admin CMS**: `http://localhost:8080/apanel`

Proses startup otomatis hanya mengisi katalog tech stack sekali pada instalasi baru (data proyek dibuat lewat panel admin). Akun admin **tidak dibuat otomatis** demi keamanan produksi. Lanjut ke Langkah 6.

### Langkah 6: Membuat Akun Admin Produksi

Setelah container berjalan normal, buat akun admin secara manual lewat Tinker. Ganti nilai `name`, `email`, dan `password` sesuai kebutuhan:

```bash
docker compose exec app php artisan tinker --execute="
App\Models\User::create([
    'name'     => 'Administrator Utama',
    'email'    => 'admin@widyatama.ac.id',
    'password' => Hash::make('PasswordKuatAnda2026!'),
    'role'     => 'superadmin',
]);
"
```

Setelah perintah berhasil (tidak ada output error), login ke `/apanel` menggunakan email dan password yang baru saja Anda buat.

> Catatan: Perintah di atas menggunakan `create()` biasa. Jika ingin menjalankan ulang tanpa duplikasi, gunakan `updateOrCreate(['email' => 'admin@...'], [...field lain...])`.

---

## 4. Deploy Menggunakan `Dockerfile` Saja (Platform PaaS / DB Eksternal)

Jika Anda deploy di platform seperti **Coolify**, **Dokploy**, **Portainer**, **Railway**, atau VPS yang sudah punya server MySQL/PostgreSQL terpisah, Anda bisa langsung memakai `Dockerfile` tanpa `docker-compose.yml`.

### A. Build Image Secara Manual

```bash
docker build -t berdampak-utama:latest .
```

### B. Jalankan Container dengan Environment Variables

```bash
docker run -d \
  --name berdampak_utama \
  --restart unless-stopped \
  -p 8080:80 \
  --env-file .env.docker \
  -e APP_URL=https://berdampak.widyatama.ac.id \
  -e DB_HOST=host-mysql-anda.example.com \
  -e DB_PORT=3306 \
  -e DB_DATABASE=berdampak_utama \
  -e DB_USERNAME=user_db \
  -e DB_PASSWORD=password_db_kuat \
  -v berdampak_storage:/var/www/html/storage/app \
  berdampak-utama:latest
```

Catatan penting bila memakai PaaS (Coolify/Dokploy/Railway):
- Wajib tambahkan **Persistent Volume** ke path `/var/www/html/storage/app` agar seluruh gambar yang diunggah melalui `/apanel` tetap aman saat container di-redeploy.
- Healthcheck endpoint aplikasi tersedia di `/up` (mengembalikan HTTP `200 OK`).

---

## 5. Menggunakan Domain dan HTTPS (Reverse Proxy)

Aplikasi container mendengarkan HTTP biasa di port `80` internal. Untuk website publik dengan domain (`https://berdampak.widyatama.ac.id`), pasang Reverse Proxy di depan container (Nginx, Caddy, Cloudflare Tunnel, atau Nginx Proxy Manager) dan arahkan traffic HTTPS ke `http://127.0.0.1:8080` (sesuai `APP_PORT`).

Aplikasi ini sudah mengaktifkan `trustProxies(at: '*')` di `bootstrap/app.php`, sehingga header `X-Forwarded-Proto: https` dari proxy otomatis dikenali Laravel tanpa error mixed-content atau `419 Page Expired`.

Jika sudah sepenuhnya di belakang HTTPS, pastikan `.env.docker` disetel sebagai berikut:

```env
APP_URL=https://berdampak.widyatama.ac.id
SESSION_SECURE_COOKIE=true
```

---

## 6. Perintah Operasional Harian

### Update Aplikasi Saat Ada Kode Baru di GitHub

Data database (`mysql_data`) dan file gambar upload (`app_storage`) tidak akan hilang saat rebuild:

```bash
git pull origin main
docker compose --env-file .env.docker up -d --build
```

### Membuat atau Mengganti Password Akun Admin

Untuk membuat akun admin baru atau mereset password yang sudah ada:

```bash
# Membuat akun admin baru (ganti email dan password sesuai kebutuhan)
docker compose exec app php artisan tinker --execute="
App\Models\User::create([
    'name'     => 'Administrator Utama',
    'email'    => 'admin@widyatama.ac.id',
    'password' => Hash::make('PasswordBaruYangKuat2026!'),
    'role'     => 'superadmin',
]);
"

# Mengganti password akun yang sudah ada
docker compose exec app php artisan tinker --execute="
\$u = App\Models\User::where('email', 'admin@widyatama.ac.id')->first();
\$u->password = Hash::make('PasswordBaruYangKuat2026!');
\$u->save();
"
```

### Melihat Log Error Aplikasi atau Apache

```bash
docker compose logs -f --tail=100 app
```

### Menghentikan atau Merestart Container

```bash
# Restart aplikasi
docker compose restart app

# Menghentikan semua container (data tetap aman di volume)
docker compose down
```

> **PERINGATAN**: Jangan menjalankan `docker compose down -v` kecuali Anda memang sengaja ingin **menghapus permanen** seluruh isi database dan semua foto upload!

### Backup Database dan File Upload

```bash
# Backup database MySQL
docker compose exec -T db sh -c 'mysqldump -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' > backup_$(date +%F).sql

# Backup folder upload public
docker compose cp app:/var/www/html/storage/app/public ./backup_storage_public_$(date +%F)
```

---

## 7. Troubleshooting Masalah Umum

### 1. Error: `Bind for 0.0.0.0:8080 failed: port is already allocated`
Port `8080` di komputer/VPS sudah dipakai aplikasi lain. Buka `.env.docker`, ubah `APP_PORT=8081` (atau port bebas lain), lalu jalankan ulang `docker compose --env-file .env.docker up -d`.

### 2. Gambar yang Diupload di Admin Tampil Broken (404)
- Pastikan Anda tidak melakukan `docker compose down -v`.
- Jalankan ulang pembuatan symlink secara manual:
  ```bash
  docker compose exec app php artisan storage:link --force
  ```

### 3. Error Login CSRF / `419 Page Expired`
- Pastikan `APP_URL` di `.env.docker` persis sama dengan protokol dan domain yang diakses di browser (misalnya jangan mengakses lewat `http://IP` jika `APP_URL=https://domain.com` dan `SESSION_SECURE_COOKIE=true`).
- Setelah mengubah `.env.docker`, recreate container agar env baru terbaca dan cache konfigurasi diperbarui:
  ```bash
  docker compose --env-file .env.docker up -d --force-recreate app
  ```

### 4. Container `app` Gagal Terhubung ke Database (`Connection refused` / `Access denied`)
- Jika sebelumnya pernah menjalankan compose dengan `DB_PASSWORD` berbeda, volume lama `mysql_data` masih menyimpan password lama. Untuk lingkungan uji coba baru yang belum berisi data penting, reset volume DB dengan `docker compose down -v`, pastikan password di `.env.docker` sudah benar, lalu `up -d` lagi.
- Pastikan `DB_HOST=db` jika memakai MySQL bawaan `docker-compose.yml`.

### 5. Halaman Admin Meminta Ulang Seeding Manual
Jika ingin mengulang seed katalog tech stack:

```bash
docker compose exec app php artisan db:seed --force
```
