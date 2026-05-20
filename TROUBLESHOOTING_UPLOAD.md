# 🔧 Troubleshooting Upload Foto

## ✅ Masalah Sudah Diperbaiki!

### Masalah yang Terjadi:
Foto pelanggan yang diupload tidak muncul di halaman.

### Penyebab:
1. **Storage symlink salah** - Link mengarah ke path user lain (`/home/azazil/...` bukan `/home/ariev/...`)
2. Symlink harus dibuat ulang setiap kali projek dipindah atau di-clone

### Solusi yang Sudah Dilakukan:
```bash
# 1. Hapus symlink lama yang salah
rm public/storage

# 2. Buat symlink baru yang benar
php artisan storage:link

# 3. Set permissions yang tepat
chmod -R 755 storage/app/public/pelanggan
```

---

## 📁 Cara Kerja Upload Foto

### 1. File Disimpan di:
```
storage/app/public/pelanggan/
```

### 2. Diakses melalui symlink:
```
public/storage -> storage/app/public
```

### 3. URL di browser:
```
http://localhost:8000/storage/pelanggan/nama_file.jpg
```

### 4. Di Blade template:
```php
<img src="{{ asset('storage/pelanggan/'.$item->foto) }}">
```

---

## 🔍 Cara Cek Apakah Storage Link Benar

### Cek symlink:
```bash
ls -la public/storage
```

**Output yang benar:**
```
public/storage -> /home/ariev/Developments/tugas-ecommerce-tantangan-3/storage/app/public
```

**Output yang salah:**
```
public/storage -> /home/azazil/...  # Path user lain
```

### Cek file bisa diakses:
```bash
ls -la storage/app/public/pelanggan/
ls -la public/storage/pelanggan/
```

Kedua perintah harus menampilkan file yang sama.

---

## 🚨 Kapan Harus Jalankan `php artisan storage:link`?

Jalankan perintah ini setiap kali:

1. ✅ **Pertama kali setup projek**
2. ✅ **Setelah clone dari Git**
3. ✅ **Setelah pindah folder projek**
4. ✅ **Setelah deploy ke server**
5. ✅ **Jika foto tidak muncul**

---

## 🛠️ Troubleshooting Lainnya

### Foto masih tidak muncul?

#### 1. Cek apakah file benar-benar ada:
```bash
ls -la storage/app/public/pelanggan/
```

#### 2. Cek permissions:
```bash
# Set permissions untuk storage
chmod -R 775 storage
chmod -R 755 storage/app/public
```

#### 3. Cek symlink:
```bash
# Hapus dan buat ulang
rm public/storage
php artisan storage:link
```

#### 4. Cek di browser (buka langsung URL gambar):
```
http://localhost:8000/storage/pelanggan/nama_file.jpg
```

Jika muncul error 404, berarti symlink belum benar.

#### 5. Cek konfigurasi filesystem di `.env`:
```env
FILESYSTEM_DISK=public
```

Pastikan menggunakan `public` bukan `local`.

#### 6. Clear cache:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📝 Catatan Penting

### Jangan commit symlink ke Git!
File `public/storage` adalah symlink dan tidak boleh di-commit ke Git.

Pastikan ada di `.gitignore`:
```
/public/storage
```

### Setiap developer harus jalankan sendiri:
```bash
php artisan storage:link
```

---

## 🔐 Permissions yang Benar

```bash
# Storage folder
chmod -R 775 storage

# Public storage (untuk file yang diupload)
chmod -R 755 storage/app/public

# Bootstrap cache
chmod -R 775 bootstrap/cache
```

---

## 🎯 Quick Fix

Jika foto tidak muncul, jalankan perintah ini:

```bash
# One-liner fix
rm -f public/storage && php artisan storage:link && chmod -R 755 storage/app/public
```

---

## ✅ Verifikasi Upload Berhasil

### 1. Upload foto pelanggan
Buka: http://localhost:8000/pelanggan/create

### 2. Cek file tersimpan:
```bash
ls -la storage/app/public/pelanggan/
```

### 3. Cek bisa diakses via symlink:
```bash
ls -la public/storage/pelanggan/
```

### 4. Cek di browser:
Buka: http://localhost:8000/pelanggan

Foto harus muncul di tabel.

### 5. Cek langsung URL gambar:
```
http://localhost:8000/storage/pelanggan/[nama_file]
```

---

## 🎉 Selesai!

Foto pelanggan sekarang sudah bisa muncul dengan benar.

Jika masih ada masalah, cek:
1. Storage symlink sudah benar
2. Permissions sudah tepat
3. File benar-benar ada di storage
4. Server sudah di-restart (jika perlu)
