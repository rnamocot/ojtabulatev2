<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];
require_once './includes/dashboard_queries.php';
$user_id = getUserid($username);
$teacher_row = getTeacherprofile($user_id);
$employer_list = getEmployers($user_id);
$employer_list_tab = getEmployers($user_id);

// Edit Profile details
// Check if the form has been submitted
if (isset($_POST['btn-edit-profile'])) {
    // Get the form data
    $fullname = $_POST['fullname'];
    $tusername = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Update the employee in the database
    $sql = "UPDATE ojt_teachers SET ojt_full_name='$fullname',ojt_teachers_username	='$tusername',ojt_teachers_phone='$phone', ojt_teachers_email='$email' WHERE ojt_teachers_username='$username'";
    $result = mysqli_query($conn, $sql);

    // Check if the update was successful
    if ($result) {
        header("Location: ../dashboard/teacher.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {

    // Get the employee from the database
    $sql = "SELECT ojt_full_name,ojt_teachers_username,ojt_teachers_email,ojt_teachers_phone FROM ojt_teachers WHERE ojt_teachers_username='$username'";
    $result = mysqli_query($conn, $sql);

    // Check if the employee was found
    if (mysqli_num_rows($result) == 1) {
        // Get the employee data
        $row = mysqli_fetch_assoc($result);
        $fullname = $row['ojt_full_name'];
        $tusername = $row['ojt_teachers_username'];
        $phone = $row['ojt_teachers_phone'];
        $email = $row['ojt_teachers_email'];
    } else {
        echo "Details not found.";
    }
}

//Update Profile
// Check if the form has been submitted
if (isset($_POST['btn-edit-profile'])) {
    // Get the form data
    $fullname = $_POST['fullname'];
    $tusername = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Update the employee in the database
    $sql = "UPDATE ojt_teachers SET ojt_full_name='$fullname',ojt_teachers_username	='$tusername',ojt_teachers_phone='$phone', ojt_teachers_email='$email' WHERE ojt_teachers_username='$username'";
    $result = mysqli_query($conn, $sql);

    // Check if the update was successful
    if ($result) {
        header("Location: ../dashboard/teacher.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

//Update status

if (isset($_POST['btn-set-status'])) {
    // Get the form data
    $new_status = $_POST['status'];

    // Update the employee in the database
    $sql = "UPDATE ojt_employee SET ojt_employee_status='$new_status' WHERE ojt_teachers_id='$user_id'";
    $result = mysqli_query($conn, $sql);

    // Check if the update was successful
    if ($result) {
        header("dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ojtabulate - Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="./assets/styles/dashboard.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./assets/images/logo.jpg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="./js/dashboard.js" async defer></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">
                <img id="logo" src="./assets/images/logonew.png" alt="Logo" class="d-inline-block align-text-top">
            </a>
            <div class="user-name-top">
            <h3 class="login-user-name"><span class="login-user-span">Login user:</span><?php echo $username; ?></h3>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#profile-modal"><i
                                class="bi bi-person-circle"></i>Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#qr-code-modal"><i class="bi bi-qr-code"></i>QR
                            Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="logout" href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#logout-modal"><i class="bi bi-power"></i>Logout</a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="db-main">
        <div class="container_fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-content">
                        <h2>List of Supervisors</h2>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email </th>
                                <th>Status</th>
                                <th>Quick Actions </th>
                            </tr>
                            <!-- call the getEmployer method to display employee data -->
                            <?php
                            while ($row = mysqli_fetch_assoc($employer_list)) {
                                echo "<tr>
                                <td id='supervisor-details'><i class='bi bi-person-fill'></i>" . $row['ojt_employee_name'] . "<br></td>
                                <td id='supervisor-phone'><i class='bi bi-telephone-fill'></i><a href='tel:" . $row['ojt_employee_phone'] . "'>" . $row['ojt_employee_phone'] . "</a></td>
                                <td id='supervisor-email'><i class='bi bi-envelope'></i><a href='mailto:" . $row['ojt_employee_email'] . "'>" . $row['ojt_employee_email'] . "</a></td>
                                <td id='ojt-employee-status'>
                                        <button class='btn btn-primary dropdown-toggle' id='btn-status' type='button' data-bs-toggle='modal' data-bs-target='#edit-status-modal' >" . $row['ojt_employee_status'] . "<span class='caret'></span></button>
                                    </div>
                                </td>
                                <td id='ojt-employee-quick-actions'>
                                    <div class='dropdown'>
                                        <button class='btn btn-primary dropdown-toggle' id='btn-qck' type='button' data-bs-toggle='dropdown'  >Quick Actions<span class='caret'></span></button>
                                        <ul class='dropdown-menu'>
                                            <li><a href='#'>Add Note</a></li>
                                            <li><a href='#'>New Reminder</a></li>
                                            <li><a href='#'>Trash Contact</a></li>
                                            <li><a href='#'>Merge Contact</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>";

                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modals -->
    <!-- Profile-->
    <div class="modal fade" id="profile-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Profile details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Logout</button>
                </div>
            </div>
        </div>
    </div>
    <!-- logout modal -->
    <div class="modal fade" id="logout-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Logout Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" type="button" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- status modal -->
    <div class="modal fade" id="edit-status-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="frm-status">
                <form method="POST">
                    <label for="status">Set New Status:</label>
                    <div class="select-col">
                    <select id="status" name="status">
                       <option value="New Contact">New Contact</option>
                        <option value="Attempted Contact">Attempted Contact</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Appointment Set">Appointment Set</option>
                        <option value="Appointment Met">Appointment Met</option>
                    </select>
                    </div>
                    <br>
                    <button id="btn-set-status" name="btn-set-status"type="submit">Update Status</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code -->
    <div class="modal fade" id="qr-code-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">QR Code - Supervisor Registration</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- QR CODE RIGHT SIDE CONTENT -->
                    <section id="qr-code">
                        <div class="qr-db-content">
                            <h1 id="qr-h1">Supervisor Registration Form</h1>
                            <h4><span style="color:#0D6EFD;">Note:</span> Scan this code to generate link.
                            </h4>
                            <?php
                    function generateQRCodeLink($url, $user_id)
                    {
                        // Append the username to the URL
                        $url .= '?teacher=' . urlencode($user_id); //username is from session
                        // Generate QR code using qrcode.js library
                        echo '<div id="qrcode"></div>';
                        echo '<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>';
                        echo '<script>';
                        echo 'new QRCode(document.getElementById("qrcode"), "' . $url . '");';
                        echo '</script>';
                        // Add save button to download QR code image
                        echo '<button id="save_btn">Save QR Code</button>';
                        // JavaScript to save QR code image when "Save QR Code" button is clicked
                        echo '<script>';
                        echo 'var saveBtn = document.getElementById("save_btn");';
                        echo 'var canvas = document.querySelector("canvas");';
                        echo 'saveBtn.addEventListener("click", function() {';
                        echo 'var dataUrl = canvas.toDataURL();';
                        echo 'var filename = "QR Code.png";';
                        echo 'saveBtn.innerHTML = "Downloading...";';
                        echo 'saveBtn.disabled = true;';
                        echo 'var link = document.createElement("a");';
                        echo 'link.download = filename;';
                        echo 'link.href = dataUrl;';
                        echo 'link.click();';
                        echo 'saveBtn.innerHTML = "Save QR Code";';
                        echo 'saveBtn.disabled = false;';
                        echo '});';
                        echo '</script>';
                    }
                    generateQRCodeLink('https://ojtabulate.com/supervisor.php', $user_id);
                    ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="container">
            <div class="footer-sec">
                <div class="row">
                    <h2>Dashboard</h2>
                </div>
            </div>
            <div class="copyrights">
                <p>© 2023 Ojtabulate, Inc. All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <!-- Qr code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




</body>

</html>