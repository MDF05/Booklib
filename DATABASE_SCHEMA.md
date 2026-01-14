# Database Schema

The database consists of the following main tables.

## 1. Users (`users`)
Stores user account information.
- `id`: Primary Key
- `name`: User's full name
- `email`: Unique email address
- `password`: Hashed password
- `role`: Role of the user (e.g., `user`, `admin`) (Inferred from logic)
- `created_at` / `updated_at`: Timestamps

## 2. Books (`books`)
Stores the library inventory.
- `id`: Primary Key
- `title`: Book title
- `author`: Author name
- `description`: Plot summary or details
- `quantity`: Total copies available
- `published_date`: Date of publication
- `cover_image`: Path/URL to cover image
- `created_at` / `updated_at`: Timestamps

## 3. Book Loans (`book_loans`)
Tracks borrowing transactions.
- `id`: Primary Key
- `user_id`: Foreign Key -> `users.id` (Cascade Delete)
- `book_id`: Foreign Key -> `books.id` (Cascade Delete)
- `loan_date`: Date when the loan started
- `return_date`: Expected or actual return date (Nullable)
- `status`: Enum/String (`pending`, `approved`, `rejected`, `returned`)
- `created_at` / `updated_at`: Timestamps

## Relationships
- **User** has Many **Book Loans**
- **Book** has Many **Book Loans**
- **Book** has Many **Ratings** / **Reviews** / **Comments**

## 4. Ratings (`ratings`)
Stores numerical ratings (e.g., 1-5 stars).
- `id`: Primary Key
- `user_id`: FK -> `users.id`
- `book_id`: FK -> `books.id`
- `rating`: Integer value

## 5. Reviews (`reviews`)
Stores text-based reviews.
- `id`: Primary Key
- `user_id`: FK -> `users.id`
- `book_id`: FK -> `books.id`
- `content`: Review text

## 6. Comments (`comments`)
Stores comments on books or reviews.
- `id`: Primary Key
- `user_id`: FK -> `users.id`
- `book_id`: FK -> `books.id`
- `body`: Comment text
