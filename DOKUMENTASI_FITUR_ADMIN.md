# DOKUMENTASI LENGKAP FITUR PANEL ADMIN (A1ORA WATCH)

Dokumen ini berisi rangkuman arsitektur, rute, komponen logika **Backend**, dan antarmuka **Frontend** yang telah diimplementasikan pada Panel Admin Toko Jam Tangan A1ORA.

---

## 1. Arsitektur & Keamanan Rute (Routing & Middleware)

Seluruh fitur admin dilindungi oleh middleware otentikasi dan otorisasi peran (*role-based access control*).

* **Grup Rute:** Didefinisikan di [`routes/web.php`](file:///d:/e-commerce%20jam%20tangan/routes/web.php)
* **Prefix URL:** `/admin`
* **Name Prefix:** `admin.`
* **Middleware:** `['auth', 'role:admin']`
  * Pengguna yang belum login otomatis diarahkan ke form `/login`.
  * Pengguna yang login dengan role `pelanggan` akan ditolak saat mencoba membuka URL berawalan `/admin/*`.

### Daftar Seluruh Rute Admin

| HTTP Method | URL Endpoint | Nama Rute | Controller & Method | Deskripsi Fungsi |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/admin/dashboard` | `admin.dashboard` | Closure View | Menampilkan halaman portal utama dashboard admin |
| `GET` | `/admin/kategori` | `admin.kategori.index` | `Admin\KategoriController@index` | Menampilkan daftar kategori dan total produk |
| `POST` | `/admin/kategori` | `admin.kategori.store` | `Admin\KategoriController@store` | Menyimpan kategori produk baru |
| `PUT` | `/admin/kategori/{id}` | `admin.kategori.update` | `Admin\KategoriController@update` | Memperbarui nama dan deskripsi kategori |
| `DELETE` | `/admin/kategori/{id}` | `admin.kategori.destroy` | `Admin\KategoriController@destroy` | Menghapus kategori (dilengkapi proteksi integritas) |
| `GET` | `/admin/varian` | `admin.varian.index` | `Admin\VarianController@index` | Pusat monitoring inventaris, varian, dan stok |
| `POST` | `/admin/varian` | `admin.varian.store` | `Admin\VarianController@store` | Menambah varian baru beserta harga dan stok awal |
| `PUT` | `/admin/varian/{id}` | `admin.varian.update` | `Admin\VarianController@update` | Mengubah informasi lengkap varian produk |
| `PATCH` | `/admin/varian/{id}/stok-harga` | `admin.varian.updateStokHarga` | `Admin\VarianController@updateStokHarga` | **Quick Update** harga dan stok secara instan |
| `DELETE` | `/admin/varian/{id}` | `admin.varian.destroy` | `Admin\VarianController@destroy` | Hapus varian / nonaktifkan jika ada transaksi |
| `GET` | `/admin/pesanan` | `admin.pesanan.index` | `Admin\PesananController@index` | Logistik & manajemen pesanan pelanggan |
| `POST` | `/admin/pesanan/{id}/status` | `admin.pesanan.updateStatus` | `Admin\PesananController@updateStatus` | Verifikasi pembayaran & update status order |
| `POST` | `/admin/pesanan/{id}/resi` | `admin.pesanan.updateResi` | `Admin\PesananController@updateResi` | Input nomor resi pengiriman kurir ekspedisi |
| `GET` | `/admin/laporan-omzet` | `admin.laporan.omzet` | `Admin\LaporanController@index` | Analitik omzet penjualan bulanan |
| `GET` | `/admin/laporan-omzet/cetak` | `admin.laporan.omzet.cetak` | `Admin\LaporanController@cetak` | Tampilan resmi rekap omzet siap cetak/PDF |

---

## 2. Pemetaan Fitur: Backend vs Frontend

---

### A. Dashboard Utama Admin
Portal navigasi bagi administrator saat pertama kali login.

* **Backend:**
  * **File Rute:** [`routes/web.php`](file:///d:/e-commerce%20jam%20tangan/routes/web.php)
  * **Logika:** Mengambil identitas pengguna terotentikasi melalui `Auth::user()` dan memastikan `role === 'admin'`.
* **Frontend:**
  * **File Tampilan:** [`resources/views/admin/dashboard.blade.php`](file:///d:/e-commerce%20jam%20tangan/resources/views/admin/dashboard.blade.php)
  * **Fitur UI:** 
    * Top Bar dengan indikator nama akun admin dan tombol Logout.
    * Kartu sambutan administrator.
    * Grid menu operasional interaktif: Kategori Produk, Varian & Stok, Pesanan Logistik, dan Laporan Omzet.

---

### B. Modul CRUD Kategori Produk
Manajemen master pengelompokan jam tangan (contoh: Automatic, Chronograph, Diver, Smartwatch, Classic).

* **Backend:**
  * **Controller:** [`app/Http/Controllers/Admin/KategoriController.php`](file:///d:/e-commerce%20jam%20tangan/app/Http/Controllers/Admin/KategoriController.php)
  * **Model & Tabel:** [`app/Models/Kategori.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/Kategori.php) (Tabel: `kategori`)
  * **Logika Bisnis:**
    * Menggunakan `Kategori::withCount('produk')` untuk menghitung relasi jam tangan yang ada di dalam kategori secara efisien.
    * Validasi input unik pada kolom `nama_kategori` agar tidak terjadi duplikasi.
    * **Proteksi Foreign Key:** Pengecekan `if ($kategori->produk()->exists())` sebelum menghapus, sehingga kategori yang masih memiliki jam tangan tidak dapat dihapus sembarangan.
