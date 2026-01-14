# API & Route Documentation

The **Book Library** application primarily uses server-side rendering with **Web Routes**. Below is the documentation for the key routes available in the application.

## Authentication
| Method | URI | Name | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/login` | `login` | Show login form |
| `POST` | `/login` | - | Handle login request |
| `GET` | `/register` | `register` | Show registration form |
| `POST` | `/register` | - | Handle registration request |
| `POST` | `/logout` | `logout` | Logout the user |

## Public Routes
| Method | URI | Name | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | `home` | Landing page |

## Protected Routes (User)
Requres `auth` middleware.

### Books
| Method | URI | Name | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/books` | `books.index` | List all books |
| `GET` | `/books/{book}` | `books.show` | View single book details |

### Loans
| Method | URI | Name | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/books/{book}/loan` | `book-loans.create` | Show loan request form |
| `POST` | `/books/{book}/loan` | `book-loans.store` | Submit loan request |
| `GET` | `/book-loans` | `book-loans.index` | List user's loans |
| `POST` | `/book-loans/{bookLoan}/return` | `book-loans.return` | Return a book |

### Ratings & Reviews
| Method | URI | Name | Description |
| :--- | :--- | :--- | :--- |
| `POST` | `/books/{book}/ratings` | `ratings.store` | Rate a book |
| `POST` | `/reviews` | `reviews.store` | Submit a text review |
| `POST` | `/books/{book}/comments` | `comments.store` | Comment on a book |

### Profile
| Method | URI | Name | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/profile` | `profile.show` | View profile |
| `GET` | `/profile/edit` | `profile.edit` | Edit profile form |
| `POST` | `/profile/update` | `profile.update` | Update profile data |
| `GET` | `/my-reviews` | `users.my-reviews` | detailed list of user reviews |

## Admin Routes
Requires `admin` middleware. Prefix: `/admin`.

| Method | URI | Name | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin/dashboard` | `admin.dashboard` | Admin analytics dashboard |
| `GET` | `/admin/loans` | `admin.loans` | Manage all book loans |
| `POST` | `/admin/book-loans/{id}/approve` | `admin.book-loans.approve` | Approve a loan request |
| `POST` | `/admin/book-loans/{id}/reject` | `admin.book-loans.reject` | Reject a loan request |
| `POST` | `/admin/book-loans/{id}/approve-return` | `admin.book-loans.approve-return` | Confirm book return |
