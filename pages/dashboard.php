<!--
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: dashboard.php
  Description: Once logged in this page will be the landing, able to search, view, and reserve books
  Last updated: 11/11/2025
-->

<?php 
session_start();

include '../includes/database_connection.php';

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
    <title>Reservr | Dashborad</title>
</head>
<body>
    <nav class="dashboard-nav">
      <ul>
        <li class="logo">
          <a href="../index.php">
            Reservr
            <img src="../assets/icons/logo.svg" alt="Library icon">
          </a>
        </li>  
        <li class="search-container">
          <form action="#" method="GET" class="search-box">
            <input type="text" name="q" class="input-search" placeholder="Search..">
            <button class="btn-search" type="submit">
              <img src="../assets/icons/search.svg" alt="Search">
            </button>
          </form>
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
              <a href="../includes/logout.php">Log out</a>
            </div>
          </div>
        </li>
      </ul>
    </nav> 
    <main class="dash-main">
      <h1>
        Reservr
      </h1>
    </main>
    <footer>
      &#169; <?php echo date("Y"); $conn->close();?> Reservr Library Services. All rights reserved.
    </footer> 
</body>
</html>