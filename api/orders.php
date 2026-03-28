<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/util.php';

$action = get_param('action', 'list');

if ($action === 'list') {
  $sql = "SELECT * FROM v_order_totals ORDER BY order_id ASC";
  $res = $mysqli->query($sql);
  $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  json_response($rows);
}

if ($action === 'first') {
  $sql = "SELECT * FROM v_order_totals ORDER BY order_id ASC LIMIT 1";
  $res = $mysqli->query($sql);
  $row = $res ? $res->fetch_assoc() : null;
  json_response($row ? [$row] : []);
}

if ($action === 'last') {
  $sql = "SELECT * FROM v_order_totals ORDER BY order_id DESC LIMIT 1";
  $res = $mysqli->query($sql);
  $row = $res ? $res->fetch_assoc() : null;
  json_response($row ? [$row] : []);
}

if ($action === 'search') {
  $q = get_param('q', '');
  $sql = "SELECT * FROM v_order_totals WHERE order_id = ? OR customer_id = ? ORDER BY order_id ASC";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('ii', $q, $q);
  $stmt->execute();
  $res = $stmt->get_result();
  $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  json_response($rows);
}

if ($action === 'items') {
  $order_id = get_param('order_id');
  $sql = "SELECT oi.order_id, oi.book_id, b.title, oi.quantity, oi.unit_price, (oi.quantity * oi.unit_price) AS line_total
          FROM order_item oi
          JOIN book b ON b.book_id = oi.book_id
          WHERE oi.order_id = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $order_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  json_response($rows);
}

if ($action === 'create') {
  $order_date = get_param('order_date');
  $payment_mode = get_param('payment_mode');
  $customer_id = (int)get_param('customer_id');
  $employee_id = (int)get_param('employee_id');
  $items_json = get_param('items');

  if (!$order_date || !$payment_mode || !$customer_id || !$employee_id || !$items_json) {
    json_response(['error' => 'Missing fields'], 400);
  }

  $items = json_decode($items_json, true);
  if (!is_array($items) || count($items) === 0) {
    json_response(['error' => 'Invalid items'], 400);
  }

  $mysqli->begin_transaction();
  try {
    $stmt = $mysqli->prepare("INSERT INTO `order` (order_date, payment_mode, customer_id, employee_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssii', $order_date, $payment_mode, $customer_id, $employee_id);
    $stmt->execute();
    $order_id = $mysqli->insert_id;

    $stmtItem = $mysqli->prepare("INSERT INTO order_item (order_id, book_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
    foreach ($items as $it) {
      $book_id = (int)$it['book_id'];
      $qty = (int)$it['quantity'];
      $price = (float)$it['unit_price'];
      $stmtItem->bind_param('iiid', $order_id, $book_id, $qty, $price);
      $stmtItem->execute();
    }

    $mysqli->commit();
    json_response(['success' => true, 'order_id' => $order_id]);
  } catch (Exception $e) {
    $mysqli->rollback();
    json_response(['error' => 'Order creation failed', 'details' => $e->getMessage()], 500);
  }
}

if ($action === 'delete') {
  $order_id = (int)get_param('order_id');
  if (!$order_id) json_response(['error' => 'Missing order_id'], 400);
  $stmt = $mysqli->prepare("DELETE FROM `order` WHERE order_id = ?");
  $stmt->bind_param('i', $order_id);
  $ok = $stmt->execute();
  json_response(['success' => $ok]);
}

json_response(['error' => 'Unknown action'], 400);
?>
