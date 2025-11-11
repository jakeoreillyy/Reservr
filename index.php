<!-- 
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: index.php
  Description: landing page that lets a user to login to their account
  Last updated: 11/11/2025 
-->

<?php 
include 'includes/database_connection.php';


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Reservr | Login</title>
  </head>
  <body>
    <nav>
      <ul>
        <li class="logo">
          <a href="index.php">
            <img src="src/logo.svg" alt="Library Logo">
          </a>
        </li>  
        <li>
        <a href="index.php" class="active">Login</a>
        </li>
        <li>
          <a href="pages/registration.php">Register</a>
        </li>
      </ul>
    </nav> 
    <main>
      <div class="grid-container">
        <div class="reading">
          <img src="src/reading.png" alt="Woman reading">
        </div>
        <div class="card">
          <h2>Welcome Back</h2>
          <form method="POST" action="">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div> 
            <button type="submit">Sign In</button>
            <div class="form-footer">
              <a href="#">Forgot your password</a>
            </div>
          </form>
        </div>
      </div>
    </main>
    <footer>
      &#169; <?php echo date("Y"); ?> Library Services. All rights reserved.
    </footer>
  </body>
</html>
