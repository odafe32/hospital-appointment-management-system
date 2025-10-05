<?php
session_start();
include("../include/connect.php");

if (isset($_SESSION["admin_id"])) {
    $user_id = $_SESSION["admin_id"];

    $sql = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_id = $user_id");
    $fetch = mysqli_fetch_assoc($sql);

    $fullname = $fetch["fullname"];
    $email = $fetch["email"];

    // Handle admin response
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["feedback_id"]) && isset($_POST["admin_response"])) {
        $feedback_id = mysqli_real_escape_string($connect, $_POST["feedback_id"]);
        $admin_response = mysqli_real_escape_string($connect, $_POST["admin_response"]);

        if (!empty($admin_response)) {
            $update_sql = mysqli_query($connect, "UPDATE `feedback` SET admin_response = '$admin_response', admin_response_date = NOW(), is_read = 1 WHERE feedback_id = $feedback_id");

            if ($update_sql) {
                echo '
                    <script>
                        alert("Response sent successfully!");
                        window.location.href="feedback-management.php";
                    </script>
                ';
                exit();
            } else {
                echo '
                    <script>
                        alert("Error sending response. Please try again.");
                        window.history.back();
                    </script>
                ';
                exit();
            }
        } else {
            echo '
                <script>
                    alert("Please provide a response.");
                    window.history.back();
                </script>
            ';
            exit();
        }
    }

    // Handle mark as read
    if (isset($_GET["mark_read"]) && !empty($_GET["mark_read"])) {
        $feedback_id = mysqli_real_escape_string($connect, $_GET["mark_read"]);
        mysqli_query($connect, "UPDATE `feedback` SET is_read = 1 WHERE feedback_id = $feedback_id");
        header("Location: feedback-management.php");
        exit();
    }

    // Get feedback statistics
    $total_feedback = mysqli_query($connect, "SELECT COUNT(*) as count FROM `feedback`");
    $total_feedback_row = mysqli_fetch_assoc($total_feedback);
    $total_count = $total_feedback_row["count"];

    $unread_feedback = mysqli_query($connect, "SELECT COUNT(*) as count FROM `feedback` WHERE is_read = 0");
    $unread_feedback_row = mysqli_fetch_assoc($unread_feedback);
    $unread_count = $unread_feedback_row["count"];

    $recent_feedback = mysqli_query($connect, "SELECT COUNT(*) as count FROM `feedback` WHERE feedback_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $recent_feedback_row = mysqli_fetch_assoc($recent_feedback);
    $recent_count = $recent_feedback_row["count"];
    $student_feedback = mysqli_query($connect, "SELECT COUNT(*) as count FROM `feedback` WHERE student_id IS NOT NULL");
    $student_feedback_row = mysqli_fetch_assoc($student_feedback);
    $student_count = $student_feedback_row["count"];

    $doctor_feedback = mysqli_query($connect, "SELECT COUNT(*) as count FROM `feedback` WHERE doctor_id IS NOT NULL");
    $doctor_feedback_row = mysqli_fetch_assoc($doctor_feedback);
    $doctor_count = $doctor_feedback_row["count"];
} else {
    echo "
    <script>
        alert('Oops! You are not logged in!');
        window.location.href='../signin.php';
    </script>
    ";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MeCare - Feedback & Reports Management</title>
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
        .feedback-card {
            border-left: 4px solid #007bff;
            transition: all 0.3s ease;
        }
        .feedback-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .feedback-card.unread {
            border-left-color: #dc3545;
            background-color: #fff5f5;
        }
        .rating-display {
            color: #ffd700;
        }
        .response-form {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
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
                        <h6 class="mb-0"><?php echo $fullname;?></h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link"><i class="fas fa-columns me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-calendar me-2"></i>Appointments</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="./new-appointments.php" class="nav-item nav-link"><i class="fas fa-calendar-check me-2"></i>New Appointments</a>
                            <a href="./approved-appointments.php" class="nav-item nav-link"><i class="fas fa-check-circle me-2"></i>Approved Appointments</a>
                            <a href="./cancelled-appointments.php" class="nav-item nav-link"><i class="fas fa-times-circle me-2"></i>Cancelled Appointments</a>
                            <a href="all-appointments.php" class="nav-item nav-link"><i class="fas fa-history me-2"></i>All Appointments history</a>
                        </div>
                    </div>

                    <a href="feedback-management.php" class="nav-item nav-link active"><i class="fas fa-comments me-2"></i>Feedback Management</a>
                    <a href="add_doctor.php" class="nav-item nav-link"><i class="fas fa-user-md me-2"></i>Add Doctor</a>
                    <a href="view_doctor.php" class="nav-item nav-link"><i class="fas fa-users me-2"></i>View Doctor</a>
                    <a href="patient.php" class="nav-item nav-link"><i class="fas fa-users me-2"></i>Patient</a>

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
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <?php
                            $appt_msg = mysqli_query($connect, "SELECT * FROM `appointment` WHERE appointment_status = 'PENDING' ORDER BY booking_time ASC LIMIT 5");
                            while ($appt_msg_row = mysqli_fetch_assoc($appt_msg)) {
                                $appointment_id = $appt_msg_row["appointment_id"];
                                $appointment_date = $appt_msg_row["appointment_date"];
                                $appointment_date = strtotime($appointment_date);
                                $appointment_date = date("D, d-M-Y", $appointment_date);

                                $appointment_time = $appt_msg_row["appointment_time"];
                                $appointment_time = strtotime($appointment_time);
                                $appointment_time = date("h:i:s a", $appointment_time);

                                echo '
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">' . $appointment_id . ' booked an appointment</h6>
                                        <small>' . $appointment_date . " " . $appointment_time . '</small>
                                    </div>
                                </div>
                                <hr class="dropdown-divider">
                                ';
                            }
                            ?>
                            <a href="new-appointments.php" class="dropdown-item text-center">View all appointments</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="profile.php" class="dropdown-item">My Profile</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Inner Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2 class="mb-3">
                                <i class="fas fa-comments text-primary me-2"></i>Feedback Management
                            </h2>
                            <p class="text-muted">Manage and respond to user feedback</p>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3 class="card-title"><?php echo $total_count; ?></h3>
                                    <p class="card-text">Total</p>
                                    <i class="fas fa-comments fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h3 class="card-title"><?php echo $student_count; ?></h3>
                                    <p class="card-text">From Patients</p>
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3 class="card-title"><?php echo $doctor_count; ?></h3>
                                    <p class="card-text">From Staff</p>
                                    <i class="fas fa-user-md fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h3 class="card-title"><?php echo $unread_count; ?></h3>
                                    <p class="card-text">Unread</p>
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Options -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" class="row g-3">
                                        <div class="col-md-3">
                                            <select class="form-select" name="type">
                                                <option value="">All Types</option>
                                                <option value="GENERAL">General</option>
                                                <option value="APPOINTMENT">Appointment</option>
                                                <option value="DOCTOR">Doctor</option>
                                                <option value="SYSTEM">System</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select" name="user_type">
                                                <option value="">All Users</option>
                                                <option value="student">Patients</option>
                                                <option value="doctor">Staff</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="date_from">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="feedback-management.php" class="btn btn-secondary">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback List -->
                    <div class="row">
                        <?php
                        // Build query based on filters
                        $where_clauses = [];
                        if (isset($_GET["type"]) && !empty($_GET["type"])) {
                            $where_clauses[] = "feedback_type = '" . mysqli_real_escape_string($connect, $_GET["type"]) . "'";
                        }
                        if (isset($_GET["user_type"]) && !empty($_GET["user_type"])) {
                            if ($_GET["user_type"] == "student") {
                                $where_clauses[] = "student_id IS NOT NULL";
                            } elseif ($_GET["user_type"] == "doctor") {
                                $where_clauses[] = "doctor_id IS NOT NULL";
                            }
                        }
                        if (isset($_GET["status"]) && !empty($_GET["status"])) {
                            if ($_GET["status"] == "read") {
                                $where_clauses[] = "is_read = 1";
                            } elseif ($_GET["status"] == "unread") {
                                $where_clauses[] = "is_read = 0";
                            }
                        }
                        if (isset($_GET["date_from"]) && !empty($_GET["date_from"])) {
                            $where_clauses[] = "feedback_date >= '" . mysqli_real_escape_string($connect, $_GET["date_from"]) . "'";
                        }

                        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

                        $feedback_query = mysqli_query($connect, "SELECT f.*, s.firstname as student_fname, s.lastname as student_lname, s.othername as student_oname, d.firstname as doctor_fname, d.lastname as doctor_lname, d.othername as doctor_oname FROM `feedback` f LEFT JOIN `student` s ON f.student_id = s.student_id LEFT JOIN `doctor` d ON f.doctor_id = d.doctor_id $where_sql ORDER BY f.feedback_date DESC");

                        if (mysqli_num_rows($feedback_query) > 0) {
                            while ($feedback = mysqli_fetch_assoc($feedback_query)) {
                                $is_unread = $feedback["is_read"] == 0;
                                $card_class = $is_unread ? "feedback-card unread" : "feedback-card";

                                // Determine user info
                                if (!empty($feedback["student_id"])) {
                                    $user_name = htmlspecialchars(($feedback["student_fname"] ?? "Unknown") . " " . ($feedback["student_lname"] ?? ""));
                                    $user_type_text = "Patient";
                                    $user_icon = "fas fa-user";
                                    $badge_color = "info";
                                } else {
                                    $user_name = htmlspecialchars(($feedback["doctor_fname"] ?? "Unknown") . " " . ($feedback["doctor_lname"] ?? ""));
                                    $user_type_text = "Staff";
                                    $user_icon = "fas fa-user-md";
                                    $badge_color = "success";
                                }

                                $priority_class = 'priority-' . strtolower($feedback["priority"] ?? 'medium');

                                echo '
                                <div class="col-md-12 mb-3">
                                    <div class="card ' . $card_class . '">
                                        <div class="user-type-badge">
                                            <span class="badge bg-' . $badge_color . '">
                                                <i class="' . $user_icon . ' me-1"></i>' . $user_type_text . '
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="card-title mb-1">' . htmlspecialchars($feedback["subject"]) . '</h6>
                                                    <p class="card-text text-muted small mb-2">
                                                        <i class="' . $user_icon . ' me-1"></i>' . $user_name . '
                                                        <i class="fas fa-calendar ms-3 me-1"></i>' . date("d M Y, h:i A", strtotime($feedback["feedback_date"])) . '
                                                        <span class="ms-3 badge bg-' . ($feedback["feedback_type"] == 'FEEDBACK' ? 'primary' : ($feedback["feedback_type"] == 'COMPLAINT' ? 'danger' : ($feedback["feedback_type"] == 'SUGGESTION' ? 'info' : 'warning'))) . '">' . $feedback["feedback_type"] . '</span>
                                                        <span class="ms-2 ' . $priority_class . '">' . ($feedback["priority"] ?? 'MEDIUM') . '</span>
                                                    </p>
                                                </div>
                                                <div class="text-end">
                                                    ' . ($is_unread ? '<span class="badge bg-danger">Unread</span>' : '<span class="badge bg-success">Read</span>') . '
                                                </div>
                                            </div>

                                            <p class="card-text mb-3">' . nl2br(htmlspecialchars($feedback["message"])) . '</p>';

                                // Show admin response if exists
                                if (!empty($feedback["admin_response"])) {
                                    echo '
                                    <div class="alert alert-info">
                                        <strong><i class="fas fa-reply me-1"></i>Admin Response:</strong><br>
                                        ' . nl2br(htmlspecialchars($feedback["admin_response"])) . '
                                        <br><small class="text-muted">' . date("d M Y, h:i A", strtotime($feedback["admin_response_date"])) . '</small>
                                    </div>';
                                }

                                // Show response form for unread feedback
                                if ($is_unread) {
                                    echo '
                                    <div class="response-form">
                                        <form method="POST">
                                            <input type="hidden" name="feedback_id" value="' . $feedback["feedback_id"] . '">
                                            <div class="mb-3">
                                                <label for="admin_response_' . $feedback["feedback_id"] . '" class="form-label">Your Response:</label>
                                                <textarea class="form-control" name="admin_response" rows="3" placeholder="Type your response..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-paper-plane me-1"></i>Send Response
                                            </button>
                                            <a href="feedback-management.php?mark_read=' . $feedback["feedback_id"] . '" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-check me-1"></i>Mark as Read
                                            </a>
                                        </form>
                                    </div>';
                                }

                                echo '</div>
                                    </div>
                                </div>';
                            }
                        } else {
                            echo '
                            <div class="col-md-12">
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                                    <h5>No feedback found</h5>
                                    <p>There are no feedback entries matching your criteria.</p>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Inner End -->

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