* **Frontend:**
  * **File Tampilan:** [`resources/views/admin/kategori/index.blade.php`](file:///d:/e-commerce%20jam%20tangan/resources/views/admin/kategori/index.blade.php)
  * **Fitur UI & JavaScript:**
    * Tabel daftar kategori dengan nomor urut, deskripsi, dan badge total produk.
    * Modal Tambah Kategori Baru (`modalTambah`).
    * Modal Ubah Kategori (`modalEdit`) dengan pengisian data otomatis via JavaScript.
    * Dialog konfirmasi `onsubmit="return confirm(...)"` pada aksi hapus.
    * Alert notifikasi sukses/error (*Flash message*).

---

### C. Pusat Kelola Varian, Harga & Stok (Inventory)
Pusat kendali persediaan gudang, penyesuaian harga jual, dan manajemen varian jam tangan (warna, strap/tali, kode SKU).

* **Backend:**
  * **Controller:** [`app/Http/Controllers/Admin/VarianController.php`](file:///d:/e-commerce%20jam%20tangan/app/Http/Controllers/Admin/VarianController.php)
  * **Model & Tabel:** [`app/Models/VarianProduk.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/VarianProduk.php) (Tabel: `varian_produk`), berelasi ke [`app/Models/Produk.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/Produk.php)
  * **Logika Bisnis:**
    * Menghitung statistik inventaris secara agregat: Total SKU, Total Fisik Unit (`sum('stok')`), Stok Menipis (`stok <= 5`), dan Stok Habis (`stok == 0`).
    * Filter pencarian multi-kolom (nama varian, kode SKU, dan nama produk induk).
    * **Quick Update API:** Method `updateStokHarga()` untuk mempercepat proses stock opname dan update harga tanpa form berbelit-belit.
    * **Proteksi Riwayat Transaksi:** Jika varian pernah dibeli pelanggan (`$varian->detailPesanan()->exists()`), sistem otomatis mengubah statusnya menjadi `nonaktif` alih-alih menghapus permanen, menjaga integritas laporan penjualan.
* **Frontend:**
  * **File Tampilan:** [`resources/views/admin/varian/index.blade.php`](file:///d:/e-commerce%20jam%20tangan/resources/views/admin/varian/index.blade.php)
  * **Fitur UI & JavaScript:**
    * 4 Kartu KPI Inventaris dengan visual modern.
    * Tab filter status stok: *Semua*, *Stok Aman (> 5)*, *Stok Menipis (≤ 5)*, *Stok Habis (0)*.
    * Dropdown pemilihan model jam tangan dan input pencarian SKU.
    * Indikator warna stok pada tabel: 🟢 Hijau (Aman), 🟡 Kuning (Menipis), 🔴 Merah (Habis).
    * Modal Tambah Varian Baru (`modalTambah`).
    * Modal Pembaruan Cepat Harga & Stok (`modalQuickUpdate`).
    * Modal Edit Lengkap Varian (`modalEdit`).

---

### D. Manajemen Pesanan & Logistik Pengiriman
Memproses transaksi pembelian pelanggan, memeriksa bukti transfer, dan input resi kurir ekspedisi.

* **Backend:**
  * **Controller:** [`app/Http/Controllers/Admin/PesananController.php`](file:///d:/e-commerce%20jam%20tangan/app/Http/Controllers/Admin/PesananController.php)
  * **Model & Tabel:** [`app/Models/Pesanan.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/Pesanan.php), [`app/Models/Pengiriman.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/Pengiriman.php), [`app/Models/Pembayaran.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/Pembayaran.php)
  * **Logika Bisnis:**
    * Filter riwayat pesanan berdasarkan tab: *Semua*, *Menunggu Pembayaran*, *Diproses*, *Dikirim*, *Selesai*, *Dibatalkan*.
    * Validasi dan pembaruan nomor resi pada tabel `pengiriman`.
    * Perubahan status pesanan otomatis memicu update status pengiriman/pembayaran terkait.
* **Frontend:**
  * **File Tampilan:** [`resources/views/admin/pesanan/index.blade.php`](file:///d:/e-commerce%20jam%20tangan/resources/views/admin/pesanan/index.blade.php)
  * **Fitur UI & JavaScript:**
    * Kartu metrik transaksi pesanan harian/bulanan.
    * Daftar pesanan lengkap dengan item jam tangan, kuantitas, kurir pengiriman, dan nama pemesan.
    * Modal input nomor resi kurir.
    * Modal pratinjau bukti transfer pembayaran.

---

### E. Laporan Omzet Bulanan & Cetak Dokumen
Audit finansial penjualan jam tangan dan pencetakan dokumen pembukuan.

* **Backend:**
  * **Controller:** [`app/Http/Controllers/Admin/LaporanController.php`](file:///d:/e-commerce%20jam%20tangan/app/Http/Controllers/Admin/LaporanController.php)
  * **Model & Tabel:** [`app/Models/Pesanan.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/Pesanan.php), [`app/Models/DetailPesanan.php`](file:///d:/e-commerce%20jam%20tangan/app/Models/DetailPesanan.php)
  * **Logika Bisnis:**
    * Mengagregasi data transaksi dengan status `selesai`.
    * Menghitung Total Omzet (Rp), Rata-rata Nilai Transaksi (*Average Order Value*), serta Total Unit Jam Tangan Terjual.
    * Filter fleksibel per bulan dan per tahun.
* **Frontend:**
  * **File Tampilan Analitik:** [`resources/views/admin/laporan/omzet.blade.php`](file:///d:/e-commerce%20jam%20tangan/resources/views/admin/laporan/omzet.blade.php)
    * Dilengkapi kartu audit terverifikasi, persentase performa, dan tabel breakdown harian.
  * **File Tampilan Cetak:** [`resources/views/admin/laporan/cetak.blade.php`](file:///d:/e-commerce%20jam%20tangan/resources/views/admin/laporan/cetak.blade.php)
    * Diformat bersih tanpa header navigasi web, menggunakan layout khusus cetak/PDF dan fungsi JavaScript `window.print()`.

---

## 3. Struktur Database Relasional Panel Admin

```
[kategori] 1 ────< N [produk] 1 ────< N [varian_produk]
                         |                       |
                         | 1                     | 1
                         |                       |
                         v N                     v N
                   [galeri_produk]        [detail_pesanan] N >──── 1 [pesanan]
                                                                        |
                                                 [pengiriman] 1 <───────+───────> 1 [pembayaran]
```

### Tabel yang Digunakan:
1. **`users`**: Menyimpan akun pengguna beserta role (`admin` atau `pelanggan`).
2. **`kategori`**: Menyimpan kategori produk (`kategori_id`, `nama_kategori`, `deskripsi`).
3. **`produk`**: Menyimpan model jam tangan (`produk_id`, `kategori_id`, `merek_id`, `nama_produk`, `kode_produk`, `status_produk`).
4. **`varian_produk`**: Menyimpan SKU, variasi warna, strap/tali, harga jual, dan stok gudang (`varian_id`, `produk_id`, `kode_sku`, `harga_varian`, `stok`, `status_varian`).
5. **`pesanan`**: Transaksi pemesanan oleh pelanggan (`pesanan_id`, `user_id`, `total_harga`, `status_pesanan`).
6. **`detail_pesanan`**: Rincian item varian jam yang dibeli dalam suatu pesanan.
7. **`pengiriman`**: Informasi kurir, alamat tujuan, ongkos kirim, dan nomor resi.
8. **`pembayaran`**: Metode bayar, bukti transfer bank, dan status pembayaran.

---

## 4. Standar Teknologi yang Digunakan

* **Backend:**
  * PHP 8.2+
  * Laravel Framework 12
  * Eloquent ORM (Relasi `hasMany`, `belongsTo`, `withCount`, `sum`)
  * Blade Template Engine
* **Frontend:**
  * **Styling:** Tailwind CSS (via CDN)
  * **Icon Pack:** Bootstrap Icons (v1.11.3)
  * **Tipografi:** Google Fonts (Inter: 400, 500, 600, 700, 800, 900)
  * **Interaktivitas:** Vanilla JavaScript murni untuk membuka/menutup modal, autofill input, dan konfirmasi aksi hapus.

---

## 5. Panduan Pengujian Lokal

1. **Jalankan Server:**
   ```powershell
   php artisan serve
   ```
2. **Login Akun Admin:**
   * URL: `http://127.0.0.1:8000/login`
   * Username: `admin`
   * Password: `password123`
3. **Akses URL Menu Admin:**
   * Dashboard: `http://127.0.0.1:8000/admin/dashboard`
   * Kategori Produk: `http://127.0.0.1:8000/admin/kategori`
   * Varian & Stok: `http://127.0.0.1:8000/admin/varian`
   * Pesanan & Logistik: `http://127.0.0.1:8000/admin/pesanan`
   * Laporan Omzet: `http://127.0.0.1:8000/admin/laporan-omzet`
