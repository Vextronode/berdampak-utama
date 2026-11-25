#!/usr/bin/env bash
set -e

cd /var/www/html

echo "[entrypoint] Menyiapkan direktori storage dan bootstrap/cache..."
mkdir -p \
    storage/app/public \
    storage/app/private \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

# Pastikan symlink storage tersedia agar gambar upload CMS bisa diakses publik
if [ ! -L public/storage ] || [ ! -e public/storage ]; then
    echo "[entrypoint] Membuat symlink public/storage..."
    php artisan storage:link --force || true
fi

# Pastikan APP_KEY tersedia (jika user lupa mengisi APP_KEY, buat kunci persisten di storage)
KEY_FILE="storage/app/.docker_app_key"
if [ -z "${APP_KEY:-}" ]; then
    if [ -f "$KEY_FILE" ]; then
        APP_KEY="$(cat "$KEY_FILE")"
        export APP_KEY
        echo "[entrypoint] Menggunakan APP_KEY tersimpan dari $KEY_FILE."
    else
        APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
        echo "$APP_KEY" > "$KEY_FILE"
        chown www-data:www-data "$KEY_FILE"
        chmod 600 "$KEY_FILE"
        export APP_KEY
        echo "[entrypoint] PERINGATAN: APP_KEY kosong. Kunci otomatis dibuat di $KEY_FILE."
        echo "[entrypoint] Untuk production multi-server, isi APP_KEY secara permanen di .env.docker."
    fi
fi

# Siapkan file SQLite otomatis jika DB_CONNECTION=sqlite
DB_CONN="${DB_CONNECTION:-mysql}"
SQLITE_PATH=""
if [ "$DB_CONN" = "sqlite" ]; then
    if [ -z "${DB_DATABASE:-}" ]; then
        export DB_DATABASE="/var/www/html/storage/app/database.sqlite"
    fi
    SQLITE_PATH="$DB_DATABASE"
    if [ "$SQLITE_PATH" != ":memory:" ]; then
        SQLITE_DIR="$(dirname "$SQLITE_PATH")"
        mkdir -p "$SQLITE_DIR"
        touch "$SQLITE_PATH"
        if [ "$SQLITE_DIR" != "/tmp" ] && [ "$SQLITE_DIR" != "/var/tmp" ]; then
            chown -R www-data:www-data "$SQLITE_DIR"
        fi
    fi
fi

# Tunggu database siap menerima koneksi (untuk MySQL, MariaDB, PostgreSQL)
if [ "$DB_CONN" = "mysql" ] || [ "$DB_CONN" = "mariadb" ] || [ "$DB_CONN" = "pgsql" ]; then
    WAIT_TIMEOUT="${DOCKER_WAIT_DB_TIMEOUT:-60}"
    echo "[entrypoint] Menunggu koneksi database ($DB_CONN di ${DB_HOST:-db}:${DB_PORT:-3306})..."
    elapsed=0
    until php -r '
        $conn = getenv("DB_CONNECTION") ?: "mysql";
        $host = getenv("DB_HOST") ?: "127.0.0.1";
        $port = getenv("DB_PORT") ?: ($conn === "pgsql" ? "5432" : "3306");
        $db   = getenv("DB_DATABASE") ?: "berdampak_utama";
        $user = getenv("DB_USERNAME") ?: "root";
        $pass = getenv("DB_PASSWORD") ?: "";
        $driver = $conn === "pgsql" ? "pgsql" : "mysql";
        try {
            new PDO("$driver:host=$host;port=$port;dbname=$db", $user, $pass, [PDO::ATTR_TIMEOUT => 3]);
            exit(0);
        } catch (Throwable $e) {
            exit(1);
        }
    '; do
        elapsed=$((elapsed + 2))
        if [ "$elapsed" -ge "$WAIT_TIMEOUT" ]; then
            echo "[entrypoint] ERROR: Database tidak merespons setelah ${WAIT_TIMEOUT} detik."
            exit 1
        fi
        sleep 2
    done
    echo "[entrypoint] Database terhubung."
fi

# Jalankan migrasi otomatis
if [ "${DOCKER_AUTO_MIGRATE:-true}" = "true" ]; then
    echo "[entrypoint] Menjalankan php artisan migrate --force..."
    php artisan migrate --force
fi

# Seed awal otomatis HANYA jika tabel users masih kosong
if [ "${DOCKER_AUTO_SEED_IF_EMPTY:-true}" = "true" ]; then
    USER_COUNT="$(php -r '
        require "vendor/autoload.php";
        $app = require "bootstrap/app.php";
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        try {
            echo App\Models\User::count();
        } catch (Throwable $e) {
            echo "-1";
        }
    ')"
    if [ "$USER_COUNT" = "0" ]; then
        echo "[entrypoint] Tabel users kosong. Menjalankan initial seed (katalog TechStack saja)..."
        php artisan db:seed --force
    else
        echo "[entrypoint] Data users sudah ada ($USER_COUNT akun). Melewati auto-seed."
    fi
fi

# Cache konfigurasi sesuai environment runtime
php artisan optimize:clear
if [ "${APP_ENV:-production}" = "production" ]; then
    echo "[entrypoint] Membangun cache optimasi production..."
    php artisan optimize
fi

chown -R www-data:www-data storage bootstrap/cache
if [ -n "$SQLITE_PATH" ] && [ "$SQLITE_PATH" != ":memory:" ] && [ -f "$SQLITE_PATH" ]; then
    chown www-data:www-data "$SQLITE_PATH"
fi
echo "[entrypoint] Aplikasi siap melayani request di port 80."
exec "$@"
