<!--
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: registration.php
  Description: Registration page to get a new user and add it to the users.sql database
  Last updated: 11/11/2025
-->

<?php
include '../includes/database_connection.php';

$error_message = "";
$success_message = "";
$validate_form = true;
$errors = [];
$form_submitted_successfully = false;
$password_error = false;
$phone_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = trim($_POST['title']);
  $first_name = trim($_POST['first_name']);
  $surname = trim($_POST['surname']);  
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);
  $city = trim($_POST['city']);
  $country = trim($_POST['country']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);

  if (strlen($password) != 6) {
    $errors[] = "Password must be 6 digits";
    $validate_form = false;
    $password_error = true;
  } else {
    if ($password !== $confirm_password) {
      $errors[] = "Passwords do not match";
      $validate_form = false;
      $password_error = true;
    }
  }

  $phone = preg_replace('/\D/', '', $phone);

  if (strlen($phone) != 10) {
    $errors[] = "Phone number must be 10 digits";
    $validate_form = false;
    $phone_error = true;
  }

  if (count($errors) > 0) {
    $error_message = implode("<br>", $errors);
  }

  if ($validate_form) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (title, first_name, surname, email, phone, address, city, country, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $title, $first_name, $surname, $email, $phone, $address, $city, $country, $password_hash);

    try {
      if ($stmt->execute()) {
        $success_message = "Account created successfully! You can now login <a href='../index.php'>here</a>";
        $form_submitted_successfully = true;
      }
    } catch (mysqli_sql_exception $e) {
      if (strpos($e->getMessage(), 'email') !== false) {
          $error_message = "This email is already registered. <a href='../index.php'>Login instead?</a>";
      } elseif (strpos($e->getMessage(), 'phone') !== false) {
          $error_message = "This phone number is already registered.";
      } else {
          $error_message = "Registration failed. Please try again.";
      }
    }
      
    $stmt->close();
  }
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Reservr | Register</title>
  </head>
  <body>
    <nav>
      <ul>
        <li class="logo">
          <a href="../index.php">
            <img src="../src/logo.svg" alt="Library icon">
          </a>
        </li>  
        <li>
          <a href="../index.php">Login</a>
        </li>
        <li>
          <a href="registration.php" class="active">Register</a>
        </li>
      </ul>
    </nav>  
    <main>
      <div class="grid-container">
        <div class="reading">
          <img src="../src/reading.png" alt="Woman reading">
        </div>
        <div class="card">
          <h2>Create Account</h2>
          <?php if ($error_message): ?>
            <div class="alert-error">
              <?php echo $error_message; ?>
            </div>
          <?php endif; ?>        
          <?php if ($success_message): ?>
            <div class="alert-success">
              <?php echo $success_message; ?>
            </div>
          <?php endif; ?>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="input-align">
              <div class="form-group">
                <label for="title">Title</label>
                <select id="title" name="title" class="dropdown" required>
                    <option value="" disabled selected>Select your title</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Miss">Miss</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Mx.">Mx.</option>
                    <option value="None">Prefer not to say</option>
                </select>
              </div>
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?php if ($error_message) : echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; endif; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="surname">Surname</label>
              <input type="text" id="surname" name="surname" placeholder="Surname" value="<?php if ($error_message) : echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; endif; ?>" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Email" value="<?php if ($error_message) : echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; endif; ?>" required>
            </div>
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" placeholder="e.g. 086 123 4567" value="<?php if (!$phone_error && !$form_submitted_successfully) : echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; endif ?>" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" id="address" name="address" placeholder="Street address" value="<?php if ($error_message) : echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; endif; ?>" required>
            </div>
            <div class="input-align">
              <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="City" value="<?php if ($error_message) : echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; endif; ?>" required>
              </div>
              <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" placeholder="Country" value="<?php if ($error_message) : echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : ''; endif; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="Create a password" value="<?php if (!$password_error && !$form_submitted_successfully) : echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; endif; ?>" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" value="<?php if (!$password_error && !$form_submitted_successfully) : echo isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : ''; endif; ?>" required>
            </div>
            <button type="submit">Create Account</button>
            <div class="form-footer">
              <a href="../index.php">Already have an account?</a>
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