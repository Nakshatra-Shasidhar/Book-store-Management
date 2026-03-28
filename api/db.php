<?php
// Basic database config. Update these to your local MySQL credentials.
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'Nakshu@2006';
$DB_NAME = 'bookstore_db';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode(["error" => "DB connection failed", "details" => $mysqli->connect_error]);
  exit;
}
$mysqli->set_charset('utf8mb4');
?>
