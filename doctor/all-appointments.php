<?php 
session_start();
include("../include/connect.php");


if (isset($_SESSION["doctor_id"])) {

    //LOGGED IN USER ID
    $user_id = $_SESSION["doctor_id"];
    
    $sql = mysqli_query($connect,"SELECT * FROM `doctor` WHERE doctor_id = $user_id");
    
    $fetch = mysqli_fetch_assoc($sql);
    
    
    $firstname = $fetch["firstname"];
    $lastname = $fetch["lastname"];
    $othername = $fetch["othername"];
    $email = $fetch["email"];
}else {
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
    <title>CLINICAL BOOKING SYSTEM APP-CBSA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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

    
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>CBSA</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $firstname . " " . $lastname ?></h6>
                        <span>Doctor</span>
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

                    <a href="all-appointments.php" class="nav-item nav-link active"><i class="fas fa-history me-2"></i>All Appointments history</a>
        
                        </div>
                    </div>

                    <a href="report.php" class="nav-item nav-link"><i class="fas fa-comment me-2"></i>Report</a>

                    <a href="#" onclick="logout()" class="nav-item nav-link"> <i class="fas fa-sign-out-alt me-2"></i>
                        Logout</a>
                    
                    </div>
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
                            <a href="./new-appointments.php" class="dropdown-item">
    <?php
        //fetching top 5 pending appointment
        $appt_msg = mysqli_query($connect,"SELECT * FROM `appointment` WHERE appointment_status = 'PENDING' ORDER BY booking_time ASC LIMIT 5");
        while ($appt_msg_row = mysqli_fetch_assoc($appt_msg)) {
            $appointment_id = $appt_msg_row["appointment_id"];
            $appointment_date = $appt_msg_row["appointment_date"];
             //Modifying appointment date
             $appointment_date = strtotime($appointment_date);
             $appointment_date = date("D, d-M-Y",$appointment_date);
             
            $appointment_time = $appt_msg_row["appointment_time"];
             //Modifying appointment time
            $appointment_time = strtotime($appointment_time);
            $appointment_time = date("h:i:s a",$appointment_time);
             
            echo '
            <div class="d-flex align-items-center">
                <img class="rounded-circle" src="./img/user.png" alt="" style="width: 40px; height: 40px;">
                <div class="ms-2">
                    <h6 class="fw-normal mb-0">'. $appointment_id .' booked an appointment</h6>
                    <small>'. $appointment_date ." " . $appointment_time .'</small>
                </div>
            </div>
            ';
        }

    ?>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="new-appointments.php" class="dropdown-item text-center">View all appointment</a>
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

                <div class="container mt-5">
    <h2 class="mb-4">All appointments</h2>
    <div class="row">
        <form class="col-sm-4 ms-auto d-flex mb-5" action="search.php" method="get">
            <input class="form-control border-0" type="search" name="search" placeholder="Search">
            <input class="btn btn-outline-primary" value="Search" type="submit">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
//Fetching number of declined appointment per status
$pending_appt = mysqli_query($connect,"SELECT * FROM `appointment` INNER JOIN `student` ON appointment.student_id = student.student_id");
    

                while ($pending_appt_fetch = mysqli_fetch_assoc($pending_appt)) {
                    $patient_firstname = $pending_appt_fetch["firstname"];
                    $patient_lastname = $pending_appt_fetch["lastname"];
                    if (isset($pending_appt_fetch["othername"])) {
                        $patient_othername = $pending_appt_fetch["othername"];
                    }else{
                        $patient_othername = null;
                    }
                    $appointment_id = $pending_appt_fetch["appointment_id"];
                    $appointment_date = $pending_appt_fetch["appointment_date"];
                     //Modifying appointment date
                     $appointment_date = strtotime($appointment_date);
                     $appointment_date = date("D, d-M-Y",$appointment_date);
                     
                     $appointment_time = $pending_appt_fetch["appointment_time"];
                     //Modifying appointment time
                     $appointment_time = strtotime($appointment_time);
                     $appointment_time = date("h:i:s a",$appointment_time);
                    $appointment_status = $pending_appt_fetch["appointment_status"];

                    switch ($appointment_status) {
                        case 'PENDING':
                            echo '
                                <tr>
                                    <td>'.$patient_firstname . " " . $patient_lastname ." ".$patient_othername.' </td>
                                    <td>'. $appointment_id  .'</td>
                                    <td>'. $appointment_date  .'</td>
                                    <td>'. $appointment_time  .'</td>
                                    <td class="text-warning">'. $appointment_status  .'</td>
                                </tr>
                            ';                                    
                            break;

                            case 'DECLINED':
                                echo '
                                    <tr>
                                        <td>'.$patient_firstname . " " . $patient_lastname ." ".$patient_othername.' </td>
                                        <td>'. $appointment_id  .'</td>
                                        <td>'. $appointment_date  .'</td>
                                        <td>'. $appointment_time  .'</td>
                                        <td class="text-danger">'. $appointment_status  .'</td>
                                    </tr>
                                ';                                    
                                break;
                        
                        default:
                            echo '
                                <tr>
                                    <td>'.$patient_firstname . " " . $patient_lastname ." ".$patient_othername.' </td>
                                    <td>'. $appointment_id  .'</td>
                                    <td>'. $appointment_date  .'</td>
                                    <td>'. $appointment_time  .'</td>
                                    <td class="text-success">'. $appointment_status  .'</td>
                                </tr>
                            ';                                    
                            break;
                    }
                
                }    
              ?>

            </tbody>
        </table>
    </div>
</div>
        </div>
            </div>
            <!-- Inner End -->

            


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">CBSA</a>, All Right Reserved. 
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        
<!-- Bootstrap JS and Popper.js scripts (needed for Bootstrap components) -->
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

    <!-- Prompt up alert for Logout Javascript -->
    <script>
        function logout() {
            if (confirm('You are about to logout!')) {
                window.location.href="logout.php";
            }
        }
    </script>
</body>

</html>