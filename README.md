# Coffee VNT Management System

Coffee VNT Management System adalah aplikasi berbasis web yang dirancang untuk mempermudah pengelolaan operasional di **Coffee Shop VNT**. Aplikasi ini fokus pada pengelolaan data pengguna, menu, transaksi, dan aktivitas log pengguna yang dapat diakses oleh tiga peran utama: **Admin**, **Manager**, dan **Kasir**.

Dengan antarmuka yang intuitif dan fitur lengkap, sistem ini membantu meningkatkan efisiensi operasional di Coffee Shop VNT.

Dibikin Oleh: **Syafarul Priwantoro** Dan **Shafira Daffa Tzabillah** (**Mahasiswa Telkom Surabaya**)

---

## 🎯 Fitur Utama

### **👩‍💼 Admin**
Sebagai Admin, Anda memiliki akses penuh untuk mengelola aplikasi dan data yang ada. Fitur yang dapat diakses antara lain:
- **Dashboard Admin:** Menampilkan data pengguna dan menu.
- **Menambahkan User Baru:** Mengelola data pengguna dengan mudah.
- **Ekspor Data:** Mengekspor data pengguna dalam format **Excel** dan **PDF**.
- **Log Aktivitas:** Melihat aktivitas pengguna dalam sistem.
- **Pengelolaan Profil Pengguna:** Mengelola profil admin dan pengguna lain.

![Admin Dashboard](public/images/admin.gif)

### **👨‍💼 Manager**
Manager memiliki kemampuan untuk mengelola menu dan transaksi. Fitur yang dapat diakses antara lain:
- **Dashboard Manager:** Menampilkan data yang relevan seperti transaksi dan menu.
- **Mengelola Menu:** Menambahkan dan mengelola menu makanan dan minuman.
- **Ekspor Data:** Mengekspor data menu dan transaksi ke format **Excel** dan **PDF**.
- **Lihat Transaksi:** Mengelola data transaksi seperti nama pelanggan, menu yang dipesan, total harga, dan lebih banyak lagi.
- **Pengelolaan Profil Pengguna:** Mengelola profil manager dan pengguna lain.

![Manager Dashboard](public/images/manager.gif)

### **👨‍🍳 Kasir**
Sebagai Kasir, Anda berfokus pada transaksi pelanggan. Fitur yang dapat diakses antara lain:
- **Dashboard Kasir:** Menampilkan data terkait transaksi pelanggan.
- **Mengelola Transaksi:** Memproses transaksi pelanggan, mulai dari pemilihan menu hingga pembayaran.
- **Ekspor Data Transaksi:** Mengekspor data transaksi dalam format **Excel** dan **PDF**.
- **Pengelolaan Profil Pengguna:** Mengelola profil kasir.

![Kasir Dashboard](public/images/kasir.gif)

- **Contoh Ekspor PDF**
  
![Kasir Dashboard](public/images/midtrans.gif)


### **🚀 Jenkins Pipeline**
Berikut adalah GIF yang menunjukkan pipeline otomatis yang dijalankan melalui Jenkins untuk aplikasi ini:

![Jenkins Pipeline](public/images/jenkins.gif)

- **Docker**


![ Docker](public/images/docker.gif)
---

## 🛠️ Teknologi yang Digunakan

- **Backend Framework:** Laravel (PHP)
- **Frontend Framework:** Blade (Laravel Template Engine)
- **Database:** MySQL
- **CI/CD Tools:** Jenkins, Ngrok
- **Containerization:** Docker
- **Version Control:** Git, GitHub

---

## 🚀 Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi ini di komputer Anda.

### **1. Clone Repository**
Clone repository project ini menggunakan Git.
```bash
git clone https://github.com/farul1/Kasir_CafeVNT.git
cd coffee-vnt-management-system
```


### **2. Install Dependencies**
Pastikan Anda telah menginstal **Composer** dan **NPM**. Jika belum, Anda bisa menginstalnya terlebih dahulu.

```bash
composer install
npm install
```

### **3. Setup Environment**
Salin file `.env.example` menjadi `.env` untuk mengonfigurasi pengaturan aplikasi.

```bash
cp .env.example .env
```

Kemudian, buka file `.env` dan sesuaikan pengaturan database dan konfigurasi aplikasi lainnya.

### **4. Generate Key**
Jalankan perintah berikut untuk menghasilkan aplikasi key.

```bash
php artisan key:generate
```

### **5. Migrasi Database**
Jalankan migrasi untuk membuat tabel yang diperlukan di database.

```bash
php artisan migrate
```

### **6. Menjalankan Aplikasi**
Setelah semua pengaturan selesai, jalankan aplikasi menggunakan perintah berikut.

```bash
php artisan serve
```

Aplikasi akan berjalan pada alamat `http://localhost:8000`.

### **7. Menggunakan Docker (Opsional)**
Jika Anda ingin menjalankan aplikasi menggunakan Docker, pastikan Docker Desktop telah terpasang dan jalankan perintah berikut untuk membuat container:

```bash
docker-compose up -d
```

Aplikasi akan berjalan di dalam container dan dapat diakses di `http://localhost`.

### **8. Konfigurasi Jenkins & Ngrok untuk CI/CD (Opsional)**
Untuk mengotomatisasi pipeline deployment, Anda bisa menggunakan Jenkins dan Ngrok. Berikut adalah langkah-langkah umum:
1. **Jenkins**:
   - Setup Jenkins dengan pipeline yang sesuai untuk aplikasi Laravel.
   - Gunakan plugin seperti GitHub untuk menghubungkan repository.
   
2. **Ngrok**:
   - Jalankan Ngrok untuk mengekspos aplikasi secara publik.
   - Gunakan perintah seperti berikut untuk membuat tunnel ke server lokal:
     ```bash
     ngrok http 8000
     ```

---

## 💬 Hubungi Kami
Jika Anda memiliki pertanyaan atau membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi kami di [priwantoro.syafarul@gmail.com](priwantoro.syafarul@gmail.com).

---


### Fitur Utama:
- **Gambar Dashboard:** Gambar dashboard untuk setiap role (Admin, Manager, Kasir) telah disertakan dengan deskripsi singkat mengenai fitur utama yang dapat diakses oleh masing-masing role.
- **Emojis:** Emoji yang mewakili setiap role digunakan untuk memperjelas informasi.
- **Langkah Instalasi yang Jelas:** Langkah-langkah instalasi disusun secara terperinci dan mudah diikuti.
- **Kontak & Kontribusi:** Ditambahkan informasi mengenai cara menghubungi tim pengembang jika ada masalah atau pertanyaan.

