<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservr";

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
    $error_message = "Connection failed: " . $conn->connect_error;
    }
}
?>