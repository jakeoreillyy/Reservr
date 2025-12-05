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
          <a href="view.php">View your books</a>
          <a href="../includes/logout.php">Log out</a>
        </div>
      </div>
    </li>
  </ul>
</nav>