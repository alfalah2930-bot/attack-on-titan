# ⚔ Attack On Titan — Website Portal

Website portal informasi Attack on Titan (Shingeki no Kyojin) dengan sistem login, dashboard admin, dan manajemen konten lengkap.

---

## Fitur

- Halaman publik: Beranda, Sejarah, Kreator, Season, Karakter
- Sistem autentikasi: Login, Register, Logout
- Dashboard admin dengan sidebar modern
- CRUD: Season, Karakter, Kreator, Homepage
- Manajemen user & role (admin/user)
- Upload gambar dengan validasi keamanan
- Desain dark theme Attack on Titan
- Responsif untuk mobile, tablet, desktop

---

## Teknologi

| Layer | Teknologi |
|-------|-----------|
| Frontend | HTML5, CSS3, JavaScript ES6 |
| Backend | PHP Native (tanpa framework) |
| Database | MySQL via PDO |
| Server | Apache (XAMPP) |
| Font | Cinzel Decorative, Lato |
| Icons | Font Awesome 6 |

---

## Instalasi di XAMPP

### 1. Download & Install XAMPP
Download di [apachefriends.org](https://www.apachefriends.org/) dan install.

### 2. Copy Folder Project
Salin folder `attack-on-titan/` ke:
```
C:\xampp\htdocs\attack-on-titan\
```

### 3. Start XAMPP
Buka XAMPP Control Panel → klik **Start** pada Apache dan MySQL.

### 4. Import Database
1. Buka browser → `http://localhost/phpmyadmin`
2. Klik **New** → buat database: `aot_website`
3. Klik database `aot_website` → tab **Import**
4. Pilih file `sql/aot_website.sql` → klik **Go**

### 5. Konfigurasi Database
Edit file `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'aot_website');
define('DB_USER', 'root');    // sesuaikan
define('DB_PASS', '');        // kosong untuk XAMPP default
define('SITE_URL', 'http://localhost/attack-on-titan');
```

### 6. Buka Website
```
http://localhost/attack-on-titan/
```

### 7. Update Password Admin
Jalankan perintah ini di phpMyAdmin (SQL tab):
```sql
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE username = 'admin';
```
> Password di atas adalah hash untuk `password`. Ganti dengan hash baru:
> ```php
> echo password_hash('admin123', PASSWORD_DEFAULT);
> ```

---

## Akun Default

| Username | Password | Role |
|----------|----------|------|
| admin | admin123 | Admin |
| user1 | password | User |

> **Penting:** Ganti password setelah instalasi!

---

## Struktur Folder

```
attack-on-titan/
├── admin/
│   ├── includes/
│   │   ├── header.php
│   │   └── footer.php
│   ├── index.php          # Dashboard
│   ├── seasons.php        # CRUD Season
│   ├── characters.php     # CRUD Karakter
│   ├── creator.php        # Edit Kreator
│   ├── homepage.php       # Edit Homepage
│   └── users.php          # Kelola User
├── assets/
│   ├── css/
│   │   ├── style.css      # Main stylesheet
│   │   └── admin.css      # Admin stylesheet
│   ├── js/
│   │   └── main.js
│   └── images/            # Gambar statis
├── config/
│   └── database.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── functions.php
├── uploads/               # Gambar upload admin
│   ├── seasons/
│   ├── characters/
│   ├── creator/
│   └── homepage/
├── sql/
│   └── aot_website.sql
├── index.php
├── history.php
├── creator.php
├── seasons.php
├── season_detail.php
├── characters.php
├── login.php
├── register.php
├── logout.php
└── README.md
```

---

## Upload ke GitHub

```bash
git init
git add .
git commit -m "Initial commit: AOT Website"
git remote add origin https://github.com/username/attack-on-titan.git
git push -u origin main
```

> Tambahkan `.gitignore` untuk mengabaikan folder `uploads/`:
> ```
> uploads/*
> !uploads/.gitkeep
> ```

---

## Lisensi

Proyek ini dibuat untuk keperluan **portofolio dan edukasi**.  
Attack on Titan & semua karakter adalah hak milik **Hajime Isayama / Kodansha**.  
Gambar karakter tidak disertakan — tambahkan sendiri di folder `uploads/`.
