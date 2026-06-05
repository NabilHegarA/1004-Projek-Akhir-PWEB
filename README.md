# 🎣 HookPoint - Sistem Reservasi Lapak Pemancingan

## 📌 Deskripsi

HookPoint adalah website reservasi lapak pemancingan yang memudahkan pengguna dalam melakukan pemesanan lapak secara online. Sistem ini menyediakan fitur booking, konfirmasi pembayaran, manajemen lapak, serta pengelolaan transaksi oleh admin.

Website ini dikembangkan menggunakan framework Laravel sebagai bagian dari Proyek Akhir Pemrograman Web.

---

## ✨ Fitur Utama

### 👤 User

* Registrasi akun
* Login dan Logout
* Remember Me
* Melihat daftar lapak pemancingan
* Melihat detail lapak
* Booking lapak
* Upload bukti transfer
* Melihat riwayat transaksi
* Membatalkan booking yang masih berstatus pending
* Filter transaksi berdasarkan:

  * Status
  * Jenis kolam
  * Tanggal
  * Jam booking

### 👨‍💼 Admin

* Login admin
* Dashboard statistik
* Kelola data lapak
* Tambah lapak
* Edit lapak
* Soft delete lapak (status unavailable)
* Konfirmasi booking
* Menolak booking beserta alasan penolakan
* Menyelesaikan transaksi
* Monitoring transaksi user
* Filter transaksi berdasarkan:

  * Status
  * Jenis kolam
  * Tanggal
  * Jam booking

---

## 🛠️ Teknologi yang Digunakan

### Backend

* PHP 8+
* Laravel 12

### Frontend

* HTML
* CSS
* JavaScript

### Database

* MySQL

### Tools

* Git
* GitHub
* XAMPP

---

## 📂 Struktur Database

### Users

* id
* name
* email
* password
* role

### Lapaks

* id
* nama
* jenis
* harga
* deskripsi
* gambar
* status

### Bookings

* id
* user_id
* lapak_id
* tanggal_booking
* jam_booking
* jumlah_orang
* metode_pembayaran
* harga_snapshot
* total_harga
* bukti_tf
* status
* rejection_reason

---

## 🚀 Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/username/hookpoint.git
```

### 2. Masuk ke Folder Project

```bash
cd hookpoint
```

### 3. Install Dependency

```bash
composer install
```

### 4. Copy File Environment

```bash
cp .env.example .env
```

### 5. Generate Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Ubah file `.env`

```env
DB_DATABASE=hookpoint
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Migrasi Database

```bash
php artisan migrate
```

### 8. Jalankan Server

```bash
php artisan serve
```

---

## 📷 Tampilan Sistem

### Landing Page

Menampilkan informasi lapak yang tersedia beserta detailnya.

### Booking

Pengguna dapat melakukan reservasi lapak dengan memilih tanggal dan jam yang tersedia.

### Dashboard Admin

Menampilkan statistik transaksi, pendapatan, dan data lapak.

### Transaksi

Admin dapat melakukan konfirmasi, penolakan, maupun penyelesaian transaksi.

---

## 📊 Status Booking

* Pending
* Confirmed
* Completed
* Rejected
* Canceled

---

## 👨‍💻 Pengembang

Nama : Nabil Hegar

Proyek Akhir Pemrograman Web

Universitas Jember

---

## 📄 Lisensi

Project ini dibuat untuk kebutuhan akademik dan pembelajaran.
