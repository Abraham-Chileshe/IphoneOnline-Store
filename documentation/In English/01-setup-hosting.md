# Hosting Configuration & Setup Guide

This guide provides technical details on the environment and steps required to deploy and configure the iPhone Online Store.

## Technology Stack
- **Framework:** Laravel 11
- **Real-time UI:** Laravel Livewire 3
- **Database:** MySQL / MariaDB
- **Language:** PHP 8.2+
- **Frontend:** Vanilla CSS (Modern design system), Alpine.js (for interactivity)

## Deployment Requirements
1. **PHP:** Version 8.2 or higher with required extensions (BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML).
2. **Database:** MySQL 5.7+ or MariaDB 10.3+.
3. **Web Server:** Apache or Nginx with URL rewriting enabled.
4. **Composer:** Required for dependency management.

## Initial Setup Steps

### 1. Environment Configuration
Copy `.env.example` to `.env` and configure your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Install Dependencies
Run the following command to install Laravel dependencies:
```bash
composer install
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Database Migrations & Seeding
To set up the database structure and populate it with initial data (products, cities, and admin user), run:
```bash
php artisan migrate --seed
```

## Admin Access
After seeding the database, you can log in to the admin panel using the following credentials:
- **URL:** `your-domain.com/login`
- **Email:** `Romanvov@site.com`
- **Password:** `Romanvov@Rinac`

## Maintenance
- **Storage Link:** Ensure the storage folder is linked to public if you upload local files:
  ```bash
  php artisan storage:link
  ```
- **Language Files:** All translations are located in the `/lang` directory (`en.json`, `ru.json`).
