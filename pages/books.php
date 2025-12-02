<!--
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: books.php
  Description: Users will able to search, view, and reserve books
  Last updated: 11/11/2025
-->

<?php 
session_start();

require_once '../includes/database_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$books_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page);
$offset = ($current_page - 1) * $books_per_page;

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

$count_sql = "SELECT COUNT(*) as total FROM books b JOIN genres g ON b.genre = g.genre_id";
if ($search) {
  $count_sql .= " WHERE b.book_title LIKE ? OR b.author LIKE ? OR g.genre_description LIKE ?";
}

$count_stmt = $conn->prepare($count_sql);
if ($search) {
  $search_param = "%$search%";
  $count_stmt->bind_param("sss", $search_param, $search_param, $search_param);
}

$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_books = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_books / $books_per_page);

$sql = "SELECT b.*, g.genre_description FROM books b JOIN genres g ON b.genre = g.genre_id";

if ($search) {
  $sql .= " WHERE b.book_title LIKE ? OR b.author LIKE ? OR g.genre_description LIKE ?";
}

$sql .= " ORDER BY b.book_id ASC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

if ($search) {
  $search_param = "%$search%";
  $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $books_per_page, $offset);
} else {
  $stmt->bind_param("ii", $books_per_page, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

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
    <title>Reservr | Books</title>
</head>
<body>
    <nav class="dashboard-nav">
      <ul>
        <li class="logo">
          <a href="../index.php">
            Reservr
            <img src="../assets/icons/logo.svg" alt="Library icon">
          </a>
        </li>  
        <li class="search-container">
          <form action="books.php" method="GET" class="search-box">
            <input type="text" name="q" class="input-search" placeholder="Search..">
            <button class="btn-search" type="submit">
              <img src="../assets/icons/search.svg" alt="Search">
            </button>
          </form>
        </li>
        <li class="nav-right">
          <a href="dashboard.php">Home</a>
          <a href="books.php" class="active">Books</a>
          <div class="dropdown">
            <a href="#">
              <img src="../assets/icons/profile.svg" alt="Profile icon" style="height: 28px;">
            </a>
            <div class="dropdown-content">
              <a href="#">Logged in as: <?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?></a>
              <a href="view.php">View your books</a>              
              <a href="../includes/logout.php">Log out</a>
            </div>
          </div>
        </li>
      </ul>
    </nav> 
    <main class="dash-main">
      <div class="page-container">
        <div class="section-header">
          <?php if ($search): ?>
            <h2>
              Search results for "<?php echo htmlspecialchars($search); ?>"
            </h2>
            <p>Found <?php echo $total_books; ?> result<?php echo $total_books != 1 ? 's' : ''; ?></p>
            <?php if ($total_pages > 1): ?>
              <p>(Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>)</p>
            <?php endif; ?>
          <?php else: ?>
            <h2>
              Discover our most popular books
            </h2>
            <p>Top Sellers (Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>)</p>
          <?php endif; ?>
        </div>
        <div class="books-container">
          <?php if ($search && $total_books == 0): ?>
            <h2 class="error-search">
              No books/authors found matching "<?php echo htmlspecialchars($search); ?>"
              <a href="books.php">View all books</a>
            </h2>
          <?php endif; ?>
          <?php while ($book = $result->fetch_assoc()): ?>
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
                <form class="reserve-form">
                  <a href="reservations.php?isbn=<?php echo $book['isbn']; ?>" class="btn-reserve">
                    Reserve Book
                  </a>
                </form>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
        <?php if ($total_pages > 1): ?>
          <div class="pagination">
            <?php if ($current_page > 1): ?>
              <a href="?page=<?php echo $current_page -1; ?><?php echo $search ? '&q=' . urlencode($search) : ''; ?>" class="pagination-control"><- Previous</a>
            <?php endif; ?>
            <div class="pagination-numbers">
              <?php for ($i=1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $current_page): ?>
                  <span class="pagination-number active"><?php echo $i; ?></span>
                <?php else: ?>
                  <a href="?page=<?php echo $i; ?> <?php echo $search ? '&q=' . urlencode($search) : ''; ?>" class="pagination-number"><?php echo $i; ?></a>
                <?php endif; ?>
              <?php endfor; ?>
            </div>
            <?php if ($current_page < $total_pages): ?>
              <a href="?page=<?php echo $current_page + 1; ?> <?php echo $search ? '&q=' . urlencode($search) : ''; ?>" class="pagination-control">Next -></a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </main>
    <?php $conn->close(); ?>
    <footer>
      &#169; <?php echo date("Y"); ?> Reservr Library Services. All rights reserved.
    </footer> 
</body>
</html>