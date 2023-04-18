<?php
require_once './includes/login_queries.php'; //Include your database connection and query
session_start();
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// if (isset($_SESSION['username'])) {
//     header("Location: ./dashboard/teacher.php");
//     exit();
// }
if (isset($_POST['btn-login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (verifyUser($username, $password)) {
        $_SESSION['username'] = $username;
        header("Location: ./dashboard.php");
        exit();
    } else {
        $login_error = "Invalid username or password. Please try again.";
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

    <!-- Login Form -->
    <div class="login-form-main">
        <div class="container">
            <div class="row justify-content-center  ">
                <div class="col-md-6">
                    <div class="banner-heading-left" id="left-content">
                        <h1><span class="heading-highlight">OJTabulate </span><br>Internship Management <br>Strategies
                            for Success</h1>
                        <!-- <h3>You are on your way to becoming excellent educators and mentors for the next generation. As
                            you
                            embark on this journey, we wish you all the best and hope that you gain valuable insights,
                            knowledge, and experience that will help you in your future careers.</h3> -->
                        <div class="teacher-div" href="#">
                            <img src="./assets/images/ojt3.png" class="banner-img" alt="Logo">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card main-login-card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Log in to your account</h4>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                                <button type="submit" name="btn-login" class="btn btn-primary">Login</button>
                                <?php if (isset($login_error)) {?>
                                <p class="error-message"><?php echo $login_error; ?></p>
                                <?php }?>
                            </form>
                            <div class="mt-3 text-start">
                                <a href="#">Forgot password?</a>
                            </div>
                            <div class="mt-3">
                                Don't have an account? <a href="signup.php">Sign up</a>
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