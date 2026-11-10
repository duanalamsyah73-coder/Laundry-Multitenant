# LaundryMap — Penyesuaian Pertemuan 2

Project ini menambahkan fondasi yang disesuaikan dari modul Pertemuan 2: struktur modular monolith, route terpisah untuk pelanggan/mitra/admin, middleware role, autentikasi dasar, dan layout responsif.

## Fitur yang ditambahkan
- Halaman beranda dan halaman layanan LaundryMap.
- Daftar akun pelanggan, login, logout, dan validasi form.
- Kolom `role` pada pengguna (`customer`, `tenant`, `admin`).
- Route dashboard mitra dan admin yang dilindungi middleware autentikasi serta role.
- Struktur modul `Laundry`, `Account`, dan `Dashboard`, plus `ModuleServiceProvider`.
- Layout terpisah untuk pelanggan, mitra, dan admin.

## Menjalankan di Windows / VS Code
1. Buka folder `laundrymap` di VS Code.
2. Pastikan PHP dan Composer tersedia.
3. Jalankan `composer install` jika folder `vendor` tidak tersedia.
4. Salin `.env.example` menjadi `.env`, lalu atur database di `.env`.
5. Jalankan `php artisan key:generate`.
6. Jalankan `php artisan migrate`.
7. Jalankan `php artisan serve`.
8. Buka `http://127.0.0.1:8000`.

## Catatan penting
- Pendaftaran publik hanya membuat role `customer`. Jangan menambahkan pilihan role admin/mitra pada form pendaftaran publik.
- Untuk menguji dashboard mitra/admin, buat akun dengan role yang sesuai melalui database lokal atau seeder yang hanya digunakan untuk development.
- Daftar layanan saat ini masih contoh tampilan, belum berasal dari tabel laundry dan belum memiliki peta interaktif. Struktur ini menjadi fondasi untuk menambahkan database laundry, koordinat lokasi, pencarian, dan peta pada tahap selanjutnya.
- Layout menggunakan Tailwind CDN agar tampilan dasar bisa terlihat tanpa build aset; koneksi internet diperlukan untuk memuat CDN.
