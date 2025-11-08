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
            <img src="../images/Library.svg" alt="Library icon">
          </a>
        </li>  
        <li>
          <a href="../index.php">Login</a>
        </li>
        <li>
          <a href="./registration.php" class="active">Register</a>
        </li>
      </ul>
    </nav>  
    <main>
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
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Second Name" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Choose a username" required>
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
              <label for="town">Town</label>
              <input type="text" id="town" name="town" placeholder="Town" required>
            </div>
            <div class="form-group">
              <label for="city">City</label>
              <input type="text" id="city" name="city" placeholder="City" required>
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
    </main>
    <footer class="foot">
      &#169; <?php echo date("Y"); ?> Library Services. All rights reserved.
    </footer>
  </body>
</html>