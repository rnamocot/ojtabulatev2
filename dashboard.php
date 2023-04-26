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

if(isset($_POST['btn-set-status'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $ojt_employee_id = mysqli_real_escape_string($conn, $_POST['ojt_employee_id']);
  
    $sql = "UPDATE ojt_employee SET ojt_employee_status='$status' WHERE ojt_employee_id='$ojt_employee_id'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        header("location: dashboard.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
// Add notes
// Check if the form has been submitted
if (isset($_POST['btn-add-note'])) {
    // Get the employer ID from the form
    $employer_id = $_POST['employer_id'];
  
    // Get the note contents from the form
    $note_contents = $_POST['note_contents'];
  
    // Check if the note contents is not empty
    if (!empty($note_contents)) {
        // Check for errors
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
      
        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO ojt_employee_notes (ojt_employee_note_contents,ojt_employee_id) VALUES (?, ?)");
      
        // Bind the parameters to the query
        $stmt->bind_param("ss", $note_contents, $employer_id);
      
        // Execute the query
        if ($stmt->execute()) {
            // The note was added successfully
            $addnote_msg = "Note added successfully!";
        } else {
            // There was an error adding the note
            $addnote_msg = "Error adding note: " . $stmt->error;
        }
      
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Note contents is empty
        $addnote_msg = "Note contents cannot be empty!";
    }
}

// View Notes


// Check if the "View Note" button was clicked
if (isset($_POST['btn-view-note'])) {
  // Get the employee ID from the clicked button's data attribute
  $employee_id = $_POST['data-row-id'];

  // Prepare a SELECT query to retrieve the note contents for the specified employee ID
  $sql = "SELECT ojt_employee_note_contents
          FROM ojt_employee_notes
          WHERE ojt_employee_id = $employee_id";

  // Check if any rows were returned
  if (mysqli_num_rows($result) > 0) {
    // Retrieve the note contents from the first row of the result
    $row = mysqli_fetch_assoc($result);
    $note_contents = $row['ojt_employee_note_contents'];

    // Display the note contents in the "note-contents" div inside the "View Note" modal
    echo "<script>
            document.querySelector('#viewnote-modal .note-contents').innerHTML = '$note_contents';
          </script>";
  } else {
    // No rows were returned, display an error message
    echo "<div class='alert alert-danger' role='alert'>No note found for employee ID $employee_id.</div>";
  }

  // Close the database connection
  mysqli_close($conn);
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
                <h3 class="login-user-name"><span class="login-user-span">Login user:</span><?php echo $username; ?>
                </h3>
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
                                <td id='supervisor-details'><i class='bi bi-info-circle-fill'></i>" . $row['ojt_employee_name'] . "<br>
                                <button name='btn-view-note' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#viewnote-modal' id='btn-viewnote' type='button' data-ojt-employee-id='" . $row['ojt_employee_id'] . "'>
                                   <i class='bi bi-file-earmark-text-fill'></i> View Note
                               </button>                       
                                </td>
                                <td id='supervisor-phone'><i class='bi bi-telephone-fill'></i><a href='tel:" . $row['ojt_employee_phone'] . "'>" . $row['ojt_employee_phone'] . "</a></td>
                                <td id='supervisor-email'><i class='bi bi-envelope-at-fill'></i><a href='mailto:" . $row['ojt_employee_email'] . "'>" . $row['ojt_employee_email'] . "</a></td>
                                <td id='ojt-employee-status'>
                                   <button class='btn btn-status-db btn-primary dropdown-toggle' id='btn-status-". $row['ojt_employee_id'] ."' type='button' data-bs-toggle='modal' data-bs-target='#edit-status-modal' data-ojt-employee-id='". $row['ojt_employee_id'] ."'>". $row['ojt_employee_status'] ."<span class='caret'></span></button>
                                </td>
                                    </div>
                                </td>
                                <td id='ojt-employee-quick-actions'>
                                 <div class='dropdown'>
                                    <button class='btn btn-primary dropdown-toggle' id='btn-qck' type='button' data-bs-toggle='dropdown'>
                                    Quick Actions<span class='caret'></span>
                                    </button>
                                    <ul class='dropdown-menu'>
                                    <li><a href='#' data-bs-toggle='modal' data-bs-target='#add-note-modal' data-employer-id='". $row['ojt_employee_id'] ."'>Add Note</a></li>
                                    <li><a href='#' data-bs-toggle='modal' data-bs-target='#new-reminder-modal' data-employer-id='". $row['ojt_employee_id'] ."'>New Reminder</a></li>
                                    <li><a href='#' data-bs-toggle='modal' data-bs-target='#trash-contact-modal' data-employer-id='". $row['ojt_employee_id'] ."'>Trash Contact</a></li>
                                    <li><a href='#' data-bs-toggle='modal' data-bs-target='#merge-contact-modal' data-employer-id='". $row['ojt_employee_id'] ."'>Merge Contact</a></li>
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
                    <div class="profile-row-sec">
                        <h4><span class="profile-info">Name:</span><?php echo $teacher_row['ojt_full_name']; ?></h4>
                        <br>
                        <h4><span
                                class="profile-info">Username:</span><?php echo $teacher_row['ojt_teachers_username']; ?>
                        </h4> <br>
                        <h4><span class="profile-info">Phone:</span> <?php echo $teacher_row['ojt_teachers_phone']; ?>
                        </h4><br>
                        <h4><span class="profile-info">Email:</span><?php echo $teacher_row['ojt_teachers_email']; ?>
                        </h4>
                        <!-- <br>
                    <button class="trigger btn-btn-primary" id="btn-edit-profile">Edit</button>
                    <br> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            <input type="hidden" id="ojt_employee_id" name="ojt_employee_id" value="">
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
                            <button id="btn-set-status" name="btn-set-status" type="submit">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Note modal -->
    <div class="modal fade" id="viewnote-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Note List</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="note-contents">
                        <table>
                            <thead>
                                <tr>
                                    <th>Note</th>
                                    <th>Dated Added</th>
                                </tr>
                            </thead>
                            <tbody id="note-table-body"></tbody>
                        </table>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick actions Modal -->
    <!-- Add Note-->
    <div class='modal fade' id='add-note-modal' tabindex='-1' aria-hidden='true'>
        <div class='modal-dialog'>
            <form method='POST' action='dashboard.php' id='add-note-form'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>Add Note</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <div class='mb-3'>
                            <?php if (!empty($addnote_msg)): ?>
                            <div class="alert alert-success"><?php echo $addnote_msg; ?></div>
                            <?php endif; ?>
                            <label for='note-contents' class='form-label'>Note Contents</label>
                            <textarea class='form-control' id='note-contents' name='note_contents'></textarea>
                        </div>
                        <input type='hidden' name='employer_id' id='employer_id' value=''>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                        <button type='submit' name="btn-add-note" class='btn btn-primary'>Save changes</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class='modal' id='new-reminder-modal'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <!-- Add your modal content here -->
            </div>
        </div>
    </div>

    <div class='modal' id='trash-contact-modal'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <!-- Add your modal content here -->
            </div>
        </div>
    </div>

    <div class='modal' id='merge-contact-modal'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <!-- Add your modal content here -->
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
    <script>
    //code to pass the value status to status modal
    $(document).ready(function() {
        // listen for click event on the status button
        $('[id^="btn-status-"]').click(function() {
            // get the ojt_employee_id value from the data attribute
            var ojt_employee_id = $(this).data('ojt-employee-id');

            // set the value of the hidden input field in the form modal
            $('#ojt_employee_id').val(ojt_employee_id);
        });
    });

    // code to change status color depending on the value

    $(document).ready(function() {
        $('.btn-status-db').each(function() {
            const $button = $(this);
            const buttonText = $button.text().trim();
            if (buttonText === "New Contact") {
                $button.css('color', 'red');
            } else if (buttonText === "Attempted Contact") {
                $button.css('color', 'blue');
            } else if (buttonText === "Contacted") {
                $button.css('color', '#1f8b9d');
            } else if (buttonText === "Appointment Set" || buttonText === "Appointment Met") {
                $button.css('color', '#765700');
            }
        });
    });
    </script>

    <!-- Add NOTE -->
    <!-- Add a script to handle the form submission -->
    <script>
    $(document).ready(function() {
        $('#add-note-modal, #new-reminder-modal, #trash-contact-modal, #merge-contact-modal').on(
            'show.bs.modal',
            function(event) {
                var button = $(event.relatedTarget);
                var employer_id = button.data('employer-id');
                var modal = $(this);
                modal.find('#employer_id').val(employer_id);
            });
    });
    </script>
    <!-- View Note -->
    <script>
$(document).ready(function() {
    $('button[name="btn-view-note"]').click(function() {
        var ojt_employee_id = $(this).data('ojt-employee-id');
        $.ajax({
            url: 'get_note.php',
            method: 'POST',
            data: {ojt_employee_id: ojt_employee_id},
            success: function(response) {
                var noteTableBody = $('#note-table-body');
                noteTableBody.empty();
                $.each(response, function(index, note) {
                    noteTableBody.append('<tr><td>' + note.ojt_employee_note_contents + '</td><td>' + note.ojt_employee_note_created + '</td></tr>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});

    </script>


</body>

</html>