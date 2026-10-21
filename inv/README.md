# Inventory Laravel — Kerangka Mini Project 4 (BELUM disesuaikan dengan P4)

> PENTING: kode ini dibuat dari desain contoh di PPT Web 5 (kategori, produk, supplier, stok),
> BUKAN dari source code P4 Anda (belum diberikan). Nama tabel/kolom/fitur P4 harus dicocokkan
> setelah source P4 tersedia. Autentikasi dan role admin/staff belum dibuat.

## Keputusan implementasi tambahan (bukan instruksi PPT)
- Tabel pivot `product_supplier` (many-to-many), tabel `stock_movements` (type in/out).
- Transaksi stok memakai `DB::transaction()` + `lockForUpdate()`.
- Sorting memakai allowlist (name, price, stock).
- Stok hanya diubah lewat transaksi stok; form edit produk tidak mengubah stok.
- Produk dengan histori stok dan kategori yang masih dipakai tidak bisa dihapus.
- Tampilan memakai Bootstrap 5 via CDN (butuh internet saat dibuka).
- Diasumsikan Laravel 11/12 (cek `php artisan --version`).

## Cara memasang
1. `composer create-project laravel/laravel inventory-laravel` lalu `cd inventory-laravel`
2. Salin isi folder `app/`, `database/`, `resources/`, `routes/` dari zip ini ke project
   (timpa `routes/web.php` dan `database/seeders/DatabaseSeeder.php`; tambahkan file lain).
   Hapus `database/factories/UserFactory.php` hanya jika bentrok — biasanya dibiarkan.
3. Di `app/Providers/AppServiceProvider.php`, method `boot()`, tambahkan:
   `\Illuminate\Pagination\Paginator::useBootstrapFive();`
4. Buat database `inventory_db` di phpMyAdmin (MySQL XAMPP aktif).
5. Edit `.env`:
   ```
   APP_NAME=Inventory
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   (`.env` jangan di-commit ke repository publik.)
6. `php artisan key:generate` (jika APP_KEY kosong)
7. `php artisan migrate:fresh --seed` (menghapus SEMUA tabel di database itu; pakai database dev saja)
8. `php artisan route:list` lalu `php artisan serve` → buka http://127.0.0.1:8000

XAMPP hanya menjalankan MySQL; `php artisan serve` menjalankan aplikasi Laravel. Keduanya terpisah.

## Tabel pengujian (isi setelah benar-benar dijalankan)
| No | Pengujian | Hasil yang diharapkan | Hasil aktual | Status |
|----|-----------|-----------------------|--------------|--------|
| 1 | `php artisan serve` | Halaman dashboard terbuka | Belum diuji | Belum diuji |
| 2 | Koneksi DB via .env | Migration berjalan | Belum diuji | Belum diuji |
| 3 | `migrate:fresh --seed` | Tabel & data terisi | Belum diuji | Belum diuji |
| 4 | `route:list` | Route products/categories/suppliers/stock tampil | Belum diuji | Belum diuji |
| 5 | CRUD kategori | Tambah/edit/hapus berhasil | Belum diuji | Belum diuji |
| 6 | CRUD produk | Tambah/edit/hapus berhasil | Belum diuji | Belum diuji |
| 7 | CRUD supplier | Tambah/edit/hapus berhasil | Belum diuji | Belum diuji |
| 8 | SKU duplikat | Ditolak + pesan error | Belum diuji | Belum diuji |
| 9 | Hapus kategori yang dipakai produk | Ditolak | Belum diuji | Belum diuji |
| 10 | Search + filter + sort + pagination | Parameter terbawa antar halaman | Belum diuji | Belum diuji |
| 11 | Barang masuk | Stok bertambah + histori tercatat | Belum diuji | Belum diuji |
| 12 | Barang keluar > stok | Ditolak, stok tidak berubah | Belum diuji | Belum diuji |
| 13 | Form tanpa @csrf (uji manual) | Error 419 | Belum diuji | Belum diuji |

## Error umum
- `composer` tidak ditemukan: PHP/Composer belum di PATH; pasang Composer dan buka terminal baru.
- Versi PHP tidak kompatibel: cek `php -v` terhadap syarat versi Laravel Anda.
- SQLSTATE connection refused / Unknown database: MySQL belum menyala atau database belum dibuat; cek `.env`.
- No application encryption key: jalankan `php artisan key:generate`.
- MassAssignmentException: kolom belum ada di `$fillable` model.
- Route not defined / 404: cek nama di `route:list`.
- View not found: cek nama file di `resources/views` (titik = folder).
