<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'demo');

// create mysqli instance
$conn = new mysqli('DB_SERVER', 'DB_USERNAME', 'DB_PASSWORD', 'DB_NAME');

// check connection
if ($conn === false) {
  die("Error: Coundn't connect. " . $conn->connect_error);
}
