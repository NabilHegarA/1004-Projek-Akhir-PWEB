# 🎣 HookPoint - Sistem Booking Lapak Pemancingan Berbasis Website

HookPoint adalah platform reservasi lapak pemancingan berbasis web yang dirancang untuk mempermudah proses pemesanan lapak secara online. Sistem ini memungkinkan pelanggan melihat informasi lapak, memilih jadwal yang tersedia, melakukan reservasi, serta mengunggah bukti pembayaran tanpa harus datang langsung ke lokasi.

Selain membantu pelanggan, HookPoint juga menyediakan fitur manajemen bagi admin untuk mengelola lapak, memantau transaksi, mengatur status reservasi, serta melihat laporan pendapatan secara terstruktur. Dengan adanya sistem ini, proses reservasi yang sebelumnya dilakukan secara manual dapat menjadi lebih efisien, terorganisir, dan minim kesalahan.

**Dibuat oleh:**
Nabil Hegar Apurina (NIM: 242410101004)

**Program Studi Sistem Informasi**
**Fakultas Ilmu Komputer - Universitas Jember**

🎥 **Demo Video:**
[https://youtu.be/9Pph7qoyF8c](https://youtu.be/9Pph7qoyF8c)

🌐 **URL Deploy:**
[https://hookpoint-production.up.railway.app](https://hookpoint-production.up.railway.app)

---

# 🎯 Tujuan Pengembangan

HookPoint dikembangkan untuk:

* Mempermudah pelanggan dalam melakukan reservasi lapak pemancingan secara online.
* Mengurangi risiko bentrok jadwal pemesanan melalui sistem pengecekan ketersediaan lapak.
* Membantu pengelola dalam mengelola data lapak dan transaksi secara terpusat.
* Menyediakan pencatatan transaksi yang lebih terstruktur dan terdokumentasi.
* Menyediakan laporan pendapatan yang dapat membantu pengelola memantau perkembangan usaha.
* Mendukung digitalisasi layanan usaha pemancingan agar lebih modern dan efisien.

---

# ✨ Fitur Utama

Aplikasi HookPoint menyediakan fitur yang dirancang untuk memenuhi kebutuhan pelanggan maupun pengelola lapak pemancingan.

## 👤 Fitur Pengguna (User)

### Autentikasi

* Registrasi akun
* Login akun
* Logout akun
* Remember Me

### Profil

* Melihat profil pengguna
* Mengubah data profil

### Lapak

* Melihat daftar lapak pemancingan
* Melihat detail lapak
* Booking lapak berdasarkan tanggal dan jam
* Upload bukti transfer pembayaran

### Transaksi

* Pembatalan transaksi yang masih berstatus pending
* Melihat transaksi aktif
* Melihat riwayat transaksi
* Filter transaksi berdasarkan status, jenis kolam, tanggal, dan jam booking

---

## 👨‍💼 Fitur Admin

### Autentikasi

* Login akun
* Logout akun
* Remember Me

### Dashboard

* Melihat total transaksi
* Melihat total pendapatan
* Melihat total lapak yang ada
* Monitoring aktivitas reservasi

### Pengelolaan

* Menambah lapak baru
* Mengubah data lapak
* Mengatur status ketersediaan lapak
* Soft delete lapak (status unavailable)

### Transaksi

* Melihat seluruh transaksi pengguna
* Mengonfirmasi reservasi
* Menolak reservasi beserta alasan penolakan
* Menyelesaikan transaksi
* Monitoring transaksi berdasarkan status

---

# 🛠️ Teknologi yang Digunakan

## Backend

**PHP 8+** : Digunakan sebagai bahasa pemrograman utama untuk membangun logika bisnis dan proses pengolahan data pada sistem.

**Laravel 12** : Framework PHP yang digunakan untuk mempercepat pengembangan aplikasi melalui fitur routing, middleware, authentication, migration, Eloquent ORM, serta manajemen keamanan aplikasi.

---

## Frontend

**HTML5** : Digunakan untuk membangun struktur halaman website.

**CSS3** : Digunakan untuk mengatur tampilan antarmuka agar lebih menarik, responsif, dan mudah digunakan.

**JavaScript** : Digunakan untuk meningkatkan interaktivitas sistem seperti validasi form, popup konfirmasi, dan manipulasi elemen halaman.

**Blade Template Engine** : Digunakan sebagai template engine bawaan Laravel untuk membangun tampilan website secara dinamis dan efisien.

---

## Database

**MySQL** : Digunakan untuk menyimpan seluruh data aplikasi seperti data pengguna, lapak, transaksi reservasi, dan informasi pembayaran.

---

## Tools Development

**GitHub** : Digunakan sebagai repositori penyimpanan source code dan kolaborasi pengembangan.

**Laragon** : Digunakan sebagai local development server selama proses pembangunan aplikasi.

**Visual Studio Code** : Digunakan sebagai code editor utama dalam pengembangan sistem.

---

# 🗄️ Struktur Database

Sistem HookPoint menggunakan database relasional MySQL yang terdiri dari beberapa tabel utama berikut:

**users** : Menyimpan data akun pengguna dan administrator.

**lapaks** : Menyimpan informasi lapak pemancingan yang tersedia.

**bookings** : Mencatat seluruh transaksi reservasi lapak.

---

# 📊 Status Reservasi

Sistem menggunakan beberapa status transaksi untuk memantau proses booking:

* Pending
* Confirmed
* Completed
* Rejected
* Cancelled

---

# 🔐 Akun Akses Default

Berikut akun yang dapat digunakan untuk melakukan pengujian sistem:

## Admin

**Email:** [admin@hookpoint.com](mailto:admin@hookpoint.com)

**Password:** admin123

---

## User

**Email:** [nabilha064@gmail.com](mailto:nabilha064@gmail.com)

**Password:** 12345678

---

# 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademik dan pembelajaran sebagai Proyek Akhir Mata Kuliah Pemrograman Berbasis Website Program Studi Sistem Informasi Universitas Jember.

Penggunaan, modifikasi, dan pengembangan lebih lanjut diperbolehkan untuk tujuan pendidikan dengan tetap mencantumkan kredit kepada pengembang.
