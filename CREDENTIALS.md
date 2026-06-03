# 🔐 Kredensial Akun SIMO — HIMAPROSIF

> **Dokumen ini bersifat RAHASIA. Jangan disebarkan ke publik.**
> Simpan file ini di tempat yang aman.

---

## 🌐 Alamat Aplikasi

| Environment | URL |
|---|---|
| Lokal (Laragon) | `http://localhost/simo` |
| Login | `http://localhost/simo/login` |
| Register | `http://localhost/simo/register` |

---

## 👤 Akun Default

### 🛡️ Admin (Hak Akses Penuh — CRUD)

| Field | Nilai |
|---|---|
| **Username** | `admin` |
| **Password** | `admin123` |
| **Role** | `admin` |
| **Kemampuan** | Tambah, Ubah, Hapus semua data; akses Import & PatchData |

### 👁️ User (Hak Akses Read-Only)

| Field | Nilai |
|---|---|
| **Username** | `user` |
| **Password** | `user123` |
| **Role** | `user` |
| **Kemampuan** | Lihat semua data, cetak laporan, akses pengaturan profil |

---

## 📋 Perbedaan Hak Akses

| Fitur | Admin | User |
|---|:---:|:---:|
| Lihat Dashboard | ✅ | ✅ |
| Lihat Anggota | ✅ | ✅ |
| Tambah/Ubah/Hapus Anggota | ✅ | ❌ |
| Lihat Departemen & Jabatan | ✅ | ✅ |
| Tambah/Ubah/Hapus Dept & Jabatan | ✅ | ❌ |
| Lihat Periode | ✅ | ✅ |
| Kelola Periode (aktifkan, dll.) | ✅ | ❌ |
| Lihat Struktur Kepengurusan | ✅ | ✅ |
| Plot / Ubah / Hapus Struktur | ✅ | ❌ |
| Lihat Program Kerja | ✅ | ✅ |
| Tambah/Ubah/Hapus Proker | ✅ | ❌ |
| Lihat Partisipan | ✅ | ✅ |
| Tambah/Ubah/Hapus Partisipan | ✅ | ❌ |
| Laporan (SK, Katalog, Rapor) | ✅ | ✅ |
| Pengaturan Profil & Tema | ✅ | ✅ |
| Import Data & PatchData | ✅ | ❌ |
| Registrasi Akun Baru | Otomatis `user` | Otomatis `user` |

---

## 🔑 Cara Membuat Akun Admin Baru

Untuk mengangkat akun `user` menjadi `admin`, jalankan perintah SQL berikut di phpMyAdmin:

```sql
UPDATE users SET role = 'admin' WHERE username = 'nama_user_disini';
```

Atau tambahkan akun admin baru langsung:

```sql
INSERT INTO users (username, password, role)
VALUES ('nama_admin', '$2y$...hashed_password...', 'admin');
```

> **Catatan:** Password harus di-hash menggunakan `password_hash()` PHP.  
> Gunakan skrip berikut untuk generate hash:
> ```php
> echo password_hash('passwordkamu', PASSWORD_BCRYPT);
> ```

---

## 🗄️ Database

| Field | Nilai |
|---|---|
| Host | `localhost` |
| Database | `himaprosif` |
| User | `root` |
| Password | *(kosong/default Laragon)* |
| Tabel akun | `users` |

---

## ⚠️ Catatan Keamanan

- Ubah password default **segera setelah pertama kali deploy**
- Jangan commit file ini ke repository publik (git)
- Tambahkan `CREDENTIALS.md` ke `.gitignore` jika perlu

---

*Dibuat otomatis oleh SIMO Setup — <?= date('Y') ?>*
