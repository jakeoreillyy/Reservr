# Reservr

A simple and efficient **full-stack web application for managing library book reservations**.

---

## 🖼️ Overview

Reservr is a full-stack library reservation system built with PHP and MySQL. Users can register, browse the catalogue, reserve books, and manage their reservations through a session-based authenticated interface.

---

## ⚙️ Features

✅ User registration and authentication  
✅ Browse and search for available books  
✅ Reserve and cancel book reservations  
✅ Track and update book availability in real-time

---

## 🧰 Built With

- **HTML5** – page structure and layout.
- **CSS3** – design, styling, and responsiveness.
- **PHP** – server-side logic, validation, and session management.
- **MySQL** – persistent data storage and query handling.

---

## 📂 Structure

```
Reservr/
├── css/
│   └── style.css
│
├── pages/
│   ├── books.php
│   ├── dashboard.php
│   ├── registration.php
│   ├── reservations.php
│   └── view.php
│
├── assets/
│   ├── icons/
│   │   ├── logo.svg
│   │   ├── profile.svg
│   │   └── search.svg
│   ├── books/
│   │   └── (25 images of books)
│   └── images/
│       └── book.webp
│
├── database/
│   ├── reservr_database.sql
│   ├── reservr_extra.sql
│   ├── reservr_table_books.sql
│   ├── reservr_table_genres.sql
│   ├── reservr_table_reservations.sql
│   └── reservr_table_users.sql
│
├── includes/
│   ├── database_connection.php
│   ├── header.php
│   ├── footer.php
│   └── logout.php
│
└── index.php

```

---
