<?php
$servername = "sql100.infinityfree.com";  // usually localhost
$db_username = "if0_40222242";      // your DB username
$db_password = "SzxgXWRJguRtvF";          // your DB password
$db_name = "if0_40222242_db_anime";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
