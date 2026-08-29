# Properindo Enviro Tech --- Employee & Task Management System

Prototype aplikasi internal perusahaan berbasis **Laravel** yang
dikembangkan untuk membantu pengelolaan **data karyawan, struktur
organisasi, dan monitoring tugas karyawan dalam satu sistem
terintegrasi**.

Project ini dikembangkan sebagai bagian dari **Technical Test / Seleksi
IT Staff PT. Properindo Enviro Tech**.

Aplikasi menerapkan **Role-Based Access Control (RBAC)** sehingga setiap
pengguna memperoleh akses dan fungsi yang berbeda berdasarkan role dan
lingkup departemennya.

---

## Tentang Project

Properindo Enviro Tech Employee & Task Management System dirancang untuk
membantu perusahaan dalam:

- Mengelola data karyawan.
- Mengelola departemen dan posisi.
- Mengatur role pengguna.
- Membuat dan mendistribusikan tugas.
- Memantau progress pekerjaan.
- Memantau deadline tugas.
- Menyimpan riwayat perubahan data.
- Membatasi akses berdasarkan departemen dan role.
- Menyediakan dashboard monitoring sesuai level pengguna.

---

## Demo Application

Demo aplikasi dapat diakses melalui:

**https://handikafadli.my.id**

> Demo digunakan untuk kebutuhan showcase prototype aplikasi.

---

## Demo Account

Role Email Password

---

Admin `handika@properindoenviro.co.id` `password`
Manager `lukman@properindoenviro.co.id` `password`
Supervisor `maya@properindoenviro.co.id` `password`
Staff `budi@properindoenviro.co.id` `password`

> **Catatan:** Credential di atas hanya digunakan untuk environment demo
> dan bukan credential production.

---

## Role & Access Control

Aplikasi memiliki **4 level pengguna**, yaitu Admin, Manager,
Supervisor, dan Staff.

### 1. Admin

Admin memiliki tingkat akses tertinggi dan dapat memantau serta
mengelola data operasional perusahaan lintas departemen.

Fitur utama:

- Dashboard perusahaan.
- Master Departemen.
- Master Posisi.
- Master Role.
- Master Status Tugas.
- Master Prioritas Tugas.
- Daftar seluruh karyawan.
- Tambah, detail, edit, dan hapus karyawan.
- Filter dan pencarian data.
- Export data karyawan.

Admin memiliki visibilitas penuh terhadap data karyawan di seluruh
departemen perusahaan.

### 2. Manager

Manager berfungsi sebagai pengawas pada level departemen dan hanya dapat
mengelola data sesuai lingkup departemennya.

Fitur utama:

- Dashboard departemen.
- Monitoring anggota departemen.
- Daftar karyawan departemen.
- Detail dan edit karyawan sesuai kewenangan.
- Monitoring tugas.
- Filter tugas.
- Membuat tugas.
- Menentukan PIC.
- Menentukan prioritas.
- Menentukan deadline.

PIC yang dapat dipilih dibatasi pada karyawan dalam lingkup departemen
terkait.

### 3. Supervisor

Supervisor melakukan monitoring terhadap anggota tim serta pekerjaan
dalam departemennya.

Fitur utama:

- Dashboard departemen.
- Statistik anggota tim.
- Progress penyelesaian tugas.
- Monitoring deadline.
- Daftar tugas terbaru.
- Daftar karyawan departemen.
- Detail dan edit karyawan sesuai kewenangan.
- Monitoring tugas.
- Membuat tugas.
- Menentukan PIC, prioritas, dan deadline.
- Filter pekerjaan.

### 4. Staff

Staff memiliki ruang kerja personal dan hanya dapat mengakses serta
mengelola tugas yang secara spesifik diberikan kepadanya.

Fitur utama:

- Dashboard personal.
- Daftar tugas pribadi.
- Monitoring deadline.
- Filter tugas.
- Detail tugas.
- Melihat prioritas pekerjaan.
- Memperbarui status pengerjaan.
- Melihat riwayat perubahan status tugas.

Alur status dasar tugas:

```text
Belum Dimulai
      ↓
Sedang Dikerjakan
      ↓
Selesai
```

---

## Modul Aplikasi

### Dashboard

Dashboard menampilkan informasi yang disesuaikan berdasarkan role
pengguna, antara lain:

- Jumlah karyawan.
- Total tugas.
- Tugas belum dimulai.
- Tugas sedang dikerjakan.
- Tugas selesai.
- Tugas terlambat.
- Progress penyelesaian tugas.
- Deadline terdekat.
- Tugas terbaru.

### Master Data

Master Data menjadi pusat konfigurasi dasar sistem dan dikelola oleh
pengguna dengan hak akses yang sesuai.

Data master meliputi:

- Department.
- Position.
- Role.
- Task Status.
- Task Priority.

### Employee Management

Modul Employee Management digunakan untuk mengelola data karyawan.

Informasi utama karyawan meliputi:

- Employee Code.
- Name.
- Email.
- Department.
- Position.
- Role.
- Status.

Fitur yang tersedia meliputi pencarian, filter departemen, filter
posisi, filter status, tambah karyawan, edit, detail, hapus, dan export
data.

### Employee Detail & History

Halaman detail karyawan menampilkan:

- Informasi profil.
- Departemen.
- Posisi.
- Status karyawan.
- Informasi sistem.
- Waktu pembuatan data.
- Waktu perubahan terakhir.
- History perubahan.

History perubahan berfungsi sebagai **audit trail** untuk membantu
melacak perubahan data karyawan.

---

## Task Management

Task Management merupakan modul utama untuk proses assignment dan
monitoring pekerjaan.

Informasi tugas meliputi:

