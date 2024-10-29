<?php
session_start();
include("include/connect.php");


if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Retrieving email from the doctor's table based on the email
    $result = mysqli_query($connect, "SELECT * FROM `doctor` WHERE email = '$email'");

    // Retrieving email from the doctor's table based on the email
    $result2 = mysqli_query($connect, "SELECT * FROM `student` WHERE email = '$email'");

    // Retrieving email from the admin's table based on the email provided
    $result3 = mysqli_query($connect, "SELECT * FROM `admin` WHERE email = '$email'");

    if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result2) > 0 || mysqli_num_rows($result3) > 0) {

        //IF doctor's email is valid
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPasswordFromDB = $row['password'];

            // Use password_verify to check if entered password matches the hashed password
            if (password_verify($password, $hashedPasswordFromDB)) {
                // Passing the doctor_id to the dashboard
                $_SESSION["doctor_id"] = $row["doctor_id"];

                // Redirect to the doctor's dashboard

                echo "
                <script>
                    alert('Login successful!');
                    window.location.href='doctor/dashboard.php';                    
                </script>
                ";
            } else {
                // Password is incorrect
                $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 end-0" role="alert">
            <strong>Incorrect password!</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            }
        }



        //IF student's email is valid
        if (mysqli_num_rows($result2) > 0) {
            $row = mysqli_fetch_assoc($result2);
            $hashedPasswordFromDB = $row['password'];

            // Use password_verify to check if entered password matches the hashed password
            if (password_verify($password, $hashedPasswordFromDB)) {
                // Passing the student_id to the dashboard
                $_SESSION["student_id"] = $row["student_id"];

                // Redirect to the student's dashboard
                echo "
                <script>
                    alert('Login successful!');
                    window.location.href='student/dashboard.php';                    
                </script>
                ";
                //  exit();

            } else {
                // Password is incorrect
                $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 end-0" role="alert">
            <strong>Incorrect password!</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            }
        }

        //IF admin's email is valid
        if (mysqli_num_rows($result3) > 0) {
            $row = mysqli_fetch_assoc($result3);
            $PasswordFromDB = $row['password'];

            // Verify to check if password is correct
            if ($password === $PasswordFromDB) {
                // Passing the admin_id to the dashboard
                $_SESSION["admin_id"] = $row["admin_id"];

                // Redirect to the admin's dashboard

                echo "
                <script>
                    alert('Login successful!');
                    window.location.href='admin/dashboard.php';                    
                </script>
                ";
                die();
            } else {
                // Password is incorrect
                $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 end-0" role="alert">
            <strong>Incorrect password!</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            }
        }
    } else {
        // User not found
        $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 end-0" role="alert">
        <strong>User not found!</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MediPro | Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
   <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <?php if (isset($alert)) {
                echo $alert;
            } ?>
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-center flex-column mb-3">
                            <a href="signin.php" class=" text-dark " style="font-size: 30px; font-weight:600;">
                               <img src="assets/images/favicon.png" alt="" srcset=""> MediPro
                            </a>
                            <h3>Sign In</h3>
                        </div>
                        <form action="signin.php" method="POST">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-envelope user-icon"></i></span>
                                <input type="email" name="email" class="form-control p-3" id="floatingInput" placeholder="Email Address">
                                <!-- <label for="floatingInput">Email address</label> -->
                            </div>

                            <div class="input-group mb-4">
                                <span class="input-group-text"><i class="fas fa-lock user-icon"></i></span>
                                <input type="password" name="password" class="form-control p-3" id="floatingPassword" placeholder="Password">
                                <!-- <label for="floatingPassword">Password</label> -->
                            </div>
                           
                            <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </form>
                        <p class="text-center mb-0">Don't have an Account? <a href="./student-signup.php">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div> 
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>