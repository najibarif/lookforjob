# LookForJob - Job Finder Platform

LookForJob adalah platform pencarian kerja modern dan terintegrasi yang dibangun menggunakan **Laravel 11**, **Tailwind CSS**, dan arsitektur *Service-Oriented*. Aplikasi ini memudahkan pencari kerja untuk menemukan lowongan terbaik dari berbagai sumber secara terpusat, dengan antarmuka (UI) gaya SaaS 2026 yang premium, responsif, dan *user-friendly*.

## Fitur Utama

- **Agregator Lowongan Terpusat**: Terintegrasi langsung dengan API eksternal (seperti LinkedIn, Remotive, dan ArbeitNow) untuk menyajikan ribuan data lowongan secara *real-time*.
- **Modern UI/UX**: Desain bergaya SaaS 2026 yang dioptimalkan dengan *Tailwind CSS* (palet Emerald), efek *glassmorphism*, dan animasi yang halus.
- **Pencarian & Filter Cerdas**: Pencarian berdasarkan kata kunci (keyword), lokasi, sistem kerja (Remote/Full Time), dan tingkat pengalaman kerja.
- **Console Command Otomatis**: Fitur CLI `jobs:fetch` bagi *developer* atau *Cron Job* untuk melakukan *fetching* data lowongan dari berbagai API ke database secara berkala dengan mudah.
- **Integrasi API**: Menyediakan *REST API Endpoint* yang siap digunakan oleh klien (mobile, web app lain) untuk mengambil data pekerjaan dan memproses API AI.
- **AI CV Builder**: Terhubung dengan layanan Cohere AI untuk menghasilkan rangkuman profil LinkedIn, pembuatan CV cerdas, serta Saran Perbaikan berdasarkan kriteria pekerjaan.

## Tech Stack & Best Practices

- **Backend**: Laravel 11.x, PHP 8.2+
- **Frontend**: Blade Templating, Tailwind CSS v3, Alpine.js, Lucide Icons
- **Database**: MySQL / MariaDB
- **Arsitektur Kode (Best Practice)**: Menerapkan pola *Service Pattern* (contoh: `JobAggregatorService`, `LinkedInService`, `CohereService`) untuk memisahkan logika bisnis yang kompleks dari Controller agar kode lebih modular, mudah di-test, dan mudah di-maintain.
- **Asset Bundler**: Vite (untuk kompilasi instan Tailwind CSS dan build production yang sangat ringan)
- **Clean Codebase**: Repositori telah dibersihkan dari *file views* bawaan yang tidak terpakai seperti `welcome.blade.php` atau layout *dashboard* default sehingga aplikasi lebih rapi.

## Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di *local environment* Anda:

1. **Clone repository:**
   ```bash
   git clone https://github.com/username/LookForJob.git
   cd LookForJob
   ```

2. **Install dependensi PHP & Node.js:**
   ```bash
   composer install
   npm install
   ```

3. **Salin file environment & konfigurasi:**
   ```bash
   cp .env.example .env
   ```

4. **Konfigurasi Database & API Keys (di `.env`):**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lookforjob
   DB_USERNAME=root
   DB_PASSWORD=

   # Konfigurasi API Eksternal
   RAPIDAPI_KEY=your_rapid_api_key_here
   COHERE_API_KEY=your_cohere_api_key_here
   ```

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database:**
   ```bash
   php artisan migrate
   ```

7. **Compile Asset Frontend (Wajib):**
   ```bash
   npm run build
   # atau untuk mode development live-reload: npm run dev
   ```

8. **Jalankan Local Server:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses di browser melalui `http://127.0.0.1:8000`

## Manajemen Data Lowongan (Khusus Developer)

Sebagai alternatif dan metode paling optimal untuk manajemen database, Anda dapat mengambil data terbaru dari berbagai API secara massal menggunakan *Artisan Console Command* yang telah disediakan secara khusus untuk memudahkan proses simpan-otomatis (*updateOrCreate*).

```bash
# Mengambil lowongan (default keyword: developer, semua lokasi)
php artisan jobs:fetch

# Mengambil lowongan dengan spesifikasi (keyword, lokasi)
php artisan jobs:fetch "laravel" "jakarta"
```
Praktik Terbaik (*Best Practice*): Anda dapat menjadwalkan perintah ini di dalam file penjadwalan Laravel (`routes/console.php` untuk Laravel 11) menggunakan metode cron job standar untuk memperbarui lowongan setiap hari secara otomatis di latar belakang server.

## Struktur API Endpoints (Referensi)

- `GET /api/jobs` - Mengambil data lowongan dari database atau trigger sinkronisasi API.
- `GET /api/linkedin-profile` - Mengambil profil LinkedIn kandidat berdasarkan *username*.
- `POST /api/generate-cv` - Memproses AI CV Generator.

---
*Proyek LookForJob dikembangkan dengan standar "Clean Architecture", memprioritaskan skalabilitas komponen, modularitas Service, serta berfokus kepada UI/UX premium masa depan.*
