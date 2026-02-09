# 🚀 LookForJob Backend API

> Laravel 11 backend API for LookForJob - AI-Powered Job Portal Platform

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 Table of Contents

- [Features](#-features)
- [Installation](#-installation)
- [Job Scraping System](#-job-scraping-system)
  - [Quick Start](#quick-start-scraping)
  - [Available Commands](#available-commands)
  - [Supported Sources](#supported-sources)
  - [Automated Scraping](#-automated-scraping)
  - [Adding New Sources](#-adding-new-job-sources)
- [API Documentation](#-api-documentation)
- [Database Structure](#-database-structure)
- [Development](#-development)
- [Troubleshooting](#-troubleshooting)

---

## ✨ Features

### Core Features
- 🔐 **RESTful API** - Clean, versioned API architecture
- 🤖 **AI Integration** - Gemini AI for CV generation and career advice
- 🕷️ **Job Scraping** - Multi-source real job scraping (7+ sources)
- 🔑 **Authentication** - Laravel Sanctum for secure API tokens
- 💾 **Database** - MySQL/PostgreSQL with comprehensive migrations

### AI-Powered Features
- ✅ Auto-categorization (9 job categories)
- ✅ Experience level detection (Entry/Mid/Senior/Intern)
- ✅ Remote job identification
- ✅ Location normalization
- ✅ Salary extraction & formatting

---

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL or PostgreSQL
- XAMPP/WAMPP (for local development)

### Step-by-Step Setup

```bash
# 1. Install dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lookforjob
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. Start development server
php artisan serve
```

### 🔑 API Keys Configuration

Add these to your `.env` file:

```env
# Gemini AI (Required for CV generation)
GEMINI_API_KEY=your_gemini_api_key_here

# GROQ AI (Optional alternative)
GROQ_API_KEY=your_groq_api_key_here
```

**Get API Keys:**
- 🔹 Gemini AI: https://makersuite.google.com/app/apikey
- 🔹 GROQ AI: https://console.groq.com/keys

---

## 🕷️ Job Scraping System

The backend includes a powerful comprehensive job scraping system that collects **real job postings** from multiple Indonesian and international sources.

### Quick Start (Scraping)

```bash
# Navigate to backend
cd c:\xampp\htdocs\myportfolio\rpl\frontend-lfj\backend

# 1️⃣ Test first (dry run - doesn't save to database)
php artisan scrape:comprehensive --limit=5 --dry-run

# 2️⃣ Scrape real data (saves to database)
php artisan scrape:comprehensive --limit=20

# 3️⃣ Check results in database
php artisan tinker
> \App\Models\ScrapedJob::count()
> exit
```

### Available Commands

| Command | Description |
|---------|-------------|
| `php artisan scrape:comprehensive` | Scrape all sources (default 100 jobs/source) |
| `--limit=20` | Limit number of jobs per source |
| `--dry-run` | Test without saving (recommended for testing) |
| `--source=techinasia` | Scrape specific source only |
| `--source=glints --source=kalibrr` | Scrape multiple specific sources |

**Examples:**

```bash
# Small batch scraping
php artisan scrape:comprehensive --limit=20

# Large batch scraping
php artisan scrape:comprehensive --limit=100

# Scrape specific tech sources only
php artisan scrape:comprehensive --source=techinasia --source=glints --limit=50

# Test before scraping
php artisan scrape:comprehensive --limit=5 --dry-run
```

### Supported Sources

The scraper supports **7 job sources**:

| Source | Type | Coverage | Method |
|--------|------|----------|--------|
| **Glints** | API | Tech jobs, Indonesia | JSON API |
| **Kalibrr** | API | General jobs, SEA | JSON API |
| **TechInAsia** | API | Startup/Tech jobs | JSON API |
| **JobStreet** | Schema.org | General jobs, Indonesia | Schema.org parsing |
| **Urbanhire** | Schema.org | Professional jobs | Schema.org parsing |
| **LinkedIn** | HTML Parsing | Professional network | HTML extraction |
| **Lever** | API | Startups (Gojek, Tokopedia, Bukalapak) | JSON API |

### Features

✅ **Automatic deduplication** (by jobUrl)  
✅ **Progress tracking** with statistics  
✅ **Per-source statistics**  
✅ **Dry-run mode** for safe testing  
✅ **Error handling** and comprehensive logging  
✅ **Respectful rate limiting** (1 sec delay between requests)  
✅ **User agent rotation** (appears as normal browser)  
✅ **Retry logic** with exponential backoff  

### Job Data Fields

Each scraped job includes:

- **Basic Info:** position, company, location, jobUrl
- **Details:** description (full text), requirements
- **Classification:** category, employment_type, experience_level
- **Features:** is_remote (boolean), salary, companyLogo
- **Metadata:** source, date, agoTime

---

## 🔄 Automated Scraping

### Windows Task Scheduler Setup

For automated daily scraping:

1. **Open Task Scheduler**
2. **Create Basic Task**
3. **Configure:**
   - **Name:** `LookForJob Daily Scraper`
   - **Trigger:** Daily at 2:00 AM
   - **Action:** Start a program
     - **Program:** `C:\xampp\php\php.exe`
     - **Arguments:** `artisan scrape:comprehensive --limit=100`
     - **Start in:** `c:\xampp\htdocs\myportfolio\rpl\frontend-lfj\backend`

### Laravel Scheduler (Alternative)

Edit `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule): void
{
    // Scrape jobs daily at 2 AM
    $schedule->command('scrape:comprehensive --limit=100')
             ->dailyAt('02:00')
             ->withoutOverlapping()
             ->runInBackground();
             
    // Or every 6 hours
    $schedule->command('scrape:comprehensive --limit=50')
             ->everySixHours();
}
```

Then run:

```bash
# Development
php artisan schedule:work

# Production (add to crontab)
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🛠️ Adding New Job Sources

Want to add more job boards? It's easy!

### Option 1: API-Based Source (Easiest)

If the website has a public API:

```php
// In app/Console/Commands/ScrapeComprehensiveJobs.php

private function scrapeNewSource(int $limit, bool $isDryRun): void
{
    $url = "https://api.example.com/jobs?limit={$limit}";
    $data = $this->scraper->httpGetJson($url);
    
    foreach ($data['jobs'] as $job) {
        $this->saveJob([
            'position' => $job['title'],
            'company' => $job['company'],
            'location' => $job['location'],
            'description' => $job['description'],
            'jobUrl' => $job['url'],
            'source' => 'newsource',
        ], $isDryRun);
    }
}
```

### Option 2: Schema.org Source

If the website uses Schema.org structured data:

```php
private function scrapeNewSource(int $limit, bool $isDryRun): void
{
    $html = $this->scraper->httpGet('https://example.com/jobs');
    $jobs = $this->scraper->extractSchemaOrgJobs($html); // Auto-parse!
    
    foreach ($jobs as $jobData) {
        $jobData['source'] = 'newsource';
        $this->saveJob($jobData, $isDryRun);
    }
}
```

### Option 3: HTML Parsing

For custom HTML parsing:

```php
private function scrapeNewSource(int $limit, bool $isDryRun): void
{
    $html = $this->scraper->httpGet('https://example.com/jobs');
    
    preg_match_all(
        '/<h3>(.*?)<\/h3>.*?class="company">(.*?)<\/span>/s',
        $html,
        $matches,
        PREG_SET_ORDER
    );
    
    foreach ($matches as $match) {
        $this->saveJob([
            'position' => trim(strip_tags($match[1])),
            'company' => trim(strip_tags($match[2])),
            'location' => 'Indonesia',
            'jobUrl' => 'https://example.com/job/' . $match[3],
            'source' => 'newsource',
        ], $isDryRun);
    }
}
```

### Steps to Add a New Source

1. **Create method** `scrapeSourceName()` in `ScrapeComprehensiveJobs.php`
2. **Register** in `$sources` array in `handle()` method
3. **Test** with dry-run:
   ```bash
   php artisan scrape:comprehensive --source=newsource --limit=5 --dry-run
   ```
4. **Run** for real:
   ```bash
   php artisan scrape:comprehensive --source=newsource --limit=20
   ```

---

## 📚 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/register` | Register new user |
| POST | `/login` | Login user |
| POST | `/logout` | Logout user (requires auth) |

### Job Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/jobs` | List all jobs |
| GET | `/jobs/{id}` | Get job details |
| GET | `/jobs/search` | Search jobs |

**Query Parameters for `/jobs`:**
- `limit` - Number of results (default: 20)
- `category` - Filter by category (Technology, Marketing, etc.)
- `is_remote` - Filter remote jobs (true/false)
- `location` - Filter by location
- `source` - Filter by source

**Example:**
```bash
curl http://localhost:8000/api/jobs?limit=10&category=Technology&is_remote=true
```

### Profile Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/profile` | Get user profile |
| PUT | `/profile` | Update profile |
| POST | `/profile/education` | Add education |
| PUT | `/profile/education/{id}` | Update education |
| DELETE | `/profile/education/{id}` | Delete education |
| POST | `/profile/experience` | Add experience |
| PUT | `/profile/experience/{id}` | Update experience |
| DELETE | `/profile/experience/{id}` | Delete experience |
| POST | `/profile/skills` | Add skills |
| DELETE | `/profile/skills/{id}` | Delete skill |

### AI Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/cv/generate` | Generate CV with AI |
| POST | `/cv/analyze` | Analyze CV |
| POST | `/ai/chat` | Chat with AI assistant |

---

## 🗄️ Database Structure

### Key Tables

| Table | Purpose | Records |
|-------|---------|---------|
| `users` | User accounts | Auth data |
| `scraped_jobs` | Job listings | Position, company, description, etc. |
| `cvs` | CV storage | Generated CVs |
| `pendidikan` | Education history | User education |
| `pengalaman` | Work experience | User work history |
| `skills` | User skills | Skill tags |
| `personal_access_tokens` | API tokens | Sanctum auth |
| `cache` | Application cache | Laravel cache |
| `sessions` | User sessions | Session data |

### scraped_jobs Table Fields

**Basic Fields:**
- `position` (string) - Job title
- `company` (string) - Company name
- `location` (string) - Job location

**Details:**
- `description` (text) - Full job description
- `requirements` (text) - Job requirements

**Classification:**
- `category` (string) - Auto-categorized (Technology, Marketing, Sales, etc.)
- `employment_type` (string) - Full-time, Part-time, Contract, Internship
- `experience_level` (string) - Entry Level, Mid Level, Senior, Internship

**Features:**
- `is_remote` (boolean) - Remote work available
- `salary` (string) - Salary range
- `companyLogo` (string) - Company logo URL

**Metadata:**
- `source` (string) - Which scraper collected it
- `date` (datetime) - Posted date
- `jobUrl` (string, unique) - Job posting URL
- `agoTime` (string) - Human-readable time

---

## 🛠️ Development

### Running Development Server

```bash
# Start Laravel server
php artisan serve

# Start on specific port
php artisan serve --port=8080
```

### Database Commands

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (drops all tables)
php artisan migrate:fresh

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status
```

### Cache Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Clear all caches
php artisan optimize:clear
```

### Database Quick Queries (Tinker)

```bash
php artisan tinker
```

```php
// Total jobs
\App\Models\ScrapedJob::count()

// Jobs per source
DB::table('scraped_jobs')
    ->select('source', DB::raw('count(*) as total'))
    ->groupBy('source')
    ->orderBy('total', 'desc')
    ->get()

// Recent jobs (today)
\App\Models\ScrapedJob::whereDate('created_at', today())->count()

// Remote jobs
\App\Models\ScrapedJob::where('is_remote', true)->count()

// Jobs by category
DB::table('scraped_jobs')
    ->select('category', DB::raw('count(*) as total'))
    ->groupBy('category')
    ->orderBy('total', 'desc')
    ->get()

// Latest 5 jobs
\App\Models\ScrapedJob::latest()->take(5)->get(['position', 'company', 'source'])

exit
```

---

## 🐛 Troubleshooting

### Common Issues

#### 1. No data from scraper

**Problem:** `⚠️ No data from API`

**Solutions:**
```bash
# Check logs
Get-Content storage/logs/laravel.log -Tail 50

# Test API manually
curl "https://www.techinasia.com/api/2.0/job-postings?country_name[]=Indonesia&limit=5"

# Try with dry-run
php artisan scrape:comprehensive --limit=5 --dry-run
```

#### 2. Database connection error

**Problem:** `SQLSTATE[HY000] [1045] Access denied`

**Solutions:**
```bash
# Check .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=lookforjob
DB_USERNAME=root
DB_PASSWORD=

# Test connection
php artisan db:show

# Clear config cache
php artisan config:clear
```

#### 3. Migration errors

**Problem:** `Migration not found` or `Table already exists`

**Solutions:**
```bash
# Check migration status
php artisan migrate:status

# If needed, rollback and re-run
php artisan migrate:rollback
php artisan migrate

# Nuclear option (WARNING: Deletes all data)
php artisan migrate:fresh
```

#### 4. Memory errors

**Problem:** `Allowed memory size exhausted`

**Solutions:**
```bash
# Increase PHP memory in php.ini
memory_limit = 512M

# Or run with more memory
php -d memory_limit=512M artisan scrape:comprehensive
```

#### 5. Timeout errors

**Problem:** `Connection timeout`

**Solutions:**

Edit `app/Services/JobScraperService.php`:
```php
private int $retryAttempts = 5; // Increase from 3
private int $retryDelay = 3000; // Increase from 2000
private int $requestDelay = 2000; // Increase from 1000
```

### Debug Mode

Enable debug for detailed error messages:

```env
# .env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Logs Location

```
storage/logs/laravel.log
```

Monitor in real-time:
```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log -Wait -Tail 50

# Linux/Mac
tail -f storage/logs/laravel.log
```

---

## 📊 Performance Tips

### 1. Database Indexing

Already indexed on:
- `scraped_jobs.jobUrl` (unique)
- `scraped_jobs.source`
- `scraped_jobs.category`
- `scraped_jobs.created_at`

### 2. Scraping Best Practices

```bash
# Start small, scale up
php artisan scrape:comprehensive --limit=10    # Day 1
php artisan scrape:comprehensive --limit=50    # Day 2
php artisan scrape:comprehensive --limit=100   # Day 3+

# Scrape during off-peak hours
# Recommended: 2-4 AM local time

# Use specific sources for targeted scraping
php artisan scrape:comprehensive --source=techinasia --source=glints
```

### 3. Database Cleanup

Remove old jobs (3+ months):

```php
// In tinker
\App\Models\ScrapedJob::where('created_at', '<', now()->subMonths(3))->delete()
```

---

## 🔒 Security

### API Authentication

All protected endpoints require Bearer token:

```bash
# Login to get token
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Use token in subsequent requests
curl http://localhost:8000/api/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Environment Variables

**Never commit `.env` to version control!**

Critical variables:
- `APP_KEY` - Application encryption key
- `DB_PASSWORD` - Database password
- `GEMINI_API_KEY` - AI API key
- `GROQ_API_KEY` - AI API key

---

## 📝 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=JobScraperTest

# Run with coverage
php artisan test --coverage
```

---

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure database credentials
- [ ] Set up SSL/HTTPS
- [ ] Configure CORS
- [ ] Set up scheduled tasks (cron)
- [ ] Enable error logging
- [ ] Optimize application:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan optimize
  ```

---

## 📄 License

This project is licensed under the MIT License.

---

## 🙏 Acknowledgments

- **Laravel** - The PHP framework
- **Gemini AI** - AI-powered CV generation
- **GROQ** - Alternative AI service
- Job boards for providing public data

---

## 📞 Support

For issues or questions:
- Check logs: `storage/logs/laravel.log`
- Enable debug: `APP_DEBUG=true`
- Review this README

---

**Built with ❤️ using Laravel 11**

---

## 📖 Quick Command Reference

```bash
# SCRAPING
php artisan scrape:comprehensive --limit=20              # Scrape jobs
php artisan scrape:comprehensive --dry-run               # Test scraping

# DATABASE
php artisan migrate                                       # Run migrations
php artisan db:show                                       # Show DB info
php artisan tinker                                        # Database console

# DEVELOPMENT
php artisan serve                                         # Start server
php artisan optimize:clear                                # Clear all caches
php artisan route:list                                    # List all routes

# LOGS
Get-Content storage/logs/laravel.log -Tail 50            # View logs (Windows)
tail -f storage/logs/laravel.log                         # View logs (Linux/Mac)
```

---

**Version:** 1.0  
**Last Updated:** 2026-02-10  
**Status:** ✅ Production Ready
