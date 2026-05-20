# ✅ SOLUSI: Foto Pelanggan Tidak Muncul

## 🔍 Masalah
Setelah upload foto pelanggan, gambar tidak muncul di halaman.

## 🎯 Penyebab
**Storage symlink salah atau tidak ada.**

Laravel menyimpan file upload di `storage/app/public/`, tapi untuk bisa diakses dari browser, harus ada symlink dari `public/storage` ke `storage/app/public`.

Symlink sebelumnya mengarah ke path user lain (`/home/azazil/...`) bukan path yang benar (`/home/ariev/...`).

## ✅ Solusi (Sudah Diperbaiki)

Jalankan perintah ini:

```bash
# Hapus symlink lama yang salah
rm public/storage

# Buat symlink baru yang benar
php artisan storage:link

# Set permissions
chmod -R 755 storage/app/public
```

## 🧪 Verifikasi

Jalankan script test:
```bash
./test-storage.sh
```

Atau cek manual:
```bash
# Cek symlink
ls -la public/storage

# Harus mengarah ke:
# public/storage -> /home/ariev/Developments/tugas-ecommerce-tantangan-3/storage/app/public
```

## 🎯 Cara Kerja

### 1. File disimpan di:
```
storage/app/public/pelanggan/nama_file.jpg
```

### 2. Symlink menghubungkan:
```
public/storage -> storage/app/public
```

### 3. Browser mengakses via:
```
http://localhost:8000/storage/pelanggan/nama_file.jpg
```

### 4. Di Blade template:
```php
<img src="{{ asset('storage/pelanggan/'.$item->foto) }}">
```

## 📝 Kapan Harus Jalankan `php artisan storage:link`?

Jalankan setiap kali:
- ✅ Pertama kali setup projek
- ✅ Setelah clone dari Git
- ✅ Setelah pindah folder projek
- ✅ Setelah deploy ke server
- ✅ Jika foto tidak muncul

## 🚀 Test Upload

1. Jalankan server:
```bash
php artisan serve
```

2. Buka browser:
```
http://localhost:8000/pelanggan/create
```

3. Upload foto pelanggan

4. Cek di list pelanggan - foto harus muncul!

## 🔧 Troubleshooting Lanjutan

Jika masih tidak muncul, lihat file:
- **TROUBLESHOOTING_UPLOAD.md** - Panduan lengkap troubleshooting

Atau jalankan:
```bash
./test-storage.sh
```

## ✅ Status Saat Ini

Berdasarkan test terakhir:
- ✅ Symlink sudah benar
- ✅ Folder pelanggan ada
- ✅ Permissions sudah tepat (775)
- ✅ Konfigurasi .env sudah benar (FILESYSTEM_DISK=public)
- ✅ File bisa diakses via symlink
- ✅ Ada 1 pelanggan dengan foto

**Foto sekarang sudah bisa muncul dengan benar!** 🎉