- Task Code.
- Title.
- Description.
- PIC.
- Priority.
- Status.
- Deadline.
- Created At.
- Updated At.

### Membuat Tugas

Manager dan Supervisor dapat melakukan assignment pekerjaan kepada
karyawan dalam lingkup departemennya.

Form tugas mencakup:

- PIC.
- Prioritas.
- Deadline.
- Judul Tugas.
- Deskripsi.

Sistem membatasi pemilihan PIC agar hanya berasal dari departemen yang
sesuai.

### Monitoring Tugas

Halaman Monitoring Tugas menyediakan ringkasan:

- Total Task.
- Belum Dimulai.
- Sedang Dikerjakan.
- Selesai.
- Terlambat.

Daftar tugas dapat difilter berdasarkan:

- Keyword.
- PIC.
- Status.
- Prioritas.
- Deadline mulai.
- Deadline akhir.

---

## Task Workflow

```text
Manager / Supervisor
        │
        ▼
    Membuat Task
        │
        ▼
  Menentukan PIC
        │
        ▼
       Staff
        │
        ▼
   Belum Dimulai
        │
        ▼
 Sedang Dikerjakan
        │
        ▼
      Selesai
```

Setiap perubahan status dapat dicatat sehingga histori pengerjaan tugas
dapat ditelusuri.

---

## Authorization

Aplikasi menerapkan authorization berdasarkan kombinasi:

```text
Role
+
Department
+
Ownership / Assignment
```

Ringkasan akses:

---

Aktivitas Admin Manager Supervisor Staff

---

Master Data ✅ ❌ ❌ ❌

Melihat ✅ ❌ ❌ ❌
Semua  
 Karyawan

Melihat ✅ ✅ ✅ ❌
Karyawan  
 Departemen

Mengelola ✅ Sesuai akses Sesuai akses ❌
Karyawan

Monitoring ✅ ✅ ✅ Tugas sendiri
Tugas

Membuat Sesuai akses ✅ ✅ ❌
Tugas

Update Sesuai akses Sesuai akses Sesuai akses Tugas sendiri
Status Tugas

---

---

## Technology Stack

Project menggunakan ekosistem Laravel.

- **Backend:** Laravel / PHP
- **Frontend:** Blade Template
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **ORM:** Laravel Eloquent
- **Authentication:** Laravel Authentication
- **Authorization:** Policy / Role-Based Access Control

> Versi Laravel, PHP, Node.js, dan dependency lainnya dapat dilihat pada
> `composer.json` dan `package.json`.

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/REPOSITORY.git
cd REPOSITORY
```

Ganti `USERNAME/REPOSITORY` dengan alamat repository GitHub project.

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Environment Configuration

Linux/macOS:

```bash
cp .env.example .env
```

Windows:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Database Configuration

Buat database MySQL, kemudian sesuaikan `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=properindo_enviro
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

Untuk development, jika ingin membangun ulang seluruh database beserta
seed:

```bash
php artisan migrate:fresh --seed
```

> **Peringatan:** `migrate:fresh` akan menghapus seluruh tabel pada
> database yang digunakan.

### 6. Install Frontend Dependencies

```bash
npm install
```

Development:

```bash
npm run dev
```

Production build:

```bash
npm run build
```

### 7. Storage Link

Jika diperlukan:

```bash
php artisan storage:link
```

### 8. Run Application

```bash
php artisan serve
```

Akses aplikasi melalui:

```text
http://127.0.0.1:8000
```

---

## Database Seeder

Seeder development/demo dapat digunakan untuk menghasilkan data seperti:

- Role.
- Department.
- Position.
- Employee.
- User.
- Task Status.
- Task Priority.
- Demo Account.

Jalankan:

```bash
php artisan migrate:fresh --seed
```

---

## Notification

Sistem dapat memberikan notifikasi kepada pengguna terkait aktivitas
tugas.

Contoh notifikasi:

- Task baru diberikan.
- Deadline mendekati batas waktu.
- Task diperbarui.
- Status task berubah.

Notifikasi dapat disimpan pada database aplikasi sehingga pengguna dapat
melihat histori notifikasi.

---

## Future Development / Roadmap

### Task Attachment

Menambahkan kemampuan bagi Staff untuk mengunggah dokumen, laporan, atau
bukti hasil pengerjaan pada tugas.

### Task Discussion

Menyediakan kolom komentar atau diskusi per tugas agar Staff,
Supervisor, dan Manager dapat berkomunikasi langsung terkait pekerjaan.

### Review & Approval Workflow

Roadmap workflow:

```text
Staff Selesai Mengerjakan
          │
          ▼
       In Review
          │
      ┌───┴────┐
      ▼        ▼
   Revised   Approved
      │
      ▼
Staff Memperbaiki
```

Status tambahan yang direncanakan:

- `In Review`
- `Revised`
- `Approved`

### Employee Legal Information

Pengembangan data administrasi karyawan dapat mencakup:

- NIK.
- NPWP.
- BPJS Kesehatan.
- BPJS Ketenagakerjaan.
- Nomor Rekening.

### Employee Document Repository

Penyimpanan dokumen digital karyawan seperti:

- KTP.
- Ijazah.
- Sertifikat.
- Kontrak Kerja PKWT/PKWTT.
- Pakta Integritas.

---

## Developer

**Mohamad Handika**

Project dikembangkan sebagai bagian dari **Technical Test IT Staff ---
PT. Properindo Enviro Tech**.

---

## License

Project ini dibuat untuk kebutuhan **technical assessment / portfolio**.

Penggunaan atau pengembangan lebih lanjut dapat disesuaikan dengan
kebijakan pemilik project.
