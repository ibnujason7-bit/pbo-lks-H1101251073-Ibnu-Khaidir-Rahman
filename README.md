# PBO LKS — Portofolio Praktikum

- Nama : Ibnu Khaidir Rahman
- NIM  : H1101251073
- Kelas: A
- Mata Kuliah: Pemrograman Berbasis Objek (PBO)
- Dosen: Syahru Rahmayuda, M.Kom

## Fitur
- REST API CRUD Buku dan Kategori (PHP modern, PSR-4, Composer)
- Arsitektur MVC, Repository Pattern, Dependency Injection, Front Controller
- Konfigurasi database lewat file .env, data tersimpan di MySQL
- Frontend terpisah dengan Tailwind CSS (Dashboard, Buku, Kategori)
- Pengujian API dengan cURL dan Postman

## Cara Menjalankan
1. Salin `.env.example` menjadi `.env`, sesuaikan DB_USERNAME / DB_PASSWORD
2. Import database: jalankan `schema.sql` di MySQL
3. Generate autoload: `composer dump-autoload -o`
4. Backend: `php -S localhost:8000 -t public` (di folder rest-api-perpustakaan)
5. Frontend: `php -S localhost:3000` (di folder frontend-perpustakaan)
6. Buka http://localhost:3000

## Screenshot Final
![Dashboard](screenshot-final/dashboard.png)
![Buku](screenshot-final/halaman-buku.png)
![Kategori](screenshot-final/halaman-kategori.png)

## Daftar Pertemuan
- [x] [Pertemuan 1 — Setup & Database](pertemuan-01/)
- [x] [Pertemuan 2 — Core OOP](pertemuan-02/)
- [x] [Pertemuan 3 — Framework & Routing](pertemuan-03/)
- [x] [Pertemuan 4 — Testing Backend](pertemuan-04/)
- [x] [Pertemuan 5 — CRUD Kategori](pertemuan-05/)
- [x] [Pertemuan 6 — Frontend](pertemuan-06/)
- [x] [Pertemuan 7 — Integrasi & Finalisasi](pertemuan-07/)