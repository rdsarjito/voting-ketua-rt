<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Voting Ketua RT - Laravel + Blade + PostgreSQL

Sistem voting online untuk pemilihan ketua RT yang transparan dan demokratis.

### Persyaratan
- PHP 8.2+ (✅ Terdeteksi: PHP 8.3.28)
- Composer (✅ Terdeteksi: Composer 2.8.12)
- Node.js 18+ (✅ Terdeteksi: Node.js v24.8.0)
- Database: PostgreSQL 14+ (via Docker) atau SQLite (default)

---

## 🚀 Cara Menjalankan Project

### Opsi 1: Setup Baru (First Time)

Jika ini pertama kali menjalankan project:

```bash
# 1. Install dependencies PHP
composer install

# 2. Install dependencies Node.js
npm install

# 3. Build assets frontend
npm run build

# 4. Generate application key (jika belum ada)
php artisan key:generate

# 5. Setup database
# Opsi A: Gunakan SQLite (paling mudah, tidak perlu setup database)
# Pastikan file database/database.sqlite sudah ada

# Opsi B: Gunakan PostgreSQL via Docker
docker compose up -d

# 6. Jalankan migration dan seed data
php artisan migrate --seed

# 7. Buat symbolic link untuk storage
php artisan storage:link

# 8. Jalankan development server
php artisan serve
```

**Akses aplikasi:** http://localhost:8000

**Credensial Admin:**
- Email: `admin@example.com`
- Password: `admin123`

---

### Opsi 2: Menjalankan Kembali (Sudah Setup)

Jika project sudah pernah di-setup sebelumnya:

```bash
# 1. Pastikan database berjalan (jika pakai PostgreSQL)
docker compose up -d

# 2. Jalankan server Laravel
php artisan serve
```

**Akses aplikasi:** http://localhost:8000

---

### Opsi 3: Development Mode (dengan Hot Reload)

Untuk development dengan auto-reload CSS/JS:

```bash
# Terminal 1: Jalankan Laravel server
php artisan serve

# Terminal 2: Jalankan Vite dev server (hot reload)
npm run dev
```

Atau gunakan script composer yang sudah tersedia:

```bash
composer dev
```

Ini akan menjalankan:
- Laravel server (port 8000)
- Queue worker
- Laravel Pail (logs)
- Vite dev server (hot reload)

---

### Konfigurasi Database

#### Menggunakan SQLite (Default - Paling Mudah)

File `.env` sudah dikonfigurasi untuk SQLite:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

Atau cukup pastikan file `database/database.sqlite` ada.

#### Menggunakan PostgreSQL

1. Edit file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=voting_ketua_rt
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

2. Jalankan PostgreSQL via Docker:
```bash
docker compose up -d
```

3. Jalankan migration:
```bash
php artisan migrate --seed
```

---

### Troubleshooting

**Error: "No application encryption key has been specified"**
```bash
php artisan key:generate
```

**Error: "SQLSTATE[HY000] [2002] Connection refused" (PostgreSQL)**
```bash
# Pastikan PostgreSQL berjalan
docker compose up -d

# Atau cek status
docker compose ps
```

**Error: "Class 'Vite' not found" atau CSS/JS tidak muncul**
```bash
npm install
npm run build
# atau untuk development
npm run dev
```

**Error: "The stream or file could not be opened" (storage)**
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

**Port 8000 sudah digunakan**
```bash
# Gunakan port lain
php artisan serve --port=8001
```

---

### Fitur Utama

### Workflow Git
- Repo sudah di-inisialisasi dengan cabang `main` dan remote `origin` ke GitHub.
- Setiap kali `git commit`, hook `post-commit` otomatis menjalankan `git push -u origin <current-branch>`.
- Langkah umum:
  - `git add -A`
  - `git commit -m "feat: perubahan ..."`
  - (auto push berjalan)

### Fitur Utama
- Admin: CRUD kategori, CRUD kandidat (upload foto), lihat hasil voting (Chart.js)
- User: Register/Login, lihat kategori, pilih kandidat (1x per kategori), lihat detail kandidat, **bandingkan kandidat per kategori**
- Middleware role `role:admin` membatasi akses admin

#### Candidate Comparison
- Halaman `Bandingkan Kandidat` menampilkan highlight kandidat teratas, total suara, dan tabel perbandingan lengkap (visi, misi, total vote, persentase).
- Tombol aksi baru pada halaman kategori memudahkan pemilih berpindah ke tampilan perbandingan sebelum menentukan pilihan.

### Struktur DB
- users: id, name, email, password, role
- categories: id, name
- candidates: id, name, photo, vision, mission, category_id
- votes: id, user_id, candidate_id, category_id, timestamps; unique(user_id, category_id)


Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
