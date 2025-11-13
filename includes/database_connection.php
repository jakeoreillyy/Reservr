<!-- 
  Project: Reservr, library reservation system
  Author: Jake O'Reilly
  File: database_connection.php
  Description: The code to connect to the database, so it removes the need to type it out on every page
  Last updated: 11/11/2025 
-->

<?php
$servername = "localhost";
$username = getenv("DB_USERNAME") ?: "root";
$password = getenv("DB_PASSWORD") ?: "";
$dbname = "reservr";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>