# Vehicle Tracker

Aplikasi manajemen pemesanan kendaraan dinas berbasis Laravel.

## Activity Diagram dan Pysical data model ada pada direktory /docs

---

## Daftar Akun Test

| Role      | Username      | Password   |
|-----------|--------------|------------|
| Admin     | admin        | password   |
| Approver1 | approver1    | password   |
| Approver2 | approver2    | password   |
| User      | user1        | password   |
| User      | user2        | password   |

> **Catatan:** Username dan password di atas otomatis tersedia setelah menjalankan seeder `CompletedSeeder`.

---

## Versi & Teknologi

- **Database:** PostgreSQL (disarankan versi 13.x atau lebih baru) atau boleh pakai MySQL
- **PHP:** 8.2 atau lebih baru
- **Framework:** Laravel 12.x
- **Spreadsheet Export:** phpoffice/phpspreadsheet

---

## Panduan Penggunaan Aplikasi

### 1. Instalasi

1. Clone repository ini. ( `https://github.com/faisalfariq/vehicle-tracker` )
2. Jalankan `composer install` dan `npm install`.
3. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi database.
4. Jalankan migrasi dan seed data:

   ```bash
   php artisan migrate --seed --class=CompletedSeeder
   ```

   > **Penting:** Hanya jalankan seeder `CompletedSeeder` untuk data awal!

5. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

### 2. Mekanisme Booking Kendaraan

- **Buat Booking:**
  - User mengisi form booking (pilih kendaraan, driver, tanggal, tujuan, alasan, dan dua approver).
  - Admin Juga boleh mengisi form booking
  - Hanya kendaraan yang tersedia yang bisa dipilih.
  - Status awal booking: `draft`.
- **Submit Booking:**
  - Setelah submit, status menjadi `pending` dan masuk proses approval. (boleh dilakukan oleh user sendiri ataupun admin)
- **Approval:**
  - Approver level 1 dan 2 harus menyetujui.
  - Hanya approver 2 yang bisa mengubah status booking menjadi `approved` (jika approve, approver 1 otomatis ikut approved jika belum).
  - Jika salah satu approver menolak, status booking menjadi `rejected`.
- **Penggunaan Kendaraan:**
  - Setelah approved, status bisa diubah menjadi `onuse` oleh admin saja (kendaraan otomatis jadi tidak tersedia).
- **Selesai:**
  - Setelah selesai digunakan, status booking diubah menjadi `finish`oleh admin saja (kendaraan otomatis tersedia kembali).
- **Edit/Hapus:**
  - Booking hanya bisa diedit/dihapus jika status masih `draft`.

### 3. Modul Master Data

- **Kendaraan:** Data kendaraan yang dapat dipesan.
- **Driver:** Data supir yang dapat dipilih saat booking.
- **User:** Data pengguna aplikasi (admin, approver, user biasa).
- **Region:** Wilayah/area kendaraan dan driver.
- **Lainnya:** Master data lain digunakan untuk mendukung proses booking dan pelaporan.

### 4. Modul Lain

- **Booking Approval:** Menu khusus untuk approver melakukan approval/reject booking.
- **Laporan Booking:** Fitur filter & export ke Excel.
- **Dashboard:** Monitoring status booking, kendaraan, dan statistik pemakaian.

---

## Catatan Penting

- Hanya seeder `CompletedSeeder` yang boleh dijalankan untuk data awal.
- Pastikan konfigurasi database dan environment sudah benar sebelum menjalankan migrasi/seed.
- Untuk keamanan, ganti password akun test pada lingkungan produksi.

---

Selamat menggunakan aplikasi Vehicle Tracker!
