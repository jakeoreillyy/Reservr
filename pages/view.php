<?php 
session_start();

require_once '../includes/database_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['email'];
$error_message = "";
$success_message = "";

if (isset($_GET['reservation_id'])) {
  $id = (int)$_GET['reservation_id'];

  $delete_stmt = $conn->prepare("DELETE FROM reservations WHERE reservation_id = ? AND email = ?");
  $delete_stmt->bind_param("is", $id, $email);
  
  if ($delete_stmt->execute()) {
    $update_stmt = $conn->prepare("UPDATE books b SET b.reserved = 'N' WHERE b.isbn = ?");
    $update_stmt->bind_param("i", $id);
    $update_stmt->execute();
    $update_stmt->close();

    $success_message = "Reservation cencelled successfully";
  } else {
    $error_message = "Failed to cancel reservation: " . $conn->error;
  }

  $delete_stmt->close();
}

$stmt = $conn->prepare("SELECT r.reservation_id, r.reservation_date, b.*, g.genre_description FROM reservations r JOIN books b ON r.isbn = b.isbn JOIN genres g ON b.genre = g.genre_id WHERE r.email = ? ORDER BY r.reservation_date DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$reservations = $stmt->get_result();
$stmt->close();

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
    <main class="dash-main">
      <div class="page-container">
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
        <div class="section-header">
          <h2><?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?>s Reserved Books</h2>
          <p><?php echo $reservations->num_rows; ?> active reservation<?php echo $reservations->num_rows != 1 ? 's' : ''; ?></p>
        </div>
        <?php if ($reservations->num_rows > 0): ?>
          <div class="books-container">
            <?php while ($book = $reservations->fetch_assoc()): ?>
              <div class="book-card">
                <img src="../<?php echo $book['image_path']; ?>" class="book-image" alt="Book cover" />
                <div class="book-details">
                  <h3 class="book-title"><?php echo $book['book_title']; ?></h3>
                  <p class="book-author"><?php echo $book['author']; ?></p>
                  <div class="book-meta">
                    <span class="book-year"><?php echo $book['year']; ?></span>
                    <span class="separator">•</span>
                    <span class="book-edition">Edition <?php echo $book['edition']; ?></span>
                  </div>
                  <span class="book-genre"><?php echo $book['genre_description']; ?></span>
                  <p>Reserved on: <?php echo date('M d, Y', strtotime($book['reservation_date'])); ?></p>
                  <form method="GET" action="view.php" class="reserve-form">
                    <input type="hidden" name="reservation_id" value="<?php echo $book['reservation_id']; ?>">
                    <button type="submit"class="btn-reserve" onclick="return confirm('Cancel this reservation?')">
                      Cancel Reservation
                    </button>
                  </form>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php else: ?>
          <p>You have no active reservations</p>
          <a href="books.php">Browse books</a>
        <?php endif; ?>
      </div>
    </main>
    <footer>
      &#169; <?php echo date("Y"); ?> Reservr Library Services. All rights reserved.
    </footer> 
</body>
</html>