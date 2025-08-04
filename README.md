
## 🚀 Tentang Proyek Ini

Selamat datang di homebase TSU Project System! Repositori ini adalah pusat pengembangan untuk sistem manajemen pengguna internal kita. Tujuan utama dari proyek ini adalah untuk menyediakan platform yang solid dan mudah dikelola untuk semua hal yang berkaitan dengan pengguna di dalam sistem TSU.

Proyek ini dibangun untuk memudahkan kolaborasi tim dan memastikan semua anggota tim punya akses ke codebase yang terpusat dan terorganisir.

---
## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan Laravel 12 sebagai framework utamanya. Untuk mempercepat pengembangan dan memastikan fungsionalitas yang modern, kami mengandalkan beberapa package hebat berikut:

- Laravel Jetstream dengan Livewire: Digunakan sebagai sistem otentikasi dan manajemen tim. Fitur seperti registrasi, login, manajemen profil, dan fungsionalitas tim sudah tersedia secara out-of-the-box.
- Spatie/laravel-permission: Package ini dipakai untuk mengelola roles dan permissions secara dinamis. Ini memungkinkan kita untuk mengatur hak akses pengguna dengan sangat fleksibel.
- Filament: Digunakan untuk membangun panel admin yang cantik dan fungsional dengan cepat. Filament membantu kita membuat antarmuka admin untuk mengelola data tanpa perlu menulis banyak boilerplate code.

---
## 🏁 Memulai Proyek

Untuk menjalankan proyek ini di lingkungan lokal, ikuti langkah-langkah berikut:

1. Clone repository ini:

Pilih salah satu metode di bawah ini sesuai dengan preferensi dan konfigurasimu.

<details>
<summary><strong>Pilih metode clone (klik untuk membuka)</strong></summary>

- Opsi 1: HTTPS

  Gunakan metode ini jika ingin menggunakan username dan password (atau Personal Access Token) untuk otentikasi.

  ```Bash
  git clone https://github.com/AncaSea/tsu-homebase.git
  ```

- Opsi 2: SSH

  Gunakan metode ini jika sudah mengatur SSH key di akun Git-mu.

  ```Bash
  git clone git@github.com:your_username/tsu-homebase.git
  ```

- Opsi 3: Personal Access Token (PAT)

  Jika menggunakan Two-Factor Authentication (2FA) atau organisasi mewajibkan PAT.

  ```Bash
  git clone https://your_PAT@github.com/username/AncaSea/tsu-homebase.git
  ```

</details>

2. Masuk ke direktori proyek:

```Bash
cd tsu-project-system
```

3. Install dependencies Composer dan npm:

```Bash
composer install
npm install
```

4. Jalankan npm run build&dev:

```bash
npm run build
npm run dev
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

   >Disarankan menggunakan **postgresql**

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
Proyek ini dikelola dan dikembangkan oleh tim IT TSU. Jika ada pertanyaan atau butuh diskusi lebih lanjut, jangan ragu untuk menghubungi anggota tim lainnya!
