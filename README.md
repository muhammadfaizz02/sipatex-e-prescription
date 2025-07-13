# E-Prescription - Developer Assignment (Sipatex)

Aplikasi resep obat digital sederhana berbasis Laravel 10. Project ini dibuat sebagai bagian dari Take-Home Test untuk posisi **Developer Web** di PT Sipatex Putri Lestari.

Aplikasi ini memungkinkan user melakukan pencatatan resep obat secara digital, baik dalam bentuk **non-racikan** maupun **racikan**. Fitur mencakup validasi stok, draft resep, pengurangan stok otomatis, dan cetak resep PDF.

---

## 🚀 Cara Instalasi (Local Setup)

1. **Clone Repository:**

```bash
git clone https://github.com/muhammadfaizz02/sipatex-e-prescription.git
cd sipatex-e-prescription

2. Install Dependensi Backend & Frontend

composer install
npm install
npm run dev

3. Salin File .env

cp .env.example .env

4. Setup Koneksi Database (.env)

DB_CONNECTION=mysql
DB_DATABASE=db_resep
DB_USERNAME=root
DB_PASSWORD=

5. Migrasi Data

php artisan migrate

6. Jalankan Aplikasi

php artisan serve

7. Akses Aplikasi

http://localhost:8000/resep

✨ Fitur Utama
Tambah resep non-racikan (obat tunggal) dan racikan (gabungan beberapa obat)

Validasi stok: tidak bisa melebihi stok yang tersedia

Draft resep ditampilkan sebelum disimpan

Simpan resep → stok otomatis berkurang

Cetak resep sebagai PDF

Dropdown pencarian obat & signa (TomSelect)

Responsive UI (Tailwind CSS + Alpine.js)

