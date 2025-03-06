# Work Order Management System

## Persyaratan Sistem
Pastikan server atau komputer kamu memiliki:
- PHP 7.3 atau lebih baru
- Composer
- MySQL atau database lain yang kompatibel
- Laravel 8.1

## Setup Aplikasi

### 1. Clone Repository
```bash
git clone https://github.com/username/repository-name.git
cd repository-name
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi **.env**
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Edit file `.env` sesuai dengan konfigurasi database:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pipx_management
DB_USERNAME=username_mysql
DB_PASSWORD=password_mysql
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### Jalankan Migration & Seeder
```bash
php artisan migrate --seed
```

### Jalankan Server Laravel
```bash
php artisan serve
```
Akses aplikasi di browser: `http://127.0.0.1:8000`

---

## Akun Default
Jika seeder dijalankan, berikut akun default yang bisa digunakan untuk login:
bisa login by email atau username atau NPK

- **Admin**
  - Email: `admin@gmail.com`
  - U-name: `admin`
  - Password: `secret`

- **Manager**
  - Email: `manager@gmail.com`
  - U-name: `manager`
  - Password: `secret`

- **Operator**
  - Email: `operator@gmail.com`
  - U-name: `operator`
  - Password: `secret`

Selamat menggunakan aplikasi Work Order Management System! 🚀

