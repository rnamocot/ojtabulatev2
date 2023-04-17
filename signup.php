<?php
require_once('./includes/signup_queries.php'); //Include your database connection and query

if(isset($_POST['btn-register'])) { //check if the form is submitted

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $check_sql = "SELECT ojt_teachers_username FROM ojt_teachers WHERE ojt_teachers_username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        $registration_error = "Username already exists. Please choose a different one.";
    } else {
        if ($password == $confirm_password) {
            if (registerUser($fullname,$username, $password, $email, $phone)) {
                $success_msg="Sucessfully submitted";
            } else {
                $registration_error = "Registration failed. Please try again.";
            }
        } else {
            $registration_error = "Passwords do not match. Please try again.";
        }
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
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
            </div>
        </div>
    </nav>

    <!-- Signup Form -->
    <div class="signup-form-main">
        <div class="container">
            <div class="row justify-content-center  ">
                <div class="col-md-6">
                    <div class="card main-login-card">
                        <div class="card-body">
                        <form action="" method="post">
                                <h2>Create an Account</h2>
                                <div class="form-group">
                                    <label for="fullname">Full Name:</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                        placeholder="Enter your full name">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" placeholder="Username" name="username"value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                                        <?php if (!empty($registration_error) && strpos($registration_error, 'Username already exists') !== false): ?>
                                        <p class="error-message"><?php echo $registration_error; ?></p>
                                        <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        placeholder="Enter your phone number">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter your email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password">Confirm Password:</label>
                                    <input type="password" class="form-control" id="confirm-password"
                                        name="confirm-password" placeholder="Confirm your password">
                                </div>
                                <?php if(!empty($error_msg)) { ?>
                                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                                <?php } ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms-privacy"
                                        name="terms-privacy">
                                    <label class="form-check-label" for="terms-privacy">By creating an account you agree
                                        to our <a href="#">Terms & Privacy</a>.</label>
                                </div>
                                <button name="btn-register" type="submit" class="btn btn-primary">Register</button>
                                <?php if(!empty($success_msg)) { ?>
                                <div class="alert alert-success"><?php echo $success_msg; ?></div>
                                <?php } ?>
                            </form>
                            <div class="form-footer">
                                <p>Already have an account? <a href="#">Log In</a></p>
                            </div>
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