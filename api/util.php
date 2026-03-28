<?php
function json_response($data, $code = 200) {
  http_response_code($code);
  header('Content-Type: application/json; charset=utf-8');
  // Clean any accidental output (including BOM) before JSON
  if (ob_get_length()) { ob_clean(); }
  $json = json_encode($data);
  // Strip UTF-8 BOM if present
  $json = ltrim($json, "ï»¿");
  echo $json;
  exit;
}

function get_param($key, $default = null) {
  return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
}
?>
