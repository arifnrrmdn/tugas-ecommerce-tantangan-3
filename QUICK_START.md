# Quick Start Guide

## 🚀 Instalasi Cepat

### 1. Install PHP 8.2+ (pilih sesuai distro)

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install -y php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-mbstring php8.2-xml php8.2-zip php8.2-sqlite3 php8.2-gd php8.2-bcmath
```

**Fedora/RHEL/CentOS:**
```bash
sudo dnf install -y php php-cli php-common php-curl php-mbstring php-xml php-zip php-sqlite3 php-gd php-bcmath
```

**Arch Linux:**
```bash
sudo pacman -S php php-sqlite php-gd
```

### 2. Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 3. Jalankan Script Instalasi Otomatis
```bash
./install.sh
```

Script ini akan otomatis:
- ✅ Cek semua requirements
- ✅ Install dependencies PHP (composer install)
- ✅ Setup file .env
- ✅ Generate application key
- ✅ Buat database SQLite
- ✅ Jalankan migrations
- ✅ Jalankan seeders (isi data awal)
- ✅ Install dependencies Node.js
- ✅ Build assets

### 4. Jalankan Aplikasi
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 📋 Perintah Manual (jika tidak pakai script)

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Setup database
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# 4. Build assets
npm run build

# 5. Jalankan server
php artisan serve
```

---

## 🛠️ Perintah Berguna

```bash
# Jalankan server development
php artisan serve

# Jalankan dengan hot reload (2 terminal)
php artisan serve          # Terminal 1
npm run dev                # Terminal 2

# Jalankan semua service sekaligus
composer dev

# Lihat semua routes
php artisan route:list

# Reset database dengan data baru
php artisan migrate:fresh --seed

# Clear cache
php artisan cache:clear
php artisan config:clear

# Masuk ke Laravel Tinker (REPL)
php artisan tinker
```

---

## 📁 Struktur Projek

```
app/
├── Http/Controllers/
│   ├── ProdukController.php      # Controller untuk produk
│   └── PelangganController.php   # Controller untuk pelanggan
└── Models/
    ├── Produk.php                 # Model produk
    ├── Kategori.php               # Model kategori
    ├── Pelanggan.php              # Model pelanggan
    └── User.php                   # Model user

database/
├── migrations/                    # Database migrations
└── seeders/                       # Database seeders
    ├── ProdukSeeder.php
    ├── KategoriSeeder.php
    └── PelangganSeeder.php

resources/
└── views/
    ├── produk/                    # Views untuk produk
    └── pelanggan/                 # Views untuk pelanggan
```

---

## 🗄️ Database

Projek ini menggunakan **SQLite** secara default (tidak perlu install MySQL).

File database: `database/database.sqlite`

**Tabel yang tersedia:**
- `produk` - Data produk
- `kategori` - Kategori produk  
- `pelanggan` - Data pelanggan
- `users` - User authentication
- `sessions` - Session management
- `cache` - Cache storage

---

## 🌐 Routes/Endpoints

Setelah menjalankan `php artisan serve`, akses:

- **Produk**: http://localhost:8000/produk
- **Pelanggan**: http://localhost:8000/pelanggan

Lihat semua routes: `php artisan route:list`

---

## ❗ Troubleshooting

### Permission denied pada storage
```bash
chmod -R 775 storage bootstrap/cache
```

### SQLite extension tidak ditemukan
```bash
# Ubuntu/Debian
sudo apt install php8.2-sqlite3

# Fedora/RHEL
sudo dnf install php-pdo php-sqlite3

# Restart PHP jika perlu
```

### Port 8000 sudah digunakan
```bash
# Gunakan port lain
php artisan serve --port=8080
```

### Composer memory limit
```bash
# Jalankan dengan memory unlimited
php -d memory_limit=-1 /usr/local/bin/composer install
```

---

## 📚 Dokumentasi Lengkap

Lihat **SETUP_GUIDE.md** untuk dokumentasi lengkap dan troubleshooting detail.

---

## ✅ Checklist Setup

- [ ] PHP 8.2+ terinstall
- [ ] Composer terinstall
- [ ] Node.js terinstall (sudah ✓)
- [ ] Jalankan `./install.sh` atau setup manual
- [ ] File `.env` sudah ada
- [ ] Database SQLite sudah dibuat
- [ ] Migrations sudah dijalankan
- [ ] Seeders sudah dijalankan
- [ ] Assets sudah di-build
- [ ] Server berjalan di http://localhost:8000

**Selamat coding! 🎉**
