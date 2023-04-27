<?php
require_once('./config/connectiondb.php');
$conn = connectionDBlocal();

// Fetch data from database based on ojt_employee_id parameter
$ojt_employee_id = $_POST['ojt_employee_id'];
// Build SQL query and execute it
$sql = "SELECT * FROM ojt_employee_notes WHERE ojt_employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $ojt_employee_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data and store it in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close statement and mysqli connection
$stmt->close();
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
// Debug code: print out JSON data
error_log("JSON data: " . json_encode($data));
echo json_encode($data);

?>


