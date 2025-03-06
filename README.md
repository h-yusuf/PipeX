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


# 📄 PipeX Management Documentation

**PipeX Management** adalah sistem manajemen Work Order (WO) yang digunakan untuk mempermudah pengelolaan proses produksi, mulai dari pengaturan pengguna, operator, produk, hingga monitoring dan laporan Work Order.

---

## 🚀 Fitur-Fitur Utama

### 👤 User Management  
Mengelola data user yang memiliki akses ke sistem dengan berbagai peran dan tanggung jawab.

![User Management](public/readme/users_management.png)

---

### 👥 Operator Management  
Mengelola data operator yang bertanggung jawab menjalankan Work Order.

![Operator Management](public/readme/operator.png)

---

### 🔐 Role & Permission Management  
Mengelola hak akses dan izin pengguna dalam sistem sesuai kebutuhan operasional.

- **Role Management**  
  ![Role Management](public/readme/role_management.png)

- **Tambah Role**  
  ![Tambah Role](public/readme/role_add.png)

- **Permission Management**  
  ![Permission Management](public/readme/permission_management.png)

---

### 📦 Product Management  
Mengelola data produk yang terlibat dalam proses produksi Work Order.

- **Daftar Produk**  
  ![Product Management](public/readme/product_management.png)

- **Tambah Produk**  
  ![Tambah Produk](public/readme/product_management_add.png)

- **Update Produk**  
  ![Update Produk](public/readme/product_management_update.png)

---

### 📝 Work Order (WO) Management  
Mengelola proses Work Order mulai dari input, update, monitoring hingga laporan.

- **Daftar Work Order**  
  ![Work Order Management](public/readme/wo_management.png)

- **Tambah Work Order**  
  ![Tambah Work Order](public/readme/wo_management_add.png)

- **Update Work Order**  
  ![Update Work Order](public/readme/wo_management_update.png)

- **Hapus Work Order**  
  ![Hapus Work Order](public/readme/wo_management_delete.png)

- **Progress Work Order**  
  ![Progress Work Order](public/readme/wo_management_progress.png)

- **Laporan Work Order**  
  ![Laporan Work Order](public/readme/wo_management_report.png)

---

### 🎥 Demo Penggunaan  
Cuplikan penggunaan PipeX Management dalam format video.

![Operator Demo](public/readme/operator.webm)

---

## 📌 Catatan
- Semua fitur dikelola via platform berbasis web.
- Pastikan user memiliki role dan permission yang sesuai untuk mengakses setiap modul.
- Dokumentasi ini dapat diperbarui seiring dengan pengembangan fitur selanjutnya.

---
