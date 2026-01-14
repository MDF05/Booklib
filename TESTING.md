# Testing Guide

We use **PHPUnit** (via Laravel's Artisan command) for backend testing.

## Running Tests

### Run All Tests
To run the full test suite:
```bash
php artisan test
```

### Run Specific Test File
```bash
php artisan test tests/Feature/ExampleTest.php
```

### Filter Tests
Run tests matching a keyword:
```bash
php artisan test --filter=UserTest
```

## Testing Strategy

### 1. Feature Tests
Located in `tests/Feature`. These test full HTTP requests and ensuring the application handles routes, controllers, and database interactions correctly.
- **Example**: `POST /login` logs the user in.
- **Example**: `GET /books` returns a list of books.

### 2. Unit Tests
Located in `tests/Unit`. These test individual methods or classes in isolation.
- **Example**: Testing a custom Helper function.
- **Example**: Testing a Model scope.

## Coverage
We aim for **good coverage** of critical paths, especially:
- Authentication & Authorization flows.
- Book Loan logic (approvals, rejections).
- Data integrity (Foreign key constraints).
