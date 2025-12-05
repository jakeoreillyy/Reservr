<?php
session_start();

require_once '../includes/database_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$error_message = "";
$success_message = "";
$email = $_SESSION['email'];
$isbn = $_GET['isbn'] ?? '';

$stmt = $conn->prepare("SELECT b.*, g.genre_description FROM books b JOIN genres g ON b.genre = g.genre_id WHERE b.isbn = ?");
$stmt->bind_param("s", $isbn);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$book) {
  header("Location: books.php");
  exit();
}

if ($book['reserved'] === 'Y') {
  $error_message = "This book is already reserved";
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['reserve']) && empty($error_message)) {
  $count_stmt = $conn->prepare("SELECT COUNT(*) as count FROM reservations WHERE email = ?");
  $count_stmt->bind_param("s", $email);
  $count_stmt->execute();
  $count_result = $count_stmt->get_result();
  $reservation_count = $count_result->fetch_assoc()['count'];
  $count_stmt->close();
    
  if ($reservation_count >= 3) {
    $error_message = "You can only reserve up to 3 books at a time. <a href='view.php'>View your reservations</a>";
  } else {
    $check_stmt = $conn->prepare("SELECT reservation_id FROM reservations WHERE isbn = ? AND email = ?");
    $check_stmt->bind_param("ss", $isbn, $email);
    $check_stmt->execute();
    $existing = $check_stmt->get_result()->fetch_assoc();
    $check_stmt->close();
        
    if ($existing) {
      $error_message = "You have already reserved this book.";
    } else {
      $insert_stmt = $conn->prepare("INSERT INTO reservations (isbn, email) VALUES (?, ?)");
      $insert_stmt->bind_param("ss", $isbn, $email);
            
      if ($insert_stmt->execute()) {
        $update_stmt = $conn->prepare("UPDATE books SET reserved = 'Y' WHERE isbn = ?");
        $update_stmt->bind_param("s", $isbn);
        $update_stmt->execute();
        $update_stmt->close();
                
        $success_message = "Book reserved successfully! <a href='books.php'>Browse more books</a>";
      } else {
        $error_message = "Failed to reserve book. Please try again.";
      }
    $insert_stmt->close();
    }
  }
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
      <title>Reservr | Book Reservations</title>
  </head>
  <body>
    <?php include '../includes/header.php'; ?> 
    <main>
      <div class="container">
        <div class="go-back">
          <a href="books.php">← Back to Books</a>
        </div>
        <h2>Reserve Book</h2>
        <div class="reserve-content">
          <div class="content-image">
            <img src="../<?php echo htmlspecialchars($book['image_path']); ?>" alt="Book cover" class="reserve-book-image" />
          </div>
          <div class="content-info">
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
            <div class="reserve-book-info">
              <h3 class="reserve-book-title"><?php echo htmlspecialchars($book['book_title']); ?></h3>
              <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>
              <div class="book-meta">
                <span><?php echo htmlspecialchars($book['year']); ?></span>
                <span class="seperator">•</span>
                <span>Edition <?php echo htmlspecialchars($book['edition']); ?></span>
              </div>
              <span class="book-genre"><?php echo htmlspecialchars($book['genre_description']); ?></span>
              <?php if ($book['reserved'] === 'N' && empty($success_message)): ?>
                <form method="POST" class="reserve-form">
                  <input type="hidden" name="reserve" value="1">
                  <button type="submit">Reserve This Book</button>
                </form>
              <?php elseif ($book['reserved'] === 'Y' && empty($success_message)): ?>
                <div class="alert-error">
                  This book is currently reserved by another user.
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include '../includes/footer.php'; ?>
  </body>
</html>