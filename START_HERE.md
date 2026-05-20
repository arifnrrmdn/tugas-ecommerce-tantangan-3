# 🎯 START HERE - Quick Reference

## ✅ Setup Status: SELESAI!

Semua instalasi dan konfigurasi sudah selesai. Aplikasi siap digunakan!

---

## 🚀 Jalankan Aplikasi SEKARANG

Pilih salah satu cara:

### 1️⃣ Cara Paling Mudah (Recommended)
```bash
php artisan serve
```
Kemudian buka browser: **http://localhost:8000**

### 2️⃣ Dengan Hot Reload (untuk development)
Buka 2 terminal:

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2:**
```bash
npm run dev
```

### 3️⃣ Semua Service Sekaligus
```bash
composer dev
```

---

## 📍 Halaman yang Bisa Diakses

Setelah server berjalan, buka:

- **Produk**: http://localhost:8000/produk
- **Pelanggan**: http://localhost:8000/pelanggan

---

## 📊 Data yang Tersedia

- ✅ **1,000 produk** (dummy data)
- ✅ **2 kategori** (Sepatu, Baju)
- ✅ **2 pelanggan** (Budi Santoso, Siti Aminah)

---

## 🔄 Reset Database (jika perlu)

```bash
php artisan migrate:fresh --seed
```

## 🖼️ Upload Foto Tidak Muncul?

Jalankan perintah ini:
```bash
php artisan storage:link
```

Lihat **TROUBLESHOOTING_UPLOAD.md** untuk detail lengkap.

---

## 📚 Dokumentasi Lengkap

- **SETUP_COMPLETE.md** - Dokumentasi lengkap setup dan troubleshooting
- **SETUP_GUIDE.md** - Panduan instalasi manual
- **QUICK_START.md** - Quick start guide

---

## 💡 Tips

1. Gunakan `php artisan route:list` untuk melihat semua routes
2. Gunakan `php artisan tinker` untuk testing di console
3. Log ada di `storage/logs/laravel.log`
4. Database SQLite ada di `database/database.sqlite`

---

## 🆘 Butuh Bantuan?

Lihat file **SETUP_COMPLETE.md** untuk troubleshooting dan perintah-perintah berguna.

---

**Selamat coding! 🎉**
