# Manajemen Buku (Laravel + Breeze + Spatie Permission)

Aplikasi manajemen buku dengan autentikasi (Laravel Breeze) dan otorisasi berbasis
role dan permission (Spatie Laravel Permission). Tugas Mandiri: Laravel Breeze & Spatie Permission.

**Nama:** Ahmad Faizal Bahri | **NIM:** 2495114009 | **Kelas:** Teknik Informatika 5A

## Teknologi

- Laravel 13
- Laravel Breeze (stack Blade, dark mode, Pest)
- spatie/laravel-permission
- MySQL dan Tailwind CSS (bawaan Breeze)

## Fitur

- Register, login, logout, dan dashboard (Laravel Breeze)
- CRUD buku: judul, penulis, penerbit, tahun terbit
- Tiga role: Admin, Dosen, Mahasiswa
- Kelola role pengguna (khusus Admin)
- Tombol di tampilan disembunyikan sesuai hak akses, dan pemeriksaan hak akses dilakukan di sisi server

## Cara Instalasi

1. Clone repositori
   ```bash
   git clone https://github.com/faisallzz/book_management.git
   cd book_management
   ```
2. Pasang dependensi
   ```bash
   composer install
   npm install
   ```
3. Siapkan environment
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Buat database kosong bernama `book_management`, lalu sesuaikan nilai `DB_*` di file `.env`
   (host, port, username, password).
4. Migrasi dan isi data awal (role, permission, akun uji, contoh buku)
   ```bash
   php artisan migrate --seed
   ```
5. Jalankan aplikasi (gunakan dua terminal)
   ```bash
   npm run dev
   php artisan serve
   ```
   Buka http://127.0.0.1:8000

Catatan: untuk produksi atau tanpa `npm run dev`, jalankan `npm run build` satu kali.

## Akun Uji

| Role | Email | Password |
|---|---|---|
| Admin | admin@test.com | password |
| Dosen | dosen@test.com | password |
| Mahasiswa | mahasiswa@test.com | password |

Pengguna yang mendaftar sendiri otomatis mendapat role **Mahasiswa**.

## Matriks Hak Akses

| Fitur | Admin | Dosen | Mahasiswa |
|---|:---:|:---:|:---:|
| Login / logout | Ya | Ya | Ya |
| Lihat daftar buku | Ya | Ya | Ya |
| Tambah buku | Ya | Ya | Tidak |
| Edit buku | Ya | Ya | Tidak |
| Hapus buku | Ya | Tidak | Tidak |
| Kelola role pengguna | Ya | Tidak | Tidak |

Permission yang dipakai: `lihat buku`, `tambah buku`, `edit buku`, `hapus buku`, `kelola role`.

## Cara Kerja Proteksi

- Route dilindungi middleware `auth`: pengguna yang belum login diarahkan ke `/login`.
- Setiap route buku dan kelola role dilindungi middleware `permission:<nama permission>`:
  pengguna yang tidak memiliki izin menerima **HTTP 403 Forbidden**.
- Tombol di tampilan disembunyikan dengan `@can`, tetapi itu hanya untuk kenyamanan tampilan.
  Pengamanan sebenarnya ada di route (sisi server), sehingga akses lewat URL langsung atau
  request manual tetap ditolak.

## Hasil Pengujian

| # | Skenario | Hasil yang diharapkan | Status |
|---|---|---|---|
| 1 | Membuka `/books` dan `/dashboard` tanpa login | Diarahkan ke `/login` | Sesuai |
| 2 | Login dengan password salah | Gagal, muncul pesan error | Sesuai |
| 3 | Login dengan kredensial valid | Masuk ke dashboard | Sesuai |
| 4 | Admin menghapus buku | Berhasil | Sesuai |
| 5 | Dosen menambah dan mengedit buku | Berhasil | Sesuai |
| 6 | Mahasiswa membuka `/books/create` dan `/books/{id}/edit` lewat URL | 403 | Sesuai |
| 7 | Mahasiswa melihat daftar buku | Tampil tanpa tombol aksi | Sesuai |
| 8 | Logout lalu membuka `/books` | Diarahkan ke login | Sesuai |
| 9 | Dosen dan Mahasiswa mengirim request DELETE manual | 403, data tetap ada | Sesuai |

## Struktur Penting

- `routes/web.php`: route dan middleware permission
- `bootstrap/app.php`: alias middleware Spatie
- `app/Http/Controllers/BookController.php`: CRUD buku
- `app/Http/Controllers/UserRoleController.php`: kelola role
- `app/Models/Book.php`, `app/Models/User.php` (trait `HasRoles`)
- `database/seeders/RolePermissionSeeder.php`: role, permission, dan akun uji
- `database/seeders/BookSeeder.php`: contoh data buku
- `resources/views/books/` dan `resources/views/users/`: tampilan