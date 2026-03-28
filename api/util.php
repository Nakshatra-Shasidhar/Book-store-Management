<?php
function json_response($data, $code = 200) {
  http_response_code($code);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}

function get_param($key, $default = null) {
  return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
}
?>
