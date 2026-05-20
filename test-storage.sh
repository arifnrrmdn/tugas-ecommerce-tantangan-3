#!/bin/bash

# Script untuk test storage dan upload foto

echo "=========================================="
echo "  Test Storage & Upload Foto"
echo "=========================================="
echo ""

# Warna
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

# 1. Cek symlink
echo "1. Mengecek storage symlink..."
if [ -L "public/storage" ]; then
    LINK_TARGET=$(readlink -f public/storage)
    EXPECTED_TARGET=$(readlink -f storage/app/public)
    
    if [ "$LINK_TARGET" = "$EXPECTED_TARGET" ]; then
        print_success "Symlink benar: public/storage -> storage/app/public"
    else
        print_error "Symlink salah!"
        echo "   Target saat ini: $LINK_TARGET"
        echo "   Seharusnya: $EXPECTED_TARGET"
        echo ""
        print_info "Memperbaiki symlink..."
        rm public/storage
        php artisan storage:link
        print_success "Symlink diperbaiki"
    fi
else
    print_error "Symlink tidak ada!"
    print_info "Membuat symlink..."
    php artisan storage:link
    print_success "Symlink dibuat"
fi

echo ""

# 2. Cek folder pelanggan
echo "2. Mengecek folder pelanggan..."
if [ -d "storage/app/public/pelanggan" ]; then
    print_success "Folder pelanggan ada"
    
    # Hitung jumlah file
    FILE_COUNT=$(ls -1 storage/app/public/pelanggan 2>/dev/null | wc -l)
    print_info "Jumlah file: $FILE_COUNT"
    
    if [ $FILE_COUNT -gt 0 ]; then
        echo "   File yang ada:"
        ls -lh storage/app/public/pelanggan | tail -n +2 | awk '{print "   - " $9 " (" $5 ")"}'
    fi
else
    print_info "Folder pelanggan belum ada (akan dibuat otomatis saat upload)"
fi

echo ""

# 3. Cek permissions
echo "3. Mengecek permissions..."
STORAGE_PERM=$(stat -c "%a" storage/app/public 2>/dev/null)
if [ "$STORAGE_PERM" = "755" ] || [ "$STORAGE_PERM" = "775" ]; then
    print_success "Permissions storage: $STORAGE_PERM (OK)"
else
    print_info "Permissions storage: $STORAGE_PERM"
    print_info "Memperbaiki permissions..."
    chmod -R 755 storage/app/public
    print_success "Permissions diperbaiki"
fi

echo ""

# 4. Cek konfigurasi .env
echo "4. Mengecek konfigurasi .env..."
if grep -q "FILESYSTEM_DISK=public" .env; then
    print_success "FILESYSTEM_DISK=public (OK)"
else
    DISK=$(grep "FILESYSTEM_DISK=" .env | cut -d'=' -f2)
    if [ -z "$DISK" ]; then
        print_info "FILESYSTEM_DISK tidak diset (default: local)"
    else
        print_info "FILESYSTEM_DISK=$DISK"
    fi
fi

echo ""

# 5. Test akses file
echo "5. Test akses file..."
if [ -d "storage/app/public/pelanggan" ] && [ "$(ls -A storage/app/public/pelanggan 2>/dev/null)" ]; then
    FIRST_FILE=$(ls storage/app/public/pelanggan | head -1)
    
    if [ -f "public/storage/pelanggan/$FIRST_FILE" ]; then
        print_success "File bisa diakses via symlink"
        print_info "Test file: $FIRST_FILE"
        print_info "URL: http://localhost:8000/storage/pelanggan/$FIRST_FILE"
    else
        print_error "File tidak bisa diakses via symlink"
    fi
else
    print_info "Belum ada file untuk ditest"
fi

echo ""

# 6. Cek data pelanggan dengan foto
echo "6. Mengecek data pelanggan dengan foto..."
PELANGGAN_COUNT=$(php artisan tinker --execute="echo \App\Models\Pelanggan::whereNotNull('foto')->count();" 2>/dev/null)
if [ "$PELANGGAN_COUNT" -gt 0 ]; then
    print_success "Ada $PELANGGAN_COUNT pelanggan dengan foto"
else
    print_info "Belum ada pelanggan dengan foto"
fi

echo ""
echo "=========================================="
echo "  Test Selesai"
echo "=========================================="
echo ""
echo "Untuk test upload:"
echo "1. Jalankan server: php artisan serve"
echo "2. Buka: http://localhost:8000/pelanggan/create"
echo "3. Upload foto pelanggan"
echo "4. Cek apakah foto muncul di list"
echo ""
