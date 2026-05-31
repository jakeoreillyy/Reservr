# Reservr

A full-stack library book reservation system built with PHP and MySQL. Users register, browse and search a book catalogue, reserve and cancel books, and manage their reservations through a session-authenticated interface.

---

## Tech Stack

* **Language:** PHP
* **Database:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3
* **Auth:** Session-based, with bcrypt password hashing

---

## Features

* Secure auth passwords hashed with bcrypt, prepared statements on every query, output escaped with `htmlspecialchars`, and session ID regeneration on login
* User registration with server-side validation (Irish phone format, password rules, duplicate email/phone handling)
* Login, logout, and a password-reset flow
* Browse the catalogue with search across title, author, and genre, plus genre filtering and pagination
* Reserve and cancel books, capped at 3 active reservations per user, with availability updated on each action

---

## Database Schema

Four related tables: `users`, `books`, `genres`, and `reservations`, with foreign-key constraints, unique keys on email/phone/ISBN, and cascading deletes. Full schema and seed data are in the `database/` directory.

---

## Getting Started

### Prerequisites

* PHP 8.0+
* MySQL or MariaDB
* A local server (XAMPP, MAMP, or PHP's built-in server)

### Installation

1. Clone the repository

```
git clone https://github.com/<your-username>/reservr.git
cd reservr
```

2. Create the database and import the schema

```
CREATE DATABASE reservr;
```

Then import the SQL files from `database/` (tables and seed data first, then `reservr_extra.sql` for indexes and constraints) via phpMyAdmin or the MySQL CLI.

3. Set your database credentials as environment variables (defaults to `root` with no password)

```
export DB_USERNAME=your_username
export DB_PASSWORD=your_password
```

4. Serve the app

```
php -S localhost:8000
```

Open `http://localhost:8000/index.php` in your browser.
