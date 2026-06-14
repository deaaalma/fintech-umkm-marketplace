# 🗺️ Plan Penyempurnaan Proyek — Platform JOS (UMKM Digitalisasi)
> Disusun berdasarkan full scan proyek pada 12 Juni 2026

---

## 🔍 Kondisi Proyek Saat Ini

Proyek ini adalah platform *multi-tenant* untuk digitalisasi UMKM Jasa (studi kasus: WPA Cleaning Service), dibangun menggunakan **Laravel Livewire + Alpine.js + Tailwind CSS**. Ada 4 role utama: **Customer, Admin UMKM, Worker, dan Superadmin.**

Secara keseluruhan, proyek sudah berjalan dan punya alur bisnis yang cukup lengkap. Namun masih ada beberapa celah fungsional, bug kecil, dan hal-hal yang perlu dipoles sebelum proyek ini bisa dianggap benar-benar "selesai".

---

## 🐛 Bug & Masalah yang Ditemukan

### ~~1. `dd()` Tertinggal di Kode Produksi~~ ✅ SELESAI
- **Fix**: Sudah menghapus baris `dd('masuk sini')` di `VerifyEmailController.php`.

### ~~2. Worker Routes Tidak Ada Middleware Role~~ ✅ SELESAI
- **Fix**: Sudah ditambahkan `role:worker` ke grup middleware di `routes/worker.php`.

### ~~3. Invoice Number Masih Kosong di Database~~ ✅ SELESAI
- **Fix**: Sudah ditambahkan auto-generate `invoice_number` di event `static::creating()` di `Order.php` dan seluruh data lama yang null sudah di-backfill dengan format `INV-YYYYMM-XXXXX`.

### ~~4. Verifikasi Email Tidak Bisa Diakses (Karena Bug `dd()` di Atas)~~ ✅ SELESAI
- **Fix**: Dilakukan sedikit penyesuaian agar alur registrasi hingga verifikasi email dapat berjalan sukses dan me-redirect ke dashboard dengan benar.

### ~~5. File Sampah di Root Project~~ ✅ SELESAI
- **Fix**: File debug/temporary di root (`backfill_logs.php`, `check_db.php`, `extract.php`, `extract.py`, `fix_order.php`, `restore.py`, `restore_templates.ps1`, `update_images.php`, `update_logs.php`, `temp_register.txt`, `toArray()`) sudah dihapus agar rapi. Mereka tidak boleh ada di repositori produksi.

---

## ✨ Fitur yang Belum Lengkap / Perlu Diselesaikan

### 6. Order Chat (Negosiasi) — Fitur Inti Belum Dipoles
- File `resources/views/livewire/order-chat.blade.php` berukuran 19KB dan ada `OrderChat.php` sebagai komponen terpisah.
- Perlu dicek apakah alur negosiasi (Customer mengirim pesan → Admin membalas → Admin kirim *formal proposal* → Customer setuju/tolak harga) sudah berjalan mulus dari ujung ke ujung.
- **Action**: Lakukan end-to-end testing manual satu kali penuh dari order masuk hingga pembayaran selesai.

### 7. Worker: Checklist Tugas Masih Hard-coded
- Di `app/Livewire/Worker/Tasks.php` baris 51-56, checklist tugas worker (Persiapan alat, Briefing customer, dll.) masih di-*hardcode* langsung di PHP.
- **Idealnya**: Checklist ini seharusnya bisa dikelola admin atau diambil dari data order/produk agar relevan dengan layanan yang dikerjakan.

### 8. Worker: Tidak Ada Pagination di Kalender
- Di `Worker/Index.php`, kalender mengeksekusi query database **per hari** di dalam loop `while`, yang bisa jadi sangat lambat untuk bulan yang panjang (30+ iterasi query).
- **Fix**: Ambil semua data assignment dalam satu query untuk rentang tanggal, lalu kelompokkan di PHP.

### 9. Customer: Foto Hasil Kerja Masih Pakai URL Unsplash sebagai Fallback
- Di `Customer/Order/Show.php` baris 47-51, kalau tidak ada foto hasil kerja, halaman menampilkan foto-foto acak dari Unsplash (bukan milik proyek).
- **Fix**: Ganti dengan placeholder lokal atau tampilkan pesan "Belum ada foto hasil kerja".

### 10. Superadmin: Export Laporan PDF Masih Berupa HTML Polos
- Di `SuperAdmin/ReportManagement.php` baris 83-101, PDF yang di-generate hanya HTML mentah tanpa styling.
- **Fix**: Buat template Blade khusus untuk PDF (`resources/views/pdf/report.blade.php`) dengan tampilan yang lebih rapi.

### 11. Admin UMKM: Tidak Ada Fitur Export di Halaman Report
- Halaman Report di `/umkm/reports` hanya menampilkan data, tapi tidak ada tombol **Export CSV/PDF** seperti yang dimiliki Superadmin.
- **Action**: Tambahkan fungsi export (setidaknya CSV) ke `AdminUmkm/Reports/Index.php`.

