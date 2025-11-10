<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservr";

$error_messsage = "";
$success_messsage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
    $error_message = "Connection failed: " . $conn->connect_error;
  } else {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];  
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $confirm_password = $_POST('confirm_password');

    trim($phone);

    $validate_form = true;

    if (strlen($password) != 6) {
      $validate_form = false;
    } else {
      if ($password != $confirm_password) {
        $validate_form = false;
      }
    }

    if (strlen($phone) != 10) {
      $validate_form = false;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (title, first_name, surname, email, phone, address, city, country, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $title, $first_name, $surname, $email, $phone, $address, $city, $country, $password_hash);

    try {
      if ($stmt->execute()) {
        $success_messsage = "Account created successfully! You can now login <a href='../index.php'>here</a>";
      }
    } catch (mysqli_sql_exception $e) {
      if (strpos($e->getMessage(), 'email_unique') !== false) {
          $error_message = "This email is already registered. <a href='../index.php'>Login instead?</a>";
      } elseif (strpos($e->getMessage(), 'phone_unique') !== false) {
          $error_message = "This phone number is already registered.";
      } else {
          $error_message = "Registration failed. Please try again.";
      }
    }
      
    $stmt->close();
    $conn->close();
  }
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
          <form method="POST" action="">
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
                <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="surname">Surname</label>
              <input type="text" id="surname" name="surname" placeholder="Surname" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" placeholder="e.g. 086 123 4567" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" id="address" name="address" placeholder="Street address" required>
            </div>
            <div class="input-align">
              <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="City" required>
              </div>
              <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" placeholder="Country" required>
              </div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
            </div>
            <button type="submit">Create Account</button>
          </form>
        </div>
      </div>
    </main>
    <footer>
      &#169; <?php echo date("Y"); ?> Library Services. All rights reserved.
    </footer>
  </body>
</html>