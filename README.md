# FactCheck Bangladesh — IFCN Compliant Editorial Fact-Checking Platform

A minimal, professional, WordPress-class fact-checking publication system built with **Laravel 11**, **PHP 8.4**, **MySQL**, and **Filament v3**.

Live URL: [https://factcheck.hostnibo.com/](https://factcheck.hostnibo.com/)  
CMS Admin: [https://factcheck.hostnibo.com/admin](https://factcheck.hostnibo.com/admin)

---

## 🏛 Editorial & IFCN Compliance Features

1. **Structured Claims & Verdicts:**
   - Dedicated fields for claim text, claimant, viral spread platform, evidence screenshot, and verdict (`ভুয়া`, `বিভ্রান্তিকর`, `সত্য`, `এআই-নির্মিত`, `অপ্রমাণিত`).
   - Step-by-step verification process and structured sources repeater.
   - Transparent correction notes block.

2. **Google Fact Check Indexing (schema.org ClaimReview):**
   - Full automated JSON-LD injection on every published fact-check article.
   - Structured `NewsMediaOrganization`, `Rating`, `CreativeWork` referencing the author, methodology, and corrections policies.

3. **Institutional Transparency Pages (IFCN Mandated):**
   - `/page/about` — আমাদের সম্পর্কে ও পরিচালনা পর্ষদ
   - `/page/methodology` — তথ্যানুসন্ধান ও রেটিং পদ্ধতি
   - `/page/funding` — অর্থায়ন ও মালিকানা নীতি
   - `/page/corrections` — সংশোধন ও ত্রুটি স্বীকার নীতি
   - `/page/editorial-policy` — সম্পাদকীয় ও নিরপেক্ষতা নীতি
   - `/page/contact` — যোগাযোগ ও নিউজরুম ঠিকানা
   - `/page/privacy` — গোপনীয়তা নীতি

4. **Public Claim Submission (`/submit-claim`):**
   - Readers can submit viral links, suspicious rumors, and evidence screenshots (up to 10MB) directly to the newsroom desk.
   - Anti-spam honeypot protection.
   - Managed from the Filament admin panel with status workflows (`pending`, `investigating`, `verified`, `rejected`) and direct linking to published fact-checks.

5. **0% Hardcoding (Spatie Settings):**
   - Every string, logo, favicon, header navigation menu, footer column, SEO title template, robots.txt, announcement banner, and tracking code is fully manageable in the DB via Filament.

6. **SEO, Feeds & Redirects:**
   - Dynamic real-time XML Sitemap: `/sitemap.xml`
   - RSS 2.0 Feed with verdict tags: `/feed`
   - Configurable `robots.txt`
   - 301/302 Redirect Manager in admin core middleware.

7. **Monetization & Cookies:**
   - Clearly labeled advertising slots (`Leaderboard`, `Sidebar`, `Article Bottom`).
   - LocalStorage persistent GDPR cookie consent banner.

---

## 🚀 Setup & Deployment Guide

### Requirements
- PHP >= 8.3 (PHP 8.4 recommended)
- MySQL >= 8.0
- Composer 2.x
- PHP Extensions: `intl`, `fileinfo`, `gd`, `zip`, `pdo_mysql`

### Installation Steps
```bash
git clone <repo_url> /path/to/app
cd /path/to/app

composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate

# Configure MySQL credentials in .env
php artisan migrate --force
php artisan storage:link

# Seed standard IFCN roles, permissions, settings & starter articles
php artisan db:seed --class=ContentSeeder --force
```

### Production Optimizations
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
