# Kantin Sehat

**Kantin Sehat** adalah sistem informasi berbasis web untuk membantu digitalisasi operasional kantin, mulai dari transaksi kasir, pengelolaan barang dan persediaan, stock opname, data karyawan, hingga rekap dan pelaporan keuangan.

Proyek ini dikembangkan sebagai bagian dari kegiatan magang di **UPT Pelayanan Kesehatan, Badan Pengelola Islamic Center Provinsi Kalimantan Timur**.

## Tujuan Proyek

Sistem ini dibuat untuk membantu proses operasional kantin agar pencatatan transaksi dan data persediaan dapat dilakukan secara lebih terstruktur, mengurangi pencatatan manual, serta memudahkan pemantauan stok dan penyusunan laporan.

## Fitur Utama

### Admin

- Dashboard statistik penjualan dan pembelian berdasarkan periode.
- Statistik barang terlaris, barang dengan laba tertinggi, dan barang dengan penjualan rendah.
- Manajemen data barang, kategori barang, harga pokok, harga jual, dan status aktif barang.
- Pembuatan kode/barcode barang secara otomatis serta fitur cetak barcode.
- Pengelolaan barang biasa dan barang titipan beserta skema hasil bagi.
- Pengelolaan persediaan, pembelian, penambahan barang titipan, pengembalian/penghapusan, serta histori perubahan data.
- Pencatatan stok masuk dan perhitungan biaya persediaan menggunakan pendekatan FIFO.
- Stock opname untuk membandingkan stok sistem dengan stok fisik serta melakukan penyesuaian stok dan kas.
- Manajemen data karyawan dengan role **Admin** dan **Kasir**.
- Pencatatan pembayaran gaji karyawan.
- Pencatatan pengeluaran operasional.
- Manajemen shift kasir dan laporan transaksi berdasarkan shift.
- Histori transaksi dengan fitur tambah, ubah, hapus, pencarian, dan filter metode pembayaran.
- Rekap saldo kas dan saldo barang bulanan.
- Activity log untuk membantu melacak perubahan data transaksi dan persediaan.
- Pelaporan periodik berupa:
  - Ringkasan Penerimaan & Pembayaran
  - Ringkasan Nilai Persediaan
  - Ringkasan Kuantitas Persediaan
  - Margin Laba Persediaan Barang
  - Laporan Laba Rugi

### Kasir

- Login dan pembatasan akses berdasarkan role.
- Pencarian produk berdasarkan nama atau barcode.
- Keranjang transaksi dengan validasi ketersediaan stok.
- Transaksi dengan metode pembayaran tunai dan transfer/non-tunai.
- Perhitungan uang diterima dan kembalian pada transaksi tunai.
- Pencatatan transaksi dan detail barang secara otomatis.
- Pengurangan stok setelah transaksi berhasil.
- Histori transaksi harian.
- Akses informasi persediaan barang.

## Teknologi yang Digunakan

| Teknologi | Kegunaan |
| --- | --- |
| PHP 8.2+ | Bahasa pemrograman backend |
| Laravel 12 | Framework aplikasi web |
| Laravel Livewire 3 | Interaksi antarmuka secara dinamis |
| Blade | Template antarmuka Laravel |
| Tailwind CSS | Styling antarmuka |
| Flowbite | Komponen UI |
| JavaScript | Interaksi frontend |
| Vite | Build tool frontend |
| MySQL / MariaDB | Basis data relasional |
| Eloquent ORM | Pengelolaan dan relasi data |
| Spatie Laravel Activitylog | Pencatatan perubahan data |
| Chart.js | Visualisasi data dashboard |
| SweetAlert2 | Notifikasi dan dialog konfirmasi |
| Git & GitHub | Version control |

## Gambaran Arsitektur

```text
Pengguna (Admin / Kasir)
          |
          v
Blade + Tailwind CSS + Livewire
          |
          v
      Laravel 12
          |
          v
     Eloquent ORM
          |
          v
   MySQL / MariaDB
```

Aplikasi menggunakan pemisahan hak akses antara **Admin** dan **Kasir**. Data utama dikelola melalui model dan relasi Eloquent, sedangkan Livewire digunakan untuk menangani interaksi seperti pencarian barang, transaksi, filter data, validasi form, dan pembaruan tampilan.

## Entitas Data Utama

Beberapa data yang dikelola aplikasi:

- User/Karyawan
- Barang
- Persediaan
- Stok Masuk
- Transaksi Kasir
- Detail Transaksi
- Shift
- Gaji Karyawan
- Pengeluaran
- Kas dan Kas Kembalian
- Kas Barang Titipan
- Saldo Kas Bulanan
- Saldo Barang Bulanan
- Data Kerugian dan Keuntungan

## Instalasi Lokal

### 1. Clone Repository

```bash
git clone https://github.com/DindaAyuAprilia/kantin-sehat.git
cd kantin-sehat
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Buat File Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfigurasi Database

Buat database baru bernama `kantin_sehat`, kemudian sesuaikan `.env`:

```env
APP_NAME="Kantin Sehat"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantin_sehat
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### 6. Jalankan Migration

```bash
php artisan migrate
```

### 7. Buat Akun Admin

Jalankan:

```bash
php artisan tinker
```

Kemudian:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'nama' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'status' => 'aktif',
]);
```

Keluar dengan:

```text
exit
```

> Ganti email dan password contoh sebelum aplikasi digunakan pada lingkungan selain lokal.

### 8. Jalankan Aplikasi

Terminal pertama:

```bash
php artisan serve
```

Terminal kedua:

```bash
npm run dev
```

Buka:

```text
http://127.0.0.1:8000
```

## Struktur Folder Utama

```text
app/
├── Http/Controllers/       # Controller dan autentikasi
├── Livewire/               # Logika fitur interaktif
├── Models/                 # Model dan relasi database
└── Jobs/                   # Proses pembaruan data

database/
├── migrations/             # Struktur database
└── seeders/                # Seeder aplikasi

resources/
├── css/                    # Styling
├── js/                     # JavaScript frontend
└── views/                  # Blade dan Livewire views

routes/
├── auth.php                # Route autentikasi
└── web.php                 # Route utama aplikasi
```

## Konteks Pengembangan

Proyek ini merupakan bagian dari pengalaman magang dan digunakan sebagai sarana penerapan pengembangan aplikasi web untuk kebutuhan operasional.

Pengembangan mencakup perancangan fitur, implementasi antarmuka dan backend, pengelolaan basis data, validasi data, debugging, serta pengembangan modul transaksi, persediaan, dan pelaporan.

## Pengembang

**Dinda Ayu Aprilia**  
S1 Informatika — Universitas Mulawarman

GitHub: [DindaAyuAprilia](https://github.com/DindaAyuAprilia)

## Catatan

Repository ini ditujukan sebagai dokumentasi proyek dan portofolio pengembangan aplikasi web. Data akun, database operasional, credential, file `.env`, dan informasi sensitif tidak disertakan di dalam repository publik.
