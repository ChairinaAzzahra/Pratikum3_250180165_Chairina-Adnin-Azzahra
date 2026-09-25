# SweeTToothie Atelier (Product Manager)
Aplikasi Web Manajemen Produk Toko Kue MAcaroon sederhana yang dibangun menggunakan PHP Native, PDO MySQL, dan CSS Flexbox.

## Fitur Utama


## Fitur Keamanan
- Prepared Statement (PDO) untuk cegah SQL Injection.
- Esaping output ('htmlspecialchars') untuk cegah XSS.
- Validasi Server Side (Panjang nama, angka positif).
- Proteksi CSRF pada operasi hapus data.
- Pola POST REdirect-Get (PRG) untuk cegah duplikasi submit form.

## Cara Menjalankan di Lokal (XAMPP / Laragon)
1. Clone repositori ini ke folder htdocs' atau 'ww'.
2. Impor file database 'database/macaroon_db.sql' di phpMyAdmin.
3. Sesuaikan konfigurasi database di 'config/db.php' jika diperlukan.
4. Buka brower dan akses 