### 12. Rating/Ulasan Customer Belum Terintegrasi ke Tampilan Partner
- Di `Customer/Partner/Index.php`, rating UMKM sudah dihitung dari `OrderReview`. Namun perlu dipastikan form ulasan (`Customer/Order/Review.php`) sudah bisa diakses dan berfungsi setelah order selesai.
- **Action**: Test alur pemberian ulasan dari Customer pasca order `completed`.

---

## 🎨 Penyempurnaan UI/UX

### 13. Landing Page — Masih Menggunakan Logo Placeholder (Logoipsum)
- `Landing.php` baris 30-31 mengganti logo UMKM asli dengan logo dari `logoipsum` (URL statis eksternal).
- Landing page adalah kesan pertama. Idealnya gunakan logo asli UMKM atau buat sistem placeholder yang lebih elegan.

### 14. Halaman Customer Dashboard — Potensi Tampilan Kosong
- Jika customer baru login dan belum punya order, perlu dipastikan ada *empty state* yang menarik dan informatif (bukan halaman kosong).

### 15. Responsivitas Mobile
- Sesuai blueprint proyek, pengujian *mobile-friendly* adalah target utama.
- **Action**: Lakukan pengecekan tampilan di layar kecil (≤ 375px) untuk semua halaman utama: Customer Dashboard, Order Detail, Worker Tasks, Admin Report.

### 16. Notifikasi — Belum Ada Indikator Real-time
- Sistem notifikasi sudah ada (`UserNotification` model, halaman `/notifications`). Tapi badge notifikasi di navbar kemungkinan tidak ter-update secara real-time tanpa reload.
- **Action**: Tambahkan Livewire polling ringan (misalnya `wire:poll.10s`) pada komponen badge notifikasi di navbar.

---

## 🧹 Kebersihan Kode (Code Quality)

### 17. N+1 Query Problem di Worker Calendar
- Seperti disebut di poin #8, ada potensi N+1 query di loop kalender worker.

### 18. `protected $guarded = ['id']` di Model Order & Umkm
- Menggunakan `$guarded` alih-alih `$fillable` yang eksplisit kurang aman.
- **Action (opsional)**: Pertimbangkan migrasi ke `$fillable` untuk keamanan yang lebih ketat.

### 19. SuperAdmin UMKM Bulk Delete Tidak Hapus Semua Relasi
- Di `UmkmManagement.php` fungsi `bulkDelete()`, hanya `Order`, `Product`, dan `UmkmDetail` yang dihapus. Relasi seperti `UmkmWorker`, `UmkmSchedule`, `CreditLog`, `BankAccount` tidak ikut dihapus — berpotensi menyisakan data orphan di database.
- **Fix**: Perlengkap query delete untuk semua tabel yang berelasi dengan UMKM.

---

## 📋 Prioritas Pengerjaan (Saran Urutan)

| Prioritas | Item | Estimasi |
|-----------|------|----------|
| 🔴 **Kritis** | Bug #1: Hapus `dd()` di VerifyEmailController | 5 menit |
| 🔴 **Kritis** | Bug #2: Tambah middleware `role:worker` | 5 menit |
| 🔴 **Kritis** | Bug #5: Bersihkan file sampah di root project | 10 menit |
| 🟠 **Penting** | Fitur #6: End-to-end test alur order & negosiasi | 1-2 jam |
| 🟠 **Penting** | Fitur #12: Test alur ulasan customer | 30 menit |
| 🟠 **Penting** | Bug #3: Auto-generate invoice_number saat order dibuat | 30 menit |
| 🟡 **Sedang** | Fitur #11: Export CSV di Report Admin UMKM | 1 jam |
| 🟡 **Sedang** | Bug #9: Ganti fallback foto Unsplash dengan placeholder lokal | 15 menit |
| 🟡 **Sedang** | UI #15: Cek responsivitas mobile semua halaman | 2-3 jam |
| 🟡 **Sedang** | UI #16: Polling badge notifikasi | 30 menit |
| 🟢 **Opsional** | Bug #8: Optimasi N+1 query kalender worker | 45 menit |
| 🟢 **Opsional** | Fitur #10: Template PDF yang lebih rapi | 1 jam |
| 🟢 **Opsional** | Bug #19: Perlengkap bulk delete SuperAdmin | 30 menit |
| 🟢 **Opsional** | UI #13: Ganti logo placeholder di Landing Page | 30 menit |

---

## 📝 Catatan untuk Laporan KP (Kerja Praktek)

Berdasarkan *blueprint* proyek, proyek ini adalah tugas Kerja Praktek. Berikut hal-hal yang perlu disiapkan selain kode:

1. **Flowchart Sistem**: Blueprint menyebut ini belum dibuat. Perlu dibuat flowchart untuk 4 alur user (Customer, Admin UMKM, Worker, Superadmin) untuk keperluan Bab 3/4 laporan.
2. **Screenshot Lengkap**: Dokumentasikan setiap halaman yang sudah selesai untuk lampiran laporan.
3. **Testing**: Buat tabel uji fungsional (Tabel Pengujian Black-Box) yang mencakup semua fitur utama dan hasilnya.
