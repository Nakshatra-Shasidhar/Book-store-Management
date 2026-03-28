<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/util.php';

$entity = get_param('entity');
$action = get_param('action', 'list');

$entities = [
  'book' => [
    'table' => 'book',
    'pk' => 'book_id',
    'fields' => ['title','price','genre','stock_count','author_id'],
    'search_field' => 'title'
  ],
  'author' => [
    'table' => 'author',
    'pk' => 'author_id',
    'fields' => ['author_name','nationality'],
    'search_field' => 'author_name'
  ],
  'customer' => [
    'table' => 'customer',
    'pk' => 'customer_id',
    'fields' => ['name','email','address_street','address_city','address_state','address_zip'],
    'search_field' => 'name'
  ],
  'employee' => [
    'table' => 'employee',
    'pk' => 'employee_id',
    'fields' => ['employee_name','role','salary'],
    'search_field' => 'employee_name'
  ]
];

if (!isset($entities[$entity])) {
  json_response(['error' => 'Unknown entity'], 400);
}

$cfg = $entities[$entity];
$table = $cfg['table'];
$pk = $cfg['pk'];
$fields = $cfg['fields'];
$search_field = $cfg['search_field'];

if ($action === 'list') {
  $sql = "SELECT * FROM $table ORDER BY $pk ASC";
  $res = $mysqli->query($sql);
  $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  json_response($rows);
}

if ($action === 'first') {
  $sql = "SELECT * FROM $table ORDER BY $pk ASC LIMIT 1";
  $res = $mysqli->query($sql);
  $row = $res ? $res->fetch_assoc() : null;
  json_response($row ? [$row] : []);
}

if ($action === 'last') {
  $sql = "SELECT * FROM $table ORDER BY $pk DESC LIMIT 1";
  $res = $mysqli->query($sql);
  $row = $res ? $res->fetch_assoc() : null;
  json_response($row ? [$row] : []);
}

if ($action === 'search') {
  $q = get_param('q', '');
  $sql = "SELECT * FROM $table WHERE $search_field LIKE ? ORDER BY $pk ASC";
  $stmt = $mysqli->prepare($sql);
  $like = '%' . $q . '%';
  $stmt->bind_param('s', $like);
  $stmt->execute();
  $res = $stmt->get_result();
  $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  json_response($rows);
}

if ($action === 'create') {
  $placeholders = implode(',', array_fill(0, count($fields), '?'));
  $columns = implode(',', $fields);
  $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
  $stmt = $mysqli->prepare($sql);

  $types = '';
  $values = [];
  foreach ($fields as $f) {
    $v = get_param($f, null);
    $values[] = $v;
    $types .= is_numeric($v) ? 'd' : 's';
  }
  $stmt->bind_param($types, ...$values);
  $ok = $stmt->execute();
  json_response(['success' => $ok, 'id' => $mysqli->insert_id]);
}

if ($action === 'update') {
  $id = get_param($pk);
  if (!$id) json_response(['error' => 'Missing id'], 400);

  $sets = [];
  foreach ($fields as $f) { $sets[] = "$f = ?"; }
  $sql = "UPDATE $table SET " . implode(',', $sets) . " WHERE $pk = ?";
  $stmt = $mysqli->prepare($sql);

  $types = '';
  $values = [];
  foreach ($fields as $f) {
    $v = get_param($f, null);
    $values[] = $v;
    $types .= is_numeric($v) ? 'd' : 's';
  }
  $values[] = $id;
  $types .= 'i';
  $stmt->bind_param($types, ...$values);
  $ok = $stmt->execute();
  json_response(['success' => $ok]);
}

if ($action === 'delete') {
  $id = get_param($pk);
  if (!$id) json_response(['error' => 'Missing id'], 400);

  $sql = "DELETE FROM $table WHERE $pk = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $id);
  $ok = $stmt->execute();
  json_response(['success' => $ok]);
}

json_response(['error' => 'Unknown action'], 400);
?>
