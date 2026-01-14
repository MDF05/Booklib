<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Book Library System

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![Build Status](https://github.com/laravel/framework/workflows/tests/badge.svg)](https://github.com/laravel/framework/actions)

## Project Overview
**Book Library** is a robust, web-based library management system built with **Laravel**. It allows users to browse books, Request loans, lease ratings, and write reviews. Ideally suited for schools, community libraries, or personal collections.

## Features
- **User Authentication**: Secure Login/Register/Profile management.
- **Book Management**: Browse inventory with details (cover, stock, etc.).
- **Loan System**: Request books, track status (Pending/Approved), and return flows.
- **Community**: Rate books (1-5 stars), leave comments, and write reviews.
- **Admin Panel**: Manage books, approve/reject loans, and view dashboard analytics.

## Tech Stack
- **Framework**: Laravel 12.x
- **Language**: PHP 8.2+
- **Database**: MySQL / PostgreSQL
- **Frontend**: Blade Templates + Tailwind CSS + Vite
- **Testing**: PHPUnit

## 📚 Documentation
Here is the complete documentation for the project:

- **General**
    - [Contributing Guide](CONTRIBUTING.md)
    - [Code of Conduct](CODE_OF_CONDUCT.md)
    - [Security Policy](SECURITY.md)
    - [Governance](GOVERNANCE.md)
    - [Support](SUPPORT.md)
    - [Disclaimer](DISCLAIMER.md)
    - [License](LICENSE)

- **Technical**
    - [Architecture](ARCHITECTURE.md)
    - [API Documentation](API_DOCUMENTATION.md)
    - [Database Schema](DATABASE_SCHEMA.md)
    - [Deployment Guide](DEPLOYMENT.md)
    - [Environment Variables](ENVIRONMENT.md)
    - [Testing Guide](TESTING.md)
    - [Style Guide](STYLE_GUIDE.md)

- **Project Management**
    - [Changelog](CHANGELOG.md)
    - [Roadmap](ROADMAP.md)

## Installation

1. **Clone the repo**
   ```bash
   git clone https://github.com/your-username/book-library.git
   cd book-library
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate --seed
   ```

5. **Run Server**
   ```bash
   php artisan serve
   ```

## Author
Developed by [Your Name].
