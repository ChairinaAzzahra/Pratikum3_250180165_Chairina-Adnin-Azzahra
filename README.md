# SweeTToothie Atelier (Product Manager)

Aplikasi Web Manajemen Produk Toko Kue MAcaroon sederhana yang dibangun menggunakan PHP Native, PDO MySQL, dan CSS Flexbox.

## Fitur Utama
- *Create*: Menambah varian macaroon baru dengan validasi server side.
- *Read*: Menampilkan daftar macaroon dalam bentuk kartu (card grid) yang responsif.
- *Update*: Mengubah nama, kategori, harga, dan stok macaroon.
- *Delete*: Menghapus data secara aman menggunakan method POST & Token CSRF.
- *Search*: Mencari varian macaroon berdasarkan nama atau kategori

## Fitur Keamanan
- Prepared Statement (PDO) untuk cegah SQL Injection.
- Escaping output ('htmlspecialchars') untuk cegah XSS.
- Validasi Server Side (Panjang nama, angka positif).
- Proteksi CSRF pada operasi hapus data.
- Pola POST Redirect-Get (PRG) untuk cegah duplikasi submit form.

## Cara Menjalankan di Lokal (XAMPP / Laragon)
1. Clone repositori ini ke folder 'htdocs'(XAMPP) atau 'www'(Laragon).
2. Pastikan service MySQL & Apache di XAMPP/Laragon sudah aktif.
3. Buka browser dan akses 'http://localhost/TugasPratikum3_250180165_Chairina-Adnin-Azzahra-main/public/index.php' (Database & tabel akan dibuat otomatis saat halaman pertama kali diakses).
4. *(Opsional jika ada error database macaroon tidak diketahui)* File SQL pendukung juga tersedia di 'database/macaroon_db.sql' jika ingin diimpor manual di phpMyAdmin 'http://localhost/phpmyadmin' 
