<?php
require_once('./config/connectiondb.php');
$conn = connectionDBlocal();

function verifyUser($username, $password) {
    global $conn;
    $sql = "SELECT ojt_teachers_password FROM ojt_teachers WHERE ojt_teachers_username='$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['ojt_teachers_password'])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>