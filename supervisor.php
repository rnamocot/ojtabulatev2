<?php
// Start the session and include the database connection
session_start();
require_once('./config/connectiondb.php');
$conn = connectionDBlocal();

$teacher_id = isset($_GET['teacher']) ? $_GET['teacher'] : '';

?>
<!-- Get the username value on the url teacher -->
<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-employee-reg'])) {
  // Get the form data
  $employee_name = $_POST['employeename'];
  $supervisor_name = $_POST['supervisorname'];
  $student_name = $_POST['studentname'];
  $phone = $_POST['phone'];
  $cellnumber = $_POST['cellnumber'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $teacher_id= $_POST['teacher_id'];

  // Insert the data into the database
  $sql = "INSERT INTO `ojt_employee` (`ojt_employee_name`, `ojt_employee_supervisor`,`ojt_employee_student`, `ojt_employee_phone`, `ojt_employee_cell`, `ojt_employee_email`, `ojt_employee_address`, `ojt_teachers_id`) VALUES ('$employee_name', '$supervisor_name','$student_name', '$phone','$cellnumber',  '$email', '$address', '$teacher_id')";
  $result = $conn->query($sql);
  // Check if the query was successful
  if ($result) {
    $success_msg="Sucessfully submitted. Thank you";
  } else {
    // Display an error message
    $error = "Error: " . $conn->error;
    var_dump($error);
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ojtabulate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="./assets/styles/home.css" rel="stylesheet">
    <link href="./assets/styles/supervisor-reg.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./assets/images/logo.jpg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">


</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="./">
                <img id="logo" src="./assets/images/logonew.png" alt="Logo" class="d-inline-block align-text-top">
            </a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php" id="login-nav">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php" id="signup-nav">Register</a>
                    </li>
                </ul>
            </div> -->
        </div>
    </nav>

    <!-- Supervisor Registration Form -->
    <div class="signup-form-main">
        <div class="container">
            <div class="row justify-content-center  ">
                <div class="col-md-6">
                    <div class="card main-login-card">
                        <div class="card-body">
                        <h4 class="card-title mb-4">Supervisor Registration Form:</h4>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="employeeName">Business/Corporation Name:</label>
                                    <input type="text" class="form-control" id="employeeName" name="employeename" placeholder="Enter Business/Corporation Name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="yourName">Supervisor Name:</label>
                                    <input type="text" class="form-control" id="supervisorName" name="supervisorname" placeholder="Enter Supervisor Full Name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="yourName">Student Name:</label>
                                    <input type="text" class="form-control" id="studentName" name="studentname" placeholder="Enter Student Full Name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Supervisor Business Number:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Supervisor Cell  Number:</label>
                                    <input type="tel" class="form-control" id="cellnumber" name="cellnumber" placeholder="Enter Phone Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></input>
                                    <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
                                </div>
                                <button type="submit" class="btn-employee-reg" name="btn-employee-reg">Submit</button>
                                <div class="form-message">
                                <?php if(!empty($success_msg)) { ?>
                                <div class="alert alert-success"><?php echo $success_msg; ?></div>
                                <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <footer>
        <div class="container">
            <div class="footer-sec">
                <div class="row">
                    <div class="col-md-3">
                        <div class="footer-logo-col">
                            <a class="footer-logo" href="#">
                                <img src="./assets/images/logo.jpg" class="d-inline-block align-text-top mainlogo"
                                    alt="Logo" id="footer-logo">
                            </a>
                            <p>Our Internship Management program equips you with the skills and knowledge to effectively
                                manage and develop successful internship programs.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-links">
                            <h3>Quick Links</h3>
                            <ul>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Sitemap</a></li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-links">
                            <h3>Contacts</h3>
                            <div class="footer-contact-list">
                                <a href="">Phone: 000-000-0000</a><br>
                                <a href="">Email: companyemal@domain.com</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-links">
                            <h3>Socials</h3>
                            <div class="social-logos-footer">
                                <a href="#" class="fa fa-facebook"></a>
                                <a href="#" class="fa fa-twitter"></a>
                                <a href="#" class="fa fa-instagram"></a>
                                <a href="#" class="fa fa-linkedin"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyrights">
                <p>© 2023 Company, Inc. All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</body>

</html