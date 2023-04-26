<?php
require_once('./config/connectiondb.php');
$conn = connectionDBlocal();

function get_note() {
  global $conn;
  $ojt_employee_id = $_POST['ojt_employee_id'];
  $sql = "SELECT ojt_employee_note_contents, ojt_employee_note_created FROM ojt_employee_status WHERE ojt_employee_id = '$ojt_employee_id'";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
      die("Query failed: " . mysqli_error($conn));
  }
  $notes = array();
  while ($row = mysqli_fetch_assoc($result)) {
      $notes[] = $row;
  }
  return $notes;
}
?>
