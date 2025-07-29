# TSU Project System

## 🚀 Tentang Proyek Ini

Selamat datang di homebase TSU Project System! Repositori ini adalah pusat pengembangan untuk sistem manajemen pengguna internal kita. Tujuan utama dari proyek ini adalah untuk menyediakan platform yang solid dan mudah dikelola untuk semua hal yang berkaitan dengan pengguna di dalam sistem TSU.

Proyek ini dibangun untuk memudahkan kolaborasi tim dan memastikan semua anggota tim punya akses ke codebase yang terpusat dan terorganisir.

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan Laravel 12 sebagai framework utamanya. Untuk mempercepat pengembangan dan memastikan fungsionalitas yang modern, kami mengandalkan beberapa package hebat berikut:

Laravel Jetstream dengan Livewire: Digunakan sebagai sistem otentikasi dan manajemen tim. Fitur seperti registrasi, login, manajemen profil, dan fungsionalitas tim sudah tersedia secara out-of-the-box.

Spatie/laravel-permission: Package ini dipakai untuk mengelola roles dan permissions secara dinamis. Ini memungkinkan kita untuk mengatur hak akses pengguna dengan sangat fleksibel.

Filament: Digunakan untuk membangun panel admin yang cantik dan fungsional dengan cepat. Filament membantu kita membuat antarmuka admin untuk mengelola data tanpa perlu menulis banyak boilerplate code.

## 🏁 Memulai Proyek
Untuk menjalankan proyek ini di lingkungan lokal, ikuti langkah-langkah berikut:

1. Clone repository ini:


```bash
git clone [URL_REPOSITORY_ANDA]
```

2. Masuk ke direktori proyek:

```Bash
cd tsu-project-system
```

3. Install dependencies Composer:

```Bash
composer install
```

4. Salin file .env.example menjadi .env:

```Bash
cp .env.example .env
```

5. Generate application key:

```Bash
php artisan key:generate
```

6. Konfigurasi database di file .env

7. Jalankan migrasi database:

```Bash
php artisan migrate
```

8. Jalankan server pengembangan:

```Bash
php artisan serve
```

Sekarang, proyek sudah bisa diakses di http://localhost:8000.

## 🤝 Tim Kami
Proyek ini dikelola dan dikembangkan oleh tim internal TSU. Jika ada pertanyaan atau butuh diskusi lebih lanjut, jangan ragu untuk menghubungi anggota tim lainnya!
