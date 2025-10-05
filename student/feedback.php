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

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $feedback_type = mysqli_real_escape_string($connect, $_POST["feedback_type"]);
        $category = mysqli_real_escape_string($connect, $_POST["category"]);
        $priority = mysqli_real_escape_string($connect, $_POST["priority"]);
        $subject = mysqli_real_escape_string($connect, $_POST["subject"]);
        $message = mysqli_real_escape_string($connect, $_POST["message"]);

        // Validate required fields
        if (empty($feedback_type) || empty($category) || empty($subject) || empty($message)) {
            echo '
                <script>
                    alert("Please fill in all required fields.");
                    window.history.back();
                </script>
            ';
            exit();
        }

        // Insert feedback
        $insert_sql = mysqli_query($connect, "INSERT INTO `feedback` (student_id, feedback_type, category, priority, subject, message) VALUES ($user_id, '$feedback_type', '$category', '$priority', '$subject', '$message')");

        if ($insert_sql) {
            echo '
                <script>
                    alert("Thank you for your feedback! We will review it and respond if necessary.");
                    window.location.href="feedback.php";
                </script>
            ';
            exit();
        } else {
            echo '
                <script>
                    alert("Error submitting feedback. Please try again.");
                    window.history.back();
                </script>
            ';
            exit();
        }
    }
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
    <title>MeCare - Feedback</title>
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
        .feedback-form {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            margin: 10px 0;
        }
        .rating-stars input {
            display: none;
        }
        .rating-stars label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #ffd700;
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

                    <a href="feedback.php" class="nav-item nav-link active"><i class="fas fa-comments me-2"></i>Feedback</a>

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
                            $select_msg = mysqli_query($connect, "SELECT * FROM `appointment` WHERE student_id = $user_id ORDER BY appointment_date DESC LIMIT 5");
                            while ($fetch_msg = mysqli_fetch_assoc($select_msg)) {
                                $appointment_id = $fetch_msg["appointment_id"];
                                $appointment_status = $fetch_msg["appointment_status"];
                                $appointment_date = $fetch_msg["appointment_date"];

                                switch ($appointment_status) {
                                    case 'PENDING':
                                        echo '
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                                            <div class="ms-2">
                                                <h6 class="fw-normal mb-0">Hi! ' . $appointment_id . ' is ' . $appointment_status . '</h6>
                                                <small>' . $appointment_date . '</small>
                                            </div>
                                        </div>
                                        <hr class="dropdown-divider">
                                        ';
                                        break;
                                    default:
                                        echo '
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                                            <div class="ms-2">
                                                <h6 class="fw-normal mb-0">Hi! ' . $appointment_id . ' was ' . $appointment_status . '</h6>
                                                <small>' . $appointment_date . '</small>
                                            </div>
                                        </div>
                                        <hr class="dropdown-divider">
                                        ';
                                        break;
                                }
                            }
                            ?>
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
                    <div class="feedback-form">
                        <h2 class="text-center mb-4">
                            <i class="fas fa-comments text-primary me-2"></i>Share Your Feedback
                        </h2>
                        <p class="text-muted text-center mb-4">Help us improve our services by sharing your experience</p>

                        <form action="feedback.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="feedback_type" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="feedback_type" name="feedback_type" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="FEEDBACK">Feedback</option>
                                        <option value="COMPLAINT">Complaint</option>
                                        <option value="SUGGESTION">Suggestion</option>
                                        <option value="BUG_REPORT">Bug Report</option>
                                        <option value="FEATURE_REQUEST">Feature Request</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">-- Select Category --</option>
                                        <option value="APPOINTMENT">Appointment System</option>
                                        <option value="WEBSITE">Website/Interface</option>
                                        <option value="STAFF">Staff/Doctor</option>
                                        <option value="FACILITY">Hospital Facility</option>
                                        <option value="TECHNICAL">Technical Issue</option>
                                        <option value="OTHER">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority Level</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="LOW">Low</option>
                                    <option value="MEDIUM" selected>Medium</option>
                                    <option value="HIGH">High</option>
                                    <option value="URGENT">Urgent</option>
                                </select>
                                <small class="form-text text-muted">How important is this feedback?</small>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Brief summary of your feedback" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Your Feedback <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Please share your detailed feedback, suggestions, or concerns..." required></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                                </button>
                                <a href="dashboard.php" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Display recent feedback -->
                    <div class="mt-5">
                        <h4 class="mb-3">Your Recent Feedback & Reports</h4>
                        <?php
                        $feedback_query = mysqli_query($connect, "SELECT * FROM `feedback` WHERE student_id = $user_id ORDER BY feedback_date DESC LIMIT 5");

                        if (mysqli_num_rows($feedback_query) > 0) {
                            while ($feedback = mysqli_fetch_assoc($feedback_query)) {
                                $priority_class = 'priority-' . strtolower($feedback["priority"] ?? 'medium');
                                echo '
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title">' . htmlspecialchars($feedback["subject"]) . '</h6>
                                                <p class="card-text text-muted small mb-2">
                                                    <i class="fas fa-calendar me-1"></i>' . date("d M Y, h:i A", strtotime($feedback["feedback_date"])) . '
                                                    <span class="ms-3 badge bg-' . ($feedback["feedback_type"] == 'FEEDBACK' ? 'primary' : ($feedback["feedback_type"] == 'COMPLAINT' ? 'danger' : ($feedback["feedback_type"] == 'SUGGESTION' ? 'info' : 'warning'))) . '">' . $feedback["feedback_type"] . '</span>
                                                    <span class="ms-2 ' . $priority_class . '">' . ($feedback["priority"] ?? 'MEDIUM') . '</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="card-text">' . nl2br(htmlspecialchars(substr($feedback["message"], 0, 150))) . (strlen($feedback["message"]) > 150 ? '...' : '') . '</p>';

                                // Show admin response if exists
                                if (!empty($feedback["admin_response"])) {
                                    echo '
                                    <div class="alert alert-info mt-3">
                                        <strong><i class="fas fa-reply me-1"></i>Admin Response:</strong><br>
                                        ' . nl2br(htmlspecialchars($feedback["admin_response"])) . '
                                        <br><small class="text-muted">' . date("d M Y, h:i A", strtotime($feedback["admin_response_date"])) . '</small>
                                    </div>';
                                }

                                echo '</div>
                                </div>';
                            }
                        } else {
                            echo '<p class="text-muted">No feedback or reports submitted yet.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Inner End -->
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
