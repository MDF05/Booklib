# Style Guide

To maintain code quality and consistency, we follow strict coding standards.

## PHP Standards
We follow **PSR-12** coding standards.
- Use **Laravel Pint** to automatically fix coding style issues.
  ```bash
  ./vendor/bin/pint
  ```

### Naming Conventions
- **Controllers**: `ResourceController.php` (PascalCase)
- **Models**: `Book.php` (PascalCase, Singular)
- **Tables**: `books` (snake_case, Plural)
- **Variables**: `$variableName` (camelCase)
- **Methods**: `methodName()` (camelCase)

## JavaScript Standards
- Use **ES6+** syntax.
- Use `const` and `let`, avoid `var`.
- Use Arrow functions where appropriate.
- Format using **Prettier** (if configured).

## CSS Standards
- Use **Tailwind CSS** utility classes.
- Avoid writing custom CSS in `app.css` unless necessary for complex animations or overrides not possible with Tailwind.

## Git Commit Reviews
- Commits should be atomic (one feature/fix per commit).
- Write descriptive commit messages (See [CONTRIBUTING.md](CONTRIBUTING.md)).
