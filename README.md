# SuRasa - Platform Jelajah Kuliner & Resep Nusantara

SuRasa adalah aplikasi berbasis web yang dirancang untuk membantu pengguna menemukan cita rasa terbaik di sekitar mereka, menjelajahi kuliner lokal, serta berbagi resep masakan dengan komunitas.

## Fitur Utama

- **Jelajah Kuliner**: Filter lokasi dan kategori untuk menemukan tempat makan terbaik.
- **Berbagi Resep**: Tulis dan publikasikan resep Anda sendiri lengkap dengan info nutrisi.
- **Mode Memasak**: Panduan langkah-demi-langkah interaktif dengan fitur *screen wake lock*.
- **Interaksi Komunitas**: Berikan rating, ulasan, dan sukai kuliner atau resep favorit.
- **Panel Admin**: Manajemen kategori, kuliner, resep, dan ulasan secara terintegrasi.

## Teknologi yang Digunakan

- **Framework**: [Laravel 11](https://laravel.com)
- **Frontend**: [Tailwind CSS](https://tailwindcss.com) & [Alpine.js](https://alpinejs.dev)
- **Bundler**: [Vite](https://vitejs.dev)
- **Database**: MySQL / MariaDB

---

## Panduan Setup Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### 1. Prasyarat
Pastikan Anda sudah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB

### 2. Clone Repositori
```bash
git clone https://github.com/username/surasa2.git
cd surasa2
```

### 3. Instal Dependensi
Instal dependensi PHP melalui Composer:
```bash
composer install
```

Instal dependensi JavaScript melalui NPM:
```bash
npm install
```

### 4. Konfigurasi Lingkungan
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_mysql
DB_PASSWORD=password_mysql
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Migrasi & Seed Database
Jalankan migrasi untuk membuat tabel dan seeder untuk data awal (kategori, kuliner, resep, dan akun admin):
```bash
php artisan migrate --seed
```

### 7. Hubungkan Storage
Penting agar gambar yang diupload muncul di browser:
```bash
php artisan storage:link
```

### 8. Build Aset Frontend
Untuk pengembangan (development):
```bash
npm run dev
```
Atau untuk produksi (production):
```bash
npm run build
```

### 9. Jalankan Server
```bash
php artisan serve
```
Aplikasi sekarang dapat diakses di `http://127.0.0.1:8000`.

---

## Akun Demo (Default Seeder)

Anda bisa login menggunakan akun berikut:
- **URL Login**: `/login`
- **Admin**: `admin@surasa.id` | Password: `password`
- **User**: `user@surasa.id` | Password: `password`

## Lisensi
Proyek ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).