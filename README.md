# 🎓 Laravel Mentoring Web Application

[![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.2-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem Informasi Mentoring Akademik Mahasiswa berbasis web yang dibangun dengan framework **Laravel 11**, **Tailwind CSS**, dan **Vite**. Aplikasi ini mengintegrasikan seluruh proses kegiatan mentoring dalam satu platform terpadu untuk Petugas, Pembimbing, Mentor, dan Mentee.

---

## 🌟 Fitur Utama

- 👥 **Multi-Role Authentication & Access Control**
  - **Petugas (Admin)**: Mengelola data mentor, pembimbing, kelas mentoring, pengumuman, serta mengunduh rekapitulasi presensi & data mahasiswa (PDF).
  - **Pembimbing**: Memantau progress kelas yang dibimbing, mengecek laporan logbook mentor, dan mengunduh rekap presensi.
  - **Mentor**: Membuat modul materi, membuat penugasan, membuka sesi presensi keikutsertaan, mengunggah logbook kegiatan harian (dengan bukti foto), dan mengecek pengumpulan tugas mentee.
  - **Mentee**: Mendaftar (enroll) kelas mentoring, mengakses materi/modul, mengisi presensi tepat waktu, mengunggah tugas sebelum deadline, dan memantau status kelulusan.

- 📚 **Manajemen Modul & Tugas**
  - Pengunggahan file modul materi (PDF, DOC, ZIP) secara aman.
  - Tracking deadline tugas dengan kalkulasi otomatis keterlambatan/pengerjaan lebih awal.
  - Pengunduhan aman tugas dan lampiran modul.

- ⏱️ **Presensi Sesi Mentoring**
  - Presensi berbasis waktu buka dan deadline otomatis.
  - Status otomatis menjadi `tidak hadir` jika melewati batas waktu.
  - Proteksi duplikasi dan otorisasi presensi berbasis pengguna terautentikasi.

- 📋 **Logbook & Pelaporan Mentor**
  - Pengisian logbook kegiatan harian oleh mentor disertai kompresi/dekode foto kegiatan.
  - Verifikasi dan persetujuan (Approved/Rejected) oleh Petugas/Pembimbing.

- 📄 **Ekspor Rekapitulasi PDF**
  - Cetak rekapitulasi kehadiran pertemuan per kelas mentoring menggunakan **DomPDF**.
  - Cetak data daftar mahasiswa per kelas.

---

## 💻 Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan komputer Anda telah terinstall:

- **PHP**: `>= 8.2` (dengan ekstensi `pdo`, `mbstring`, `openssl`, `gd`)
- **Composer**: `>= 2.0`
- **Node.js**: `>= 18.x` & **npm**
- **Database**: MySQL `>= 8.0` / MariaDB / SQLite

---

## 🚀 Panduan Instalasi & Pengoperasian

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal:

### 1. Clone & Masuk ke Direktori Proyek
```bash
cd mentoring-web
```

### 2. Install Dependensi PHP & Node.js
```bash
# Install package Composer
composer install

# Install package NPM
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi koneksi database Anda (misal MySQL):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mentoring_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi & Seeder Database
Jalankan migrasi tabel beserta data awal (users & kelas contoh):
```bash
php artisan migrate --seed
```

### 6. Buat Symbolic Link Storage *(Sangat Penting)*
Agar file pengumuman, modul, dan foto logbook dapat diakses & diunduh dengan aman:
```bash
php artisan storage:link
```

### 7. Jalankan Server Lokal & Assets Bundler
Jalankan dev server Laravel dan Vite (anda dapat menggunakan 2 terminal terpisah atau perintah dev):

**Terminal 1 (Laravel Server):**
```bash
php artisan serve
```

**Terminal 2 (Vite Assets):**
```bash
npm run dev
```

Aplikasi sekarang dapat diakses di browser melalui: **`http://localhost:8000`**

---

## 🔑 Akun Demo (Bawaan Database Seeder)

Anda dapat langsung mencoba login menggunakan kredensial bawaan berikut:

| Role | NIM / Identifier | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Mentee** | `2103040600` | `password123` | Student portal, enroll course, upload tugas & presensi |
| **Mentor** | `2003040001` | `123password` | Mentor portal, buat modul, tugas, presensi & logbook |
| **Petugas (Admin)** | `1234567890` | `password123` | Admin dashboard, kelola mentor, pembimbing, & cetak PDF |

---

## 📁 Struktur Direktori Utama

```text
mentoring-web/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Controller untuk fitur Petugas & Pembimbing
│   │   │   ├── Mentee/        # Controller untuk fitur Mahasiswa (Mentee)
│   │   │   ├── Mentor/        # Controller untuk fitur Kakak Mentor
│   │   │   └── AuthController.php
│   │   └── Middleware/
│   └── Models/                # Model Eloquent (User, Course, Module, Task, dll)
├── database/
│   ├── migrations/            # Skema tabel database
│   └── seeders/               # Sample data awal
├── public/                    # Web root & asset terpublikasi
├── resources/
│   ├── views/                 # Blade Templates (admin, mentor, mentee)
│   └── css & js/              # Tailwind CSS & JS source
├── routes/
│   └── web.php                # Definisi route aplikasi
└── storage/                   # Tempat penyimpanan file unggahan modul & tugas
```

---

## 🛡️ Keamanan & Best Practices Terimplementasi

- **Otorisasi & Autentikasi Middleware**: Semua route krusial dilindungi oleh middleware `auth` dan pengecekan hak akses role.
- **Sanitasi Path Traversal**: Pengunduhan dokumen menggunakan `basename()` untuk mengisolasi akses file dari manipulasi direktori.
- **Nama File Unik**: Seluruh berkas yang diunggah otomatis diberikan identitas timestamp & sanitasi nama untuk mencegah insiden overwrite.
- **Proteksi IDOR**: Presensi dan pembaruan tugas diverifikasi langsung terhadap ID pengguna sesi aktif (`Auth::id()`).

---

## 📄 Lisensi

Proyek ini dikembangkan di bawah lisensi **RWMCode / MIT License**.
