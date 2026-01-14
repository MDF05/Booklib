# Architecture Overview

## High-Level Architecture
**Book Library** follows the standard **Model-View-Controller (MVC)** architectural pattern provided by the **Laravel** framework. It is a monolithic web application that handles both the backend logic and the frontend presentation.

### Layers
1. **Presentation Layer (View)**:
   - Blade templates located in `resources/views`.
   - Tailwind CSS for styling.
   - JavaScript (Vite) for client-side interactivity.

2. **Application Logic (Controller)**:
   - Controllers located in `app/Http/Controllers`.
   - Handle incoming HTTP requests, validtion, and business logic.
   - Admin and User logic is separated (e.g., `AdminController`).

3. **Data Access Layer (Model)**:
   - Eloquent Models located in `app/Models`.
   - Interacts with the MySQL/PostgreSQL database.
   - Defines relationships (e.g., User hasMany BookLoans).

## Directory Structure
```
book-library/
├── app/
│   ├── Http/Controllers/  # Request handling logic
│   ├── Models/            # Database models
│   └── Providers/         # Service providers
├── config/                # Application configuration
├── database/
│   ├── migrations/        # Database schema definitions
│   └── seeders/           # Dummy data generators
├── public/                # Web root (assets, index.php)
├── resources/
│   ├── css/               # Tailwind/CSS files
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
├── routes/                # Application routes (web.php)
├── tests/                 # Unit and Feature tests
└── vendor/                # Composer dependencies
```

## Data Flow
1. **Request**: User interacts with the UI (e.g., clicks "Rent Book").
2. **Route**: `routes/web.php` maps the URL to a specific Controller method.
3. **Controller**: Validates input, checks authorization (Via Middleware), and calls the Model.
4. **Model**: Queries the database (e.g., checks book availability).
5. **Response**: Controller attempts to return a View with data or a JSON response.
6. **View**: Blade template renders the final HTML to the user.

## Design Principles
- **DRY (Don't Repeat Yourself)**: Use utility classes and components.
- **SOLID**: Follow object-oriented design principles where applicable.
- **Security First**: Use built-in Laravel protection (CSRF, SQL Injection prevention, Authentication).
