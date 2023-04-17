<?php
require_once('./config/connectiondb.php');
$conn = connectionDBlocal();
function registerUser($fullname, $username, $password, $email, $phone) {
    global $conn;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO ojt_teachers (ojt_full_name,ojt_teachers_username, ojt_teachers_password, ojt_teachers_email, ojt_teachers_phone) VALUES ('$fullname', '$username', '$hash', '$email', '$phone')";
    if (mysqli_query($conn, $sql)) {
        $ojt_teacher_id = mysqli_insert_id($conn); // retrieve the ojt_teacher_id of the inserted record
        return $ojt_teacher_id;
    } else {
        return false;
    }
}
?>