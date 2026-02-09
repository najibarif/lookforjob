<div align="center">

# 🎯 LookForJob

### Temukan Pekerjaan Impianmu dengan Bantuan AI

[![React](https://img.shields.io/badge/React-18.3.1-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://reactjs.org/)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.5.3-3178C6?style=for-the-badge&logo=typescript&logoColor=white)](https://www.typescriptlang.org/)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4.1-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](LICENSE)

[Demo](#) • [Dokumentasi](#dokumentasi-api) • [Lapor Bug](https://github.com/najibarif/lookforjob/issues)

![LookForJob Banner](https://via.placeholder.com/1200x400/6366f1/ffffff?text=LookForJob+-+AI-Powered+Job+Portal)

</div>

---

## ✨ Tentang Project

**LookForJob** adalah platform pencarian kerja modern yang memanfaatkan kekuatan **Artificial Intelligence** untuk membantu pencari kerja menemukan peluang karier yang sempurna. Platform ini menggabungkan **React + TypeScript** di frontend dan **Laravel 11** di backend untuk memberikan pengalaman yang cepat, responsif, dan intuitif.

### 🎯 Fitur Utama

<table>
<tr>
<td width="50%">

#### 🤖 **AI-Powered Features**
- 🎨 **CV Generator dengan AI** - Buat CV profesional otomatis
- 🔍 **Job Matching Cerdas** - Rekomendasi pekerjaan berbasis skill
- 💬 **Career Assistant** - Chat dengan AI untuk saran karier
- 📊 **CV Analysis** - Analisis dan kritik CV secara otomatis

</td>
<td width="50%">

#### 💼 **Core Features**
- 🔐 **Authentication System** - Login/Register yang aman
- 👤 **User Profile Management** - Kelola profil lengkap
- 📋 **Job Listings** - Browse ribuan lowongan kerja
- 🎓 **Education & Experience Tracker** - Riwayat pendidikan & pengalaman

</td>
</tr>
</table>

---

## 🚀 Tech Stack

### Frontend
- ⚛️ **React 18.3** - UI Library
- 🔷 **TypeScript** - Type-safe JavaScript
- 🎨 **Tailwind CSS** - Utility-first CSS framework
- 🎭 **Framer Motion** - Advanced animations
- 📡 **Axios** - HTTP client
- 🔄 **React Router DOM** - Client-side routing
- 📝 **React Hook Form + Yup** - Form validation
- 🎯 **Lucide React** - Beautiful icons

### Backend (Laravel 11)
- 🐘 **PHP 8.2+** - Modern PHP
- 🎯 **Laravel 11** - PHP Framework
- 🗄️ **MySQL/PostgreSQL** - Database
- 🔐 **Laravel Sanctum** - API Authentication
- 🤖 **Gemini AI Integration** - AI-powered features
- 🕷️ **Web Scraping** - Job aggregation from multiple sources

---

## 📦 Instalasi

### Prerequisites
Pastikan Anda sudah menginstall:
- ✅ Node.js (v18+)
- ✅ PHP (v8.2+)
- ✅ Composer
- ✅ MySQL/PostgreSQL
- ✅ XAMPP/Laragon (optional)

### 🎨 Frontend Setup

```bash
# Clone repository
git clone https://github.com/najibarif/lookforjob.git
cd lookforjob

# Install dependencies
npm install

# Jalankan development server
npm run dev
```

Frontend akan berjalan di `http://localhost:5173`

### 🔧 Backend Setup

```bash
# Masuk ke folder backend
cd backend

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup database di .env
# DB_DATABASE=lookforjob
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migration & seeder
php artisan migrate --seed

# Jalankan server
php artisan serve
```

Backend akan berjalan di `http://localhost:8000`

### 🔑 Konfigurasi API Keys

Edit file `backend/.env` dan tambahkan:

```env
# Gemini AI Configuration
GEMINI_API_KEY=your_gemini_api_key_here

# GROQ AI Configuration (optional)
GROQ_API_KEY=your_groq_api_key_here
```

> 💡 **Cara mendapatkan API Key:**
> - Gemini AI: [https://makersuite.google.com/app/apikey](https://makersuite.google.com/app/apikey)
> - GROQ AI: [https://console.groq.com/keys](https://console.groq.com/keys)

---

## 📖 Penggunaan

### 1️⃣ Daftar Akun
```
Kunjungi /register → Isi form pendaftaran → Login
```

### 2️⃣ Lengkapi Profil
```
Dashboard → Profile → Tambahkan skill, pendidikan, dan pengalaman
```

### 3️⃣ Generate CV dengan AI
```
Menu CV → Klik "Generate CV" → AI akan membuat CV profesional otomatis
```

### 4️⃣ Cari Pekerjaan
```
Menu Jobs → Filter berdasarkan kategori/lokasi → Lamar pekerjaan
```

### 5️⃣ Chat dengan Career AI
```
Menu AI Assistant → Tanya tentang karier, tips interview, dll
```

---

## 🎨 Screenshots

<div align="center">

### 🏠 Homepage
![Homepage](https://via.placeholder.com/800x450/6366f1/ffffff?text=Homepage)

### 💼 Job Listings
![Jobs](https://via.placeholder.com/800x450/8b5cf6/ffffff?text=Job+Listings)

### 🤖 AI Assistant
![AI Assistant](https://via.placeholder.com/800x450/ec4899/ffffff?text=AI+Career+Assistant)

### 📄 CV Generator
![CV Generator](https://via.placeholder.com/800x450/10b981/ffffff?text=CV+Generator)

</div>

---

## 📚 Dokumentasi API

Backend menyediakan RESTful API lengkap. Dokumentasi lengkap tersedia di:

📄 **[API_Documentation.md](backend/API_Documentation.md)**

### Quick API Reference

| Endpoint | Method | Deskripsi |
|----------|--------|-----------|
| `/api/register` | POST | Register user baru |
| `/api/login` | POST | Login user |
| `/api/profile` | GET | Get user profile |
| `/api/jobs` | GET | List semua pekerjaan |
| `/api/jobs/{id}` | GET | Detail pekerjaan |
| `/api/cv/generate` | POST | Generate CV dengan AI |
| `/api/ai/chat` | POST | Chat dengan AI assistant |

🔗 **Postman Collection:** `backend/Job_Portal_API.postman_collection.json`

---

## 🛠️ Development

### Available Scripts

```bash
# Frontend
npm run dev          # Development server
npm run build        # Production build
npm run lint         # Run ESLint
npm run preview      # Preview production build

# Backend
php artisan serve              # Start Laravel server
php artisan migrate            # Run migrations
php artisan db:seed            # Seed database
php artisan scrape:jobs        # Scrape job listings
php artisan scrape:indonesia   # Scrape Indonesian jobs
```

---

## 🗂️ Struktur Project

```
lookforjob/
├── 📁 src/                    # Frontend source
│   ├── 📁 components/         # React components
│   │   ├── 📁 ai/             # AI-related components
│   │   ├── 📁 common/         # Reusable components
│   │   ├── 📁 jobs/           # Job-related components
│   │   ├── 📁 layout/         # Layout components
│   │   └── 📁 profile/        # Profile components
│   ├── 📁 pages/              # Page components
│   ├── 📁 services/           # API services
│   ├── 📁 utils/              # Utility functions
│   └── 📄 App.tsx             # Main App component
│
├── 📁 backend/                # Laravel backend
│   ├── 📁 app/                # Application core
│   │   ├── 📁 Http/Controllers/
│   │   ├── 📁 Models/
│   │   └── 📁 Services/       # AI Services
│   ├── 📁 database/           # Migrations & Seeders
│   ├── 📁 routes/             # API Routes
│   └── 📁 config/             # Configuration files
│
├── 📄 package.json            # Frontend dependencies
├── 📄 tailwind.config.js      # Tailwind configuration
├── 📄 vite.config.ts          # Vite configuration
└── 📄 README.md               # This file
```

---

## 🤝 Contributing

Kontribusi sangat diterima! Berikut cara berkontribusi:

1. 🍴 Fork repository ini
2. 🌿 Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. ✨ Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. 📤 Push ke branch (`git push origin feature/AmazingFeature`)
5. 🎯 Buat Pull Request

---

## 🐛 Bug Reports

Menemukan bug? Silakan [buat issue](https://github.com/najibarif/lookforjob/issues) dengan label `bug`.

---

## 📝 License

Project ini dilisensikan di bawah **MIT License** - lihat file [LICENSE](LICENSE) untuk detail.

---

## 👨‍💻 Author

**Najib Arif**

- 🌐 GitHub: [@najibarif](https://github.com/najibarif)
- 📧 Email: najibarif@example.com
- 💼 LinkedIn: [Najib Arif](https://linkedin.com/in/najibarif)

---

## 🙏 Acknowledgments

- [React](https://reactjs.org/) - UI Library
- [Laravel](https://laravel.com/) - Backend Framework
- [Tailwind CSS](https://tailwindcss.com/) - CSS Framework
- [Google Gemini AI](https://deepmind.google/technologies/gemini/) - AI Integration
- [GROQ AI](https://groq.com/) - Alternative AI Provider
- [Lucide Icons](https://lucide.dev/) - Beautiful Icons

---

<div align="center">

[⬆ Kembali ke atas](#-lookforjob)

</div>
