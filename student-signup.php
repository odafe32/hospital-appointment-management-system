<?php
include ("include/connect.php");

$firstname_err = null;
$lastname_err = null;
$othername_err = null;
$email_err = null;
$matric_err = null;
$password_err = null;

if (isset($_POST['submit'])) {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $othername = trim($_POST["othername"]);
    $email = trim($_POST["email"]);
    $matric = trim($_POST["matric"]);
    $password = $_POST["password"];

    //VALIDATION - Basic sanitization
    $firstname = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
    $lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
    $othername = htmlspecialchars($othername, ENT_QUOTES, 'UTF-8');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); 
    $matric = htmlspecialchars($matric, ENT_QUOTES, 'UTF-8');

    $password_length = strlen($password);
    $validation_failed = false;

    // VALIDATION - Names (allowing Unicode letters, spaces, hyphens, apostrophes)
    if (empty($firstname) || !preg_match('/^[\p{L}\s\'-]{1,50}$/u', $firstname)) {
        $firstname_err = "First name must contain only letters, spaces, hyphens, or apostrophes (1-50 characters).";
        $validation_failed = true;
    }

    if (empty($lastname) || !preg_match('/^[\p{L}\s\'-]{1,50}$/u', $lastname)) {
        $lastname_err = "Last name must contain only letters, spaces, hyphens, or apostrophes (1-50 characters).";
        $validation_failed = true;
    }

    // Other name is optional, but if provided, same rules apply
    if (!empty($othername) && !preg_match('/^[\p{L}\s\'-]{1,50}$/u', $othername)) {
        $othername_err = "Other name must contain only letters, spaces, hyphens, or apostrophes (1-50 characters).";
        $validation_failed = true;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
        $validation_failed = true;
    }

    // Matric number validation (alphanumeric, possibly with forward slash or hyphen)
    if (empty($matric) || !preg_match('/^[a-zA-Z0-9\/\-]{3,20}$/u', $matric)) {
        $matric_err = "Matric number must be 3-20 characters long and contain only letters, numbers, hyphens, or forward slashes.";
        $validation_failed = true;
    }

    // Password validation - more comprehensive
    if ($password_length < 6) {
        $password_err = "Password must be at least 6 characters long.";
        $validation_failed = true;
    } elseif ($password_length > 128) {
        $password_err = "Password must not exceed 128 characters.";
        $validation_failed = true;
    } elseif (!preg_match('/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?`~]+$/', $password)) {
        $password_err = "Password contains invalid characters.";
        $validation_failed = true;
    }

    // Check for existing email and matric number only if basic validation passes
    if (!$validation_failed) {
        // Use prepared statements to prevent SQL injection
        $stmt_email = mysqli_prepare($connect, "SELECT * FROM student WHERE email = ?");
        mysqli_stmt_bind_param($stmt_email, "s", $email);
        mysqli_stmt_execute($stmt_email);
        $result_email = mysqli_stmt_get_result($stmt_email);
        
        if (mysqli_num_rows($result_email) > 0) {
            $email_err = "This email address is already registered.";
            $validation_failed = true;
        }
        mysqli_stmt_close($stmt_email);

        $stmt_matric = mysqli_prepare($connect, "SELECT * FROM student WHERE matric = ?");
        mysqli_stmt_bind_param($stmt_matric, "s", $matric);
        mysqli_stmt_execute($stmt_matric);
        $result_matric = mysqli_stmt_get_result($stmt_matric);
        
        if (mysqli_num_rows($result_matric) > 0) {
            $matric_err = "This matric number is already registered.";
            $validation_failed = true;
        }
        mysqli_stmt_close($stmt_matric);
    }

    // If all validation passes, insert the record
    if (!$validation_failed) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Use prepared statement for insertion
        $stmt_insert = mysqli_prepare($connect, "INSERT INTO student (firstname, lastname, othername, email, matric, password) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_insert, "ssssss", $firstname, $lastname, $othername, $email, $matric, $password_hash);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            mysqli_stmt_close($stmt_insert);
            echo "<script>
                alert('Signup successful! You can now sign in with your credentials.');
                window.location.href='signin.php';
            </script>";
            exit();
        } else {
            $connect_error = mysqli_error($connect);
            echo "<script>
                alert('Signup error: Database operation failed. Please try again.');
            </script>";
        }
        mysqli_stmt_close($stmt_insert);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MeCare | Student's Sign-up</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Student registration, medical platform signup" name="keywords">
    <meta content="Sign up for MeCare student account" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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

    <style>
        .password-requirements {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
        .error-message {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .form-control.is-valid {
            border-color: #28a745;
        }
    </style>
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

        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-center flex-column mb-3">
                            <a href="index.php" class="">
                                <img src="asa/img/logo/logo.png" alt="MeCare Logo" style="width: 60px; height: auto;"> 
                            </a>
                            <h3 class="mt-2">Sign Up</h3>
                            <p class="text-muted">Create your student account</p>
                        </div>
                        
                        <form action="student-signup.php" method="POST" novalidate>
                            <!-- First Name -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       name="firstname" 
                                       class="form-control <?php echo !empty($firstname_err) ? 'is-invalid' : ''; ?>" 
                                       id="floatingFirstName" 
                                       placeholder="First Name" 
                                       value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>"
                                       maxlength="50"
                                       required>
                                <label for="floatingFirstName">First Name *</label>
                                <?php if (!empty($firstname_err)): ?>
                                    <div class="text-danger error-message"><?php echo $firstname_err; ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Last Name -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       name="lastname" 
                                       class="form-control <?php echo !empty($lastname_err) ? 'is-invalid' : ''; ?>" 
                                       id="floatingLastName" 
                                       placeholder="Last Name" 
                                       value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>"
                                       maxlength="50"
                                       required>
                                <label for="floatingLastName">Last Name *</label>
                                <?php if (!empty($lastname_err)): ?>
                                    <div class="text-danger error-message"><?php echo $lastname_err; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Other Name -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       name="othername" 
                                       class="form-control <?php echo !empty($othername_err) ? 'is-invalid' : ''; ?>" 
                                       id="floatingOtherName" 
                                       placeholder="Other Name" 
                                       value="<?php echo isset($_POST['othername']) ? htmlspecialchars($_POST['othername']) : ''; ?>"
                                       maxlength="50">
                                <label for="floatingOtherName">Other Name (Optional)</label>
                                <?php if (!empty($othername_err)): ?>
                                    <div class="text-danger error-message"><?php echo $othername_err; ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Email -->
                            <div class="form-floating mb-3">
                                <input type="email" 
                                       name="email" 
                                       class="form-control <?php echo !empty($email_err) ? 'is-invalid' : ''; ?>" 
                                       id="floatingInput" 
                                       placeholder="name@example.com" 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                       required>
                                <label for="floatingInput">Email Address *</label>
                                <?php if (!empty($email_err)): ?>
                                    <div class="text-danger error-message"><?php echo $email_err; ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Matric Number -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       name="matric" 
                                       class="form-control <?php echo !empty($matric_err) ? 'is-invalid' : ''; ?>" 
                                       id="floatingMatric" 
                                       placeholder="Matric Number" 
                                       value="<?php echo isset($_POST['matric']) ? htmlspecialchars($_POST['matric']) : ''; ?>"
                                       maxlength="20"
                                       required>
                                <label for="floatingMatric">Matric Number *</label>
                                <?php if (!empty($matric_err)): ?>
                                    <div class="text-danger error-message"><?php echo $matric_err; ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-4">
                                <input type="password" 
                                       name="password" 
                                       class="form-control <?php echo !empty($password_err) ? 'is-invalid' : ''; ?>" 
                                       id="floatingPassword" 
                                       placeholder="Password" 
                                       maxlength="128"
                                       required>
                                <label for="floatingPassword">Password *</label>
                                <div class="password-requirements">
                                    Password must be at least 6 characters long
                                </div>
                                <?php if (!empty($password_err)): ?>
                                    <div class="text-danger error-message"><?php echo $password_err; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">
                                <i class="fas fa-user-plus me-2"></i>Sign Up
                            </button>
                        </form>
                        
                        <p class="text-center mb-0">
                            Already have an Account? <a href="./signin.php" class="text-primary">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
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

    <!-- Custom JavaScript for form validation -->
    <script>
        // Add real-time validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateInput(this);
                });
                
                input.addEventListener('input', function() {
                    // Clear invalid state when user starts typing
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
            
            function validateInput(input) {
                const value = input.value.trim();
                
                switch(input.name) {
                    case 'firstname':
                    case 'lastname':
                        if (!value || !/^[\p{L}\s\'-]{1,50}$/u.test(value)) {
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        }
                        break;
                    case 'email':
                        if (!value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        }
                        break;
                    case 'matric':
                        if (!value || !/^[a-zA-Z0-9\/\-]{3,20}$/.test(value)) {
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        }
                        break;
                    case 'password':
                        if (!value || value.length < 6 || value.length > 128) {
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        }
                        break;
                }
            }
        });
    </script>
</body>

</html>