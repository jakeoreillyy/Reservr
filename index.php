<!--
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: index.php
  Description: landing page that lets a user to login to their account
  Last updated: 11/11/2025 
-->

<?php 
session_start();

require_once 'includes/database_connection.php';

if (isset($_SESSION['user_id'])) {
  header("Location: pages/dashboard.php");
  exit();
}

$show_reset = isset($_GET['reset']) && $_GET['reset'] === 'true';
$show_success = isset($_GET['reset_success']) && $_GET['reset_success'] === 'true';

$error_message = "";
$success_message = "";

if ($show_success) {
  $success_message = "Password reset successfully! You can now login";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($show_reset) {
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error_message = "Enter a valid email address.";
    } elseif (strlen($new_password) != 6) {
    $error_message = "Password must be 6 digits";
    } elseif ($new_password !== $confirm_password) {
      $error_message = "Passwords do not match";
    } else{

      $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        $update_stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
        $update_stmt->bind_param("si", $password_hash, $user_id);

        if ($update_stmt->execute()){
          $update_stmt->close();
          $stmt->close();
          $conn->close();
          header("Location: index.php?reset_success=true");
          exit();
        } else {
          $error_message = "This email does not exist.";
        }

        $update_stmt->close();
      } else {
        $error_message = "This email does not exist. <a href='pages/registration.php'>Register here?</a>";
      }
        $stmt->close();
  }
} else {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT user_id, first_name, surname, email, password_hash FROM users WHERE email = ?");

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
    $stmt->close();
    }
  }
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
            Reservr
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
      <?php if ($show_reset): ?>
        <div class="card">
          <h2>Reset Your Password</h2>
          <?php if ($error_message): ?>
            <div class="alert-error">
              <?php echo $error_message; ?>
            </div>
          <?php endif; ?> 
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?reset=true';?>">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
              <label for="new_password">Password</label>
              <input type="password" id="new_password" name="new_password" placeholder="Enter your new passord" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required>
            </div> 
            <button type="submit">Reset Password</button>
            <div class="form-footer">
              <a href="index.php">Go back to login</a>
            </div>
          </form>
        </div>
      <?php else: ?>
        <div class="card">
          <h2>Welcome Back</h2>
          <?php if ($success_message): ?>
            <div class="alert-success">
              <?php echo $success_message; ?>
            </div>
          <?php endif; ?> 
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
              <a href="index.php?reset=true">Forgot your password</a>
            </div>
          </form>
        </div>
      <?php endif; ?>
    </main>
    <footer>
      &#169; <?php echo date("Y"); ?> Reservr Library Services. All rights reserved.
    </footer>
  </body>
</html>
