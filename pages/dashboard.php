<!--
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: dashboard.php
  Description: Once logged in this page will be the landing, able to search, view, and reserve books
  Last updated: 11/11/2025
-->

<?php 
session_start();

require_once '../includes/database_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Miniver&family=Playwrite+NO:wght@100..400&display=swap" rel="stylesheet">
    <title>Reservr | Home</title>
</head>
<body>
    <nav class="dashboard-nav no-search">
      <ul>
        <li class="logo">
          <a href="../index.php">
            Reservr
            <img src="../assets/icons/logo.svg" alt="Library icon">
          </a>
        </li>  
        <li class="nav-right">
          <a href="dashboard.php" class="active">Home</a>
          <a href="books.php">Books</a>
          <div class="dropdown">
            <a href="#">
              <img src="../assets/icons/profile.svg" alt="Profile icon" style="height: 28px;">
            </a>
            <div class="dropdown-content">
              <a href="#">Logged in as: <?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?></a>
              <a href="view.php">View your books</a>
              <a href="../includes/logout.php">Log out</a>
            </div>
          </div>
        </li>
      </ul>
    </nav> 
    <main>
      <section class="main-section">
        <div class="section-content">
          <div class="main-details">
            <h2 class="title">
              Reservr
            </h2>
            <h3 class="subtitle">
              Your Library, Simplified
            </h3>
            <p class="description">
              Browse, reserve, and manage your favorite books in one place. Discover our collection and start your reading journey today.
            </p>
            <div class="buttons">
              <a href="books.php" class="button browse">Books</a>
              <a href="view.php" class="button view">Reservations</a>
            </div>
          </div>
          <div class="main-image-wrapper">
            <img src="../assets/images/book.webp" alt="Book image" class="main-image">
          </div>
        </div>
      </section>
    </main>
    <?php $conn->close(); ?>
    <?php include '../includes/footer.php'; ?>
</body>
</html>