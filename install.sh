#!/bin/bash

# Script instalasi otomatis untuk projek Laravel
# Untuk Linux (Ubuntu/Debian)

set -e  # Exit on error

echo "=========================================="
echo "  Setup Projek Laravel E-Commerce"
echo "=========================================="
echo ""

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fungsi untuk print dengan warna
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

# Deteksi distro Linux
if [ -f /etc/os-release ]; then
    . /etc/os-release
    DISTRO=$ID
else
    DISTRO="unknown"
fi

print_info "Distro terdeteksi: $DISTRO"
echo ""

# Cek apakah PHP sudah terinstall
echo "Mengecek PHP..."
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    print_success "PHP sudah terinstall: $PHP_VERSION"
    
    # Cek versi PHP minimal 8.2
    if php -r "exit(version_compare(PHP_VERSION, '8.2.0', '<') ? 1 : 0);"; then
        print_success "Versi PHP memenuhi syarat (>= 8.2)"
    else
        print_error "PHP versi minimal 8.2 diperlukan. Versi saat ini: $PHP_VERSION"
        echo "Silakan install PHP 8.2+ secara manual."
        exit 1
    fi
else
    print_error "PHP belum terinstall"
    echo ""
    print_info "Untuk menginstall PHP 8.2+, jalankan:"
    
    if [ "$DISTRO" = "ubuntu" ] || [ "$DISTRO" = "debian" ]; then
        echo "  sudo apt update"
        echo "  sudo apt install -y php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-mbstring php8.2-xml php8.2-zip php8.2-sqlite3 php8.2-gd php8.2-bcmath"
    elif [ "$DISTRO" = "fedora" ] || [ "$DISTRO" = "rhel" ] || [ "$DISTRO" = "centos" ]; then
        echo "  sudo dnf install -y php php-cli php-common php-curl php-mbstring php-xml php-zip php-sqlite3 php-gd php-bcmath"
    elif [ "$DISTRO" = "arch" ]; then
        echo "  sudo pacman -S php php-sqlite php-gd"
    else
        echo "  Lihat SETUP_GUIDE.md untuk instruksi lengkap"
    fi
    
    exit 1
fi

# Cek extensions PHP yang diperlukan
echo ""
echo "Mengecek PHP extensions..."
REQUIRED_EXTENSIONS=("curl" "mbstring" "xml" "zip" "sqlite3" "gd" "bcmath")
MISSING_EXTENSIONS=()

for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if php -m | grep -q "^$ext$"; then
        print_success "Extension $ext: OK"
    else
        print_error "Extension $ext: MISSING"
        MISSING_EXTENSIONS+=($ext)
    fi
done

if [ ${#MISSING_EXTENSIONS[@]} -ne 0 ]; then
    echo ""
    print_error "Beberapa PHP extensions belum terinstall: ${MISSING_EXTENSIONS[*]}"
    print_info "Install extensions yang hilang terlebih dahulu"
    exit 1
fi

# Cek Composer
echo ""
echo "Mengecek Composer..."
if command -v composer &> /dev/null; then
    COMPOSER_VERSION=$(composer --version --no-ansi | head -n1)
    print_success "Composer sudah terinstall: $COMPOSER_VERSION"
else
    print_error "Composer belum terinstall"
    echo ""
    print_info "Menginstall Composer..."
    
    # Download dan install Composer
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    
    if [ $? -eq 0 ]; then
        sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
        php -r "unlink('composer-setup.php');"
        
        if command -v composer &> /dev/null; then
            print_success "Composer berhasil diinstall"
        else
            print_error "Gagal menginstall Composer"
            exit 1
        fi
    else
        print_error "Gagal mendownload Composer installer"
        exit 1
    fi
fi

# Cek Node.js
echo ""
echo "Mengecek Node.js..."
if command -v node &> /dev/null; then
    NODE_VERSION=$(node --version)
    print_success "Node.js sudah terinstall: $NODE_VERSION"
else
    print_error "Node.js belum terinstall"
    print_info "Silakan install Node.js dari https://nodejs.org/"
    exit 1
fi

# Setup projek
echo ""
echo "=========================================="
echo "  Memulai Setup Projek"
echo "=========================================="
echo ""

# Install dependencies PHP
print_info "Installing PHP dependencies..."
composer install --no-interaction
print_success "PHP dependencies installed"

# Setup .env file
echo ""
if [ ! -f .env ]; then
    print_info "Membuat file .env..."
    cp .env.example .env
    print_success "File .env dibuat"
else
    print_info "File .env sudah ada"
fi

# Generate application key
echo ""
print_info "Generating application key..."
php artisan key:generate --no-interaction
print_success "Application key generated"

# Buat database SQLite
echo ""
if [ ! -f database/database.sqlite ]; then
    print_info "Membuat database SQLite..."
    touch database/database.sqlite
    print_success "Database SQLite dibuat"
else
    print_info "Database SQLite sudah ada"
fi

# Set permissions
echo ""
print_info "Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
print_success "Permissions set"

# Jalankan migrasi
echo ""
print_info "Menjalankan database migrations..."
php artisan migrate --force --no-interaction
print_success "Migrations completed"

# Jalankan seeder
echo ""
print_info "Menjalankan database seeders..."
php artisan db:seed --force --no-interaction
print_success "Seeders completed"

# Install Node.js dependencies
echo ""
print_info "Installing Node.js dependencies..."
npm install
print_success "Node.js dependencies installed"

# Build assets
echo ""
print_info "Building assets..."
npm run build
print_success "Assets built"

# Selesai
echo ""
echo "=========================================="
print_success "Setup Selesai!"
echo "=========================================="
echo ""
echo "Untuk menjalankan aplikasi:"
echo "  1. Jalankan server: php artisan serve"
echo "  2. Buka browser: http://localhost:8000"
echo ""
echo "Atau jalankan semua service sekaligus:"
echo "  composer dev"
echo ""
print_info "Lihat SETUP_GUIDE.md untuk informasi lebih lanjut"
