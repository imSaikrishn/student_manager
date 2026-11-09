# Student Record Manager (LAMP Mini Project)

A CRUD web app built with PHP and MySQL. Add, view, search, edit and delete student records.

## Files
- `database.sql` - creates the database and `students` table
- `config.php` - database connection and an escape helper
- `index.php` - list and search students
- `add.php` / `edit.php` / `delete.php` - create, update, delete
- `style.css` - styling

## Setup
1. Install XAMPP (or any LAMP stack) and start Apache and MySQL.
2. Copy the `student_manager` folder into `htdocs` (XAMPP) or `/var/www/html` (Linux).
3. Open phpMyAdmin, go to Import, and import `database.sql`.
4. Check the credentials in `config.php` (default: user `root`, empty password).
5. Visit `http://localhost/student_manager/`.

## Concepts demonstrated
- CRUD operations with MySQL
- Prepared statements (prevents SQL injection)
- Output escaping with `htmlspecialchars` (prevents XSS)
- Server-side validation, redirect after POST, unique-key error handling

## Possible extensions
- Login system with sessions and `password_hash`
- Pagination
- Export to CSV
- Marks/attendance table linked by foreign key
