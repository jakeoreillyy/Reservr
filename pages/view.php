<?php 
session_start();

require_once '../includes/database_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$error_message = "";
$success_message = "";

$sql = "SELECT * FROM reservations ORDER BY reservation_id";

if (isset($_GET['reservation_id'])) {
    $id = (int)$_GET['reservation_id'];

    $sql = "DELETE FROM reservations WHERE reservation_id = $id";

    if ($conn->query($sql)) {
        $success_message = "Deleted Successfully";
    } else {
        $error_message = "Error: " . $conn->error;
    }

} else {
    $error_message = "No ID provided.";
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
    <title>Reservr | Book Reservations</title>
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
          <a href="dashboard.php">Home</a>
          <a href="books.php">Books</a>
          <div class="dropdown">
            <a href="#">
              <img src="../assets/icons/profile.svg" alt="Profile icon" style="height: 28px;">
            </a>
            <div class="dropdown-content">
              <a href="#">Logged in as: <?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?></a>
              <a href="reservations.php">View your books</a>
              <a href="../includes/logout.php">Log out</a>
            </div>
          </div>
        </li>
      </ul>
    </nav> 
    <main>
    </main>
    <footer>
      &#169; <?php echo date("Y"); ?> Reservr Library Services. All rights reserved.
    </footer> 
</body>
</html>