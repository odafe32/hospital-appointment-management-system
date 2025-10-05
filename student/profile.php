<?php
session_start();
include("../include/connect.php");

if (isset($_SESSION["student_id"])) {
    $user_id = $_SESSION["student_id"];

    $sql = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $user_id");
    $fetch = mysqli_fetch_assoc($sql);

    $firstname = $fetch["firstname"];
    $lastname = $fetch["lastname"];
    $othername = $fetch["othername"];
    $email = $fetch["email"];
    $matric = $fetch["matric"];
    $blood_group = $fetch["blood_group"] ?? 'Not Set';
    $genotype = $fetch["genotype"] ?? 'Not Set';

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
        $new_firstname = mysqli_real_escape_string($connect, $_POST["firstname"]);
        $new_lastname = mysqli_real_escape_string($connect, $_POST["lastname"]);
        $new_othername = mysqli_real_escape_string($connect, $_POST["othername"]);
        $new_email = mysqli_real_escape_string($connect, $_POST["email"]);
        $new_blood_group = mysqli_real_escape_string($connect, $_POST["blood_group"]);
        $new_genotype = mysqli_real_escape_string($connect, $_POST["genotype"]);

        // Validate required fields
        if (empty($new_firstname) || empty($new_lastname) || empty($new_email)) {
            $error_message = "Please fill in all required fields.";
        } else {
            // Update profile
            $update_sql = mysqli_query($connect, "UPDATE `student` SET
                `firstname`='$new_firstname',
                `lastname`='$new_lastname',
                `othername`='$new_othername',
                `email`='$new_email',
                `blood_group`='$new_blood_group',
                `genotype`='$new_genotype'
                WHERE student_id = $user_id");

            if ($update_sql) {
                echo '<script>alert("Profile updated successfully!"); window.location.href="profile.php";</script>';
                exit();
            } else {
                $error_message = "Error updating profile. Please try again.";
            }
        }
    }

    // Handle password change
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        if (strlen($new_password) < 6) {
            $password_error = "Password must be at least 6 characters long.";
        } elseif ($new_password !== $confirm_password) {
            $password_error = "New passwords do not match.";
        } else {
            // Verify current password
            if (password_verify($current_password, $fetch["password"])) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password = mysqli_query($connect, "UPDATE `student` SET `password`='$hashed_password' WHERE student_id = $user_id");

                if ($update_password) {
                    $password_success = "Password changed successfully!";
                } else {
                    $password_error = "Error changing password. Please try again.";
                }
            } else {
                $password_error = "Current password is incorrect.";
            }
        }
    }
} else {
    echo "<script>alert('Please login to continue.'); window.location.href='../signin.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MeCare - My Profile</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <?php require_once("../include/favicon.php")?>

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
        .profile-header {
            background:  #667eea;
            color: white;
            padding: 60px 0;
            margin-bottom: 30px;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-info-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 1.1rem;
            color: #495057;
            margin-bottom: 20px;
        }
        .form-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
        }
        .btn-custom {
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">MeCare</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $firstname . " " . $lastname; ?></h6>
                        <span>Patient</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link"><i class="fas fa-columns me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-calendar me-2"></i>Appointments</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="book-appointment.php" class="nav-item nav-link"><i class="fas fa-calendar-plus me-2"></i>Book Appointment</a>
                            <a href="appointment-status.php" class="nav-item nav-link"><i class="fas fa-info-circle"></i>Appointment Status</a>
                            <a href="all-appointments.php" class="nav-item nav-link"><i class="fas fa-history me-2"></i>All Appointment history</a>
                        </div>
                    </div>

                    <a href="feedback.php" class="nav-item nav-link"><i class="fas fa-comments me-2"></i>Feedback & Reports</a>
                    <a href="profile.php" class="nav-item nav-link active"><i class="fas fa-user me-2"></i>My Profile</a>

                    <a href="#" onclick="logout()" class="nav-item nav-link mt-5"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Messages</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <?php
                            $select_msg = mysqli_query($connect, "SELECT * FROM `appointment` WHERE student_id = $user_id ORDER BY appointment_date DESC LIMIT 3");
                            if (mysqli_num_rows($select_msg) > 0) {
                                while ($fetch_msg = mysqli_fetch_assoc($select_msg)) {
                                    $appointment_id = $fetch_msg["appointment_id"];
                                    $appointment_status = $fetch_msg["appointment_status"];
                                    $appointment_date = date("d M Y", strtotime($fetch_msg["appointment_date"]));

                                    echo '
                                    <a href="appointment-status.php" class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="ms-2">
                                                <h6 class="fw-normal mb-0">' . $appointment_id . '</h6>
                                                <small>' . $appointment_status . ' - ' . $appointment_date . '</small>
                                            </div>
                                        </div>
                                    </a>
                                    <hr class="dropdown-divider">
                                    ';
                                }
                            } else {
                                echo '<a href="#" class="dropdown-item">No recent appointments</a>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $firstname; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="profile.php" class="dropdown-item">My Profile</a>
                            <a href="#" onclick="logout()" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Profile Header Start -->
            <div class="profile-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="profile-avatar">
                                <img src="./img/user.png" alt="Profile Picture" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h1 class="mb-2" style="color: #fff"><?php echo $firstname . " " . $lastname; ?></h1>
                            <p class="mb-1"><i class="fas fa-envelope me-2"></i><?php echo $email; ?></p>
                            <p class="mb-1"><i class="fas fa-id-card me-2"></i>Matric: <?php echo $matric; ?></p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Patient Portal</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Profile Header End -->

            <!-- Profile Content Start -->
            <div class="container-fluid pt-4 px-4">
                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($password_success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $password_success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Profile Information -->
                    <div class="col-md-8">
                        <div class="profile-info-card">
                            <h4 class="section-title">
                                <i class="fas fa-user-circle me-2"></i>Personal Information
                            </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-label">First Name</div>
                                    <div class="info-value"><?php echo $firstname; ?></div>

                                    <div class="info-label">Last Name</div>
                                    <div class="info-value"><?php echo $lastname; ?></div>

                                    <div class="info-label">Other Name</div>
                                    <div class="info-value"><?php echo $othername ?: 'Not provided'; ?></div>

                                    <div class="info-label">Email Address</div>
                                    <div class="info-value"><?php echo $email; ?></div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-label">Matric Number</div>
                                    <div class="info-value"><?php echo $matric; ?></div>

                                    <div class="info-label">Blood Group</div>
                                    <div class="info-value"><?php echo $blood_group; ?></div>

                                    <div class="info-label">Genotype</div>
                                    <div class="info-value"><?php echo $genotype; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Forms -->
                    <div class="col-md-4">
                        <!-- Personal Information Edit -->
                        <div class="form-section">
                            <h5 class="section-title">Edit Personal Information</h5>

                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Other Name</label>
                                    <input type="text" class="form-control" name="othername" value="<?php echo $othername; ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                                </div>

                                <button type="submit" name="update_profile" class="btn btn-primary btn-custom">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                            </form>
                        </div>

                        <!-- Medical Information Edit -->
                        <div class="form-section">
                            <h5 class="section-title">Edit Medical Information</h5>

                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Blood Group</label>
                                    <select class="form-select" name="blood_group">
                                        <option value="">Select Blood Group</option>
                                        <option value="A+" <?php echo $blood_group == 'A+' ? 'selected' : ''; ?>>A+</option>
                                        <option value="A-" <?php echo $blood_group == 'A-' ? 'selected' : ''; ?>>A-</option>
                                        <option value="B+" <?php echo $blood_group == 'B+' ? 'selected' : ''; ?>>B+</option>
                                        <option value="B-" <?php echo $blood_group == 'B-' ? 'selected' : ''; ?>>B-</option>
                                        <option value="AB+" <?php echo $blood_group == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                                        <option value="AB-" <?php echo $blood_group == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                                        <option value="O+" <?php echo $blood_group == 'O+' ? 'selected' : ''; ?>>O+</option>
                                        <option value="O-" <?php echo $blood_group == 'O-' ? 'selected' : ''; ?>>O-</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Genotype</label>
                                    <select class="form-select" name="genotype">
                                        <option value="">Select Genotype</option>
                                        <option value="AA" <?php echo $genotype == 'AA' ? 'selected' : ''; ?>>AA</option>
                                        <option value="AS" <?php echo $genotype == 'AS' ? 'selected' : ''; ?>>AS</option>
                                        <option value="SS" <?php echo $genotype == 'SS' ? 'selected' : ''; ?>>SS</option>
                                        <option value="AC" <?php echo $genotype == 'AC' ? 'selected' : ''; ?>>AC</option>
                                    </select>
                                </div>

                                <button type="submit" name="update_profile" class="btn btn-success btn-custom">
                                    <i class="fas fa-heartbeat me-2"></i>Update Medical Info
                                </button>
                            </form>
                        </div>

                        <!-- Password Change -->
                        <div class="form-section">
                            <h5 class="section-title">Change Password</h5>

                            <?php if (isset($password_error)): ?>
                            <div class="alert alert-danger"><?php echo $password_error; ?></div>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="new_password" minlength="6" required>
                                    <small class="form-text text-muted">Minimum 6 characters</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>

                                <button type="submit" name="change_password" class="btn btn-warning btn-custom">
                                    <i class="fas fa-key me-2"></i>Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Profile Content End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">MeCare</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Bootstrap JS and Popper.js scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

        <script>
            function logout() {
                if (confirm('You are about to logout!')) {
                    window.location.href = "logout.php";
                }
            }
        </script>
</body>

</html>
