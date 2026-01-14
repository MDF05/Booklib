# Contributing to Book Library

Thank you for considering contributing to **Book Library**! We welcome contributions from everyone, and we are grateful for your help in making this project better.

## Table of Contents
- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How to Contribute](#how-to-contribute)
    - [Reporting Bugs](#reporting-bugs)
    - [Suggesting Enhancements](#suggesting-enhancements)
    - [Pull Requests](#pull-requests)
- [Style Guide](#style-guide)
- [Community](#community)

## Code of Conduct
This project and everyone participating in it is governed by the [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code.

## Getting Started
1. **Fork** the repository on GitHub.
2. **Clone** your fork locally:
   ```bash
   git clone https://github.com/your-username/book-library.git
   cd book-library
   ```
3. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```
4. **Set up environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```

## How to Contribute

### Reporting Bugs
If you find a bug, please create a new issue with:
- A clear title and description.
- Steps to reproduce the issue.
- Expected vs. actual behavior.
- Screenshots or logs if applicable.

### Suggesting Enhancements
We love new ideas! Verification of the idea's viability is important before you start coding:
- Check existing issues to see if it's already suggested.
- Open a discussion or issue to propose your enhancement.

### Pull Requests
1. Create a new branch for your feature or fix:
   ```bash
   git checkout -b feature/amazing-feature
   ```
2. Make your changes and commit them following our [Commit Convention](#commit-convention).
3. Push your branch to GitHub:
   ```bash
   git push origin feature/amazing-feature
   ```
4. Open a Pull Request (PR) against the `main` branch.

## Style Guide
Please follow the coding standards defined in [STYLE_GUIDE.md](STYLE_GUIDE.md).
- PHP: We use **Laravel Pint** for formatting.
- JS/CSS: Follow standard conventions.

## Commit Convention
We follow the [Conventional Commits](https://www.conventionalcommits.org/) specification:
- `feat: add new book rating system`
- `fix: resolve login validation error`
- `docs: update deployment guide`
- `chore: update dependencies`

## License
By contributing, you agree that your contributions will be licensed under its [MIT License](LICENSE).
