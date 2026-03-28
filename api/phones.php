<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/util.php';

$action = get_param('action', 'list');

if ($action === 'list') {
  $customer_id = (int)get_param('customer_id');
  $sql = "SELECT * FROM customer_phone" . ($customer_id ? " WHERE customer_id = ?" : "");
  if ($customer_id) {
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $customer_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  } else {
    $res = $mysqli->query($sql);
    $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }
  json_response($rows);
}

if ($action === 'add') {
  $customer_id = (int)get_param('customer_id');
  $phone = get_param('phone_number');
  if (!$customer_id || !$phone) json_response(['error' => 'Missing fields'], 400);
  $stmt = $mysqli->prepare("INSERT INTO customer_phone (customer_id, phone_number) VALUES (?, ?)");
  $stmt->bind_param('is', $customer_id, $phone);
  $ok = $stmt->execute();
  json_response(['success' => $ok]);
}

if ($action === 'delete') {
  $customer_id = (int)get_param('customer_id');
  $phone = get_param('phone_number');
  if (!$customer_id || !$phone) json_response(['error' => 'Missing fields'], 400);
  $stmt = $mysqli->prepare("DELETE FROM customer_phone WHERE customer_id = ? AND phone_number = ?");
  $stmt->bind_param('is', $customer_id, $phone);
  $ok = $stmt->execute();
  json_response(['success' => $ok]);
}

json_response(['error' => 'Unknown action'], 400);
?>
