# Deployment Guide

## Requirements
- **PHP**: ^8.2
- **Composer**: ^2.0
- **Node.js**: ^18.0
- **Database**: MySQL 8.0 or PostgreSQL 14+
- **Web Server**: Nginx or Apache

## Standard Deployment (Linux/Cloud)

### 1. Clone & Permissions
```bash
cd /var/www
git clone https://github.com/your-username/book-library.git
cd book-library
chown -R www-data:www-data storage bootstrap/cache
```

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

### 3. Environment Setup
```bash
cp .env.example .env
nano .env
# Set APP_ENV=production, APP_DEBUG=false, DB credentials, etc.
```

### 4. Key & DB Setup
```bash
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

### 5. Web Server Config (Nginx Example)
```nginx
server {
    listen 80;
    server_name example.com;
    root /var/www/book-library/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }
}
```

## Docker Deployment (Laravel Sail / Production)
If you prefer Docker, you can use the provided `docker-compose.yml` (if available) or create a generic `Dockerfile`.

1. **Build Image**:
   ```bash
   docker build -t book-library .
   ```
2. **Run Container**:
   ```bash
   docker run -d -p 8000:8000 --env-file .env book-library
   ```
