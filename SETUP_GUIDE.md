# Panduan Setup Projek Laravel di Linux

## Status Instalasi Saat Ini
- ✅ Node.js v22.22.2 (sudah terinstall)
- ❌ PHP 8.2+ (belum terinstall)
- ❌ Composer (belum terinstall)
- ✅ Database: SQLite (tidak perlu MySQL, cukup PHP SQLite extension)

## Langkah 1: Install PHP 8.2+

### Untuk Ubuntu 22.04 (Jammy) / Ubuntu 20.04 (Focal):

> **Catatan:** Ubuntu 22.04 hanya menyediakan PHP 8.1 secara default. Untuk PHP 8.2, perlu menambahkan PPA `ondrej/php` terlebih dahulu.

```bash
# Tambahkan PPA ondrej/php (sumber paket PHP terbaru)
sudo apt update
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.2 dan extensions yang diperlukan
sudo apt install -y php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-mbstring php8.2-xml php8.2-zip php8.2-sqlite3 php8.2-gd php8.2-bcmath

# Verifikasi instalasi
php --version
```

### Untuk Fedora/RHEL/CentOS:
```bash
# Install PHP 8.2
sudo dnf install -y php php-cli php-common php-curl php-mbstring php-xml php-zip php-sqlite3 php-gd php-bcmath

# Verifikasi instalasi
php --version
```

### Untuk Arch Linux:
```bash
# Install PHP
sudo pacman -S php php-sqlite php-gd

# Verifikasi instalasi
php --version
```

## Langkah 2: Install Composer

```bash
# Download Composer installer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

# Verifikasi installer (opsional)
php -r "if (hash_file('sha384', 'composer-setup.php') === file_get_contents('https://composer.github.io/installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

# Install Composer secara global
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Hapus installer
php -r "unlink('composer-setup.php');"

# Verifikasi instalasi
composer --version
```

## Langkah 3: Setup Projek Laravel

```bash
# Masuk ke direktori projek
cd /home/ariev/Developments/tugas-ecommerce-tantangan-3

# Install dependencies PHP
composer install

# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Buat database SQLite
touch database/database.sqlite

# Jalankan migrasi database
php artisan migrate

# Jalankan seeder (isi data awal)
php artisan db:seed

# Install dependencies Node.js
npm install

# Build assets
npm run build
```

## Langkah 4: Jalankan Aplikasi

### Opsi 1: Jalankan server development Laravel
```bash
php artisan serve
```
Aplikasi akan berjalan di: http://localhost:8000

### Opsi 2: Jalankan dengan Vite (untuk development dengan hot reload)
Terminal 1:
```bash
php artisan serve
```

Terminal 2:
```bash
npm run dev
```

### Opsi 3: Jalankan semua service sekaligus (recommended)
```bash
composer dev
```
Ini akan menjalankan:
- Laravel server (port 8000)
- Queue worker
- Log viewer (Pail)
- Vite dev server

## Troubleshooting

### Jika ada error "permission denied" pada storage
```bash
chmod -R 775 storage bootstrap/cache
```

### Jika ada error SQLite
```bash
# Pastikan extension SQLite terinstall
php -m | grep sqlite

# Jika tidak ada, install:
# Ubuntu/Debian:
sudo apt install php8.2-sqlite3

# Fedora/RHEL:
sudo dnf install php-pdo php-sqlite3
```

### Jika ingin menggunakan MySQL (opsional)
1. Install MySQL:
```bash
# Ubuntu/Debian:
sudo apt install mysql-server php8.2-mysql

# Fedora/RHEL:
sudo dnf install mysql-server php-mysqlnd
```

2. Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=password_anda
```

3. Buat database:
```bash
mysql -u root -p
CREATE DATABASE nama_database;
exit;
```

4. Jalankan ulang migrasi:
```bash
php artisan migrate:fresh --seed
```

## Perintah Berguna

```bash
# Lihat routes
php artisan route:list

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Jalankan migrasi ulang dengan seed
php artisan migrate:fresh --seed

# Masuk ke tinker (Laravel REPL)
php artisan tinker

# Jalankan tests
php artisan test
```

## Struktur Database

Projek ini memiliki tabel:
- `produk` - Data produk
- `kategori` - Kategori produk
- `pelanggan` - Data pelanggan
- `users` - User authentication
- `sessions` - Session management
- `cache` - Cache storage

## Endpoints API/Routes

Setelah setup, Anda bisa mengakses:
- Produk: `/produk`
- Pelanggan: `/pelanggan`

Gunakan `php artisan route:list` untuk melihat semua routes yang tersedia.
