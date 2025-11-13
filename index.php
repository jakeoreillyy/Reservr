<!--
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: index.php
  Description: landing page that lets a user to login to their account
  Last updated: 11/11/2025 
-->

<?php 
session_start();

include 'includes/database_connection.php';

if (isset($_SESSION['user_id'])) {
  header("Location: pages/dashboard.php");
  exit();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT user_id, first_name, surname, email, password_hash from users where email = ?");
  
  if (!$stmt) {
    error_log("Database error: " . $conn->error);
    $error_message = "System error, try again later or restart computer.";
  } else {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['email'] = $user['email'];
        
        header("Location: pages/dashboard.php");
        exit();
      } else {
        $error_message = "Incorrect password";
      }
    } else {
      $error_message = "This email does not exist. <a href='pages/registration.php'>Register instead?</a>";
    }
  }
  $stmt->close();
}

$conn->close();
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
            <img src="assets/icons/logo.svg" alt="Library Logo">
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
          <img src="assets/images/books.png" alt="Book Stack">
        </div>
        <div class="card">
          <h2>Welcome Back</h2>
          <?php if ($error_message): ?>
            <div class="alert-error">
              <?php echo $error_message; ?>
            </div>
          <?php endif; ?> 
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
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
      &#169; <?php echo date("Y"); ?> Reservr Library Services. All rights reserved.
    </footer>
  </body>
</html>
