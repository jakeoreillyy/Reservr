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

$conn->close();
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
    <nav>
      <ul>
        <li class="logo">
          <a href="../index.php">
            <img src="../assets/icons/logo.svg" alt="Library icon">
          </a>
        </li>  
        <li>
          <a href="dashboard.php" class="active">Home</a>
        </li>
        <li>
          <img src="../assets/icons/search.svg" alt="Search icon">
        </li>
        <li class="dropdown">
          <a href="#">
            <img src="../assets/icons/profile.svg" alt="Profile icon">
          </a>
          <div class="dropdown-content">
            <a href="#"><?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?></a>
            <a href="../index.php">Log out</a>
          </div>
        </li>
      </ul>
    </nav> 
    <footer>
      &#169; <?php echo date("Y"); ?> Reservr Library Services. All rights reserved.
    </footer> 
</body>
</html>