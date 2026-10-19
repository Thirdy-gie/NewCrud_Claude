# CampusHub — Student Management System

A PHP + MySQL student portal upgraded from the provided project. Includes an admin dashboard, student account CRUD, subject CRUD, subject enrollment management, student portal, responsive UI, prepared SQL statements, password hashing, role checks, and CSRF protection for POST actions.

## Requirements
- PHP 7.4+ (PHP 8.x recommended) with `mysqli`
- MySQL 5.7+ or MariaDB
- Apache/Nginx or a local stack such as XAMPP

## Installation (XAMPP)
1. Copy the `melmel` folder into `xampp/htdocs/` (you can rename it to `campushub`).
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Import `beginner_student_portal.sql`.
5. If your MySQL credentials differ from the defaults, update `config/database.php` or set `DB_HOST`, `DB_USER`, `DB_PASS`, and `DB_NAME` environment variables.
6. Open `http://localhost/melmel/` (or the folder name you chose).

## Demo logins
- Administrator: username `admin`, password `admin123`
- Student: username `juan`, password `student123`

Change or remove demo accounts before using the app with real student data. These credentials are only for local demonstration.

## Features
- Login/logout with PHP password verification and session ID regeneration
- Role-protected administrator and student pages
- Dashboard counts from live database records
- Student create, view, search, edit, and delete
- Subject create, view, search, edit, and delete
- Assign and remove subject enrollments; duplicate enrollment is prevented by a database unique key
- Student portal showing the logged-in student's profile and actual enrolled subjects
- Responsive layout and accessible form labels
- Prepared statements for user-provided values, output escaping, CSRF tokens on state-changing forms

## Important limitations
This is a stronger functional foundation, not a complete production school information system. It does not currently implement grades, attendance, course/department structures, password reset, email verification, audit logs, or report exports. Production deployment should use HTTPS, non-default credentials, environment-managed secrets, regular backups, and additional security review.

## Troubleshooting
- **Database connection failed:** ensure MySQL is running and `config/database.php` credentials match your environment.
- **Login fails after importing:** import the SQL file into the `flores_2ee` database and use the demo credentials exactly as shown above.
- **Blank/error page:** check the PHP/Apache error log; confirm `mysqli` is enabled.
- **Duplicate subject/student:** student numbers, usernames, and subject codes must be unique.
