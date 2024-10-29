<?php 
session_start();
include("../include/connect.php");

$firstname_err = null;
$lastname_err = null;
$othername_err = null;
$email_err = null;
$password_err = null;


if (isset($_SESSION["admin_id"])) {

    //LOGGED IN USER ID
    $user_id = $_SESSION["admin_id"];
    
    $sql = mysqli_query($connect,"SELECT * FROM `admin` WHERE admin_id = $user_id");
    
    $fetch = mysqli_fetch_assoc($sql);
    
    
    $fullname = $fetch["fullname"];
    $email = $fetch["email"];

    // Including Module for editing Doctor information
    include("./edit-doctor.php"); 

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
    <title>CLINICAL BOOKING SYSTEM APP</title>
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
        body {
          background-color: #f8f9fa;
        }
        .personal-card {   
        max-width: 800px;
          margin: 50px auto;
          border-radius: 10px;
          box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .personal-card .card-body {
          padding: 20px;
        }
        .personal-card .card-title {
          color: #007bff;
          font-size: 24px;
          margin-bottom: 15px;
        }
        .info-row {
          display: flex;
          justify-content: space-between;
          margin-bottom: 15px;
        }
        .info-row h6 {
          color: #6c757d;
          font-size: 14px;
          margin: 0;
        }
        .info-row p {
          font-size: 16px;
          margin: 0;
          font-weight: bold; /* to make the name bold */
        }
        .truncated {
      max-width: 180px; /* Adjust the max-width as needed */
      overflow: hidden;
      /* text-overflow: ellipsis; */
      white-space: wrap;
    }
      </style>
    
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
                                    <h3 class="text-primary">MediPro</h3>
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

                    <a href="add_doctor.php" class="nav-item nav-link"><i class="fas fa-comment me-2"></i>Add Doctor</a>

                    <a href="view_doctor.php" class="nav-item nav-link active"><i class="fas fa-comment me-2"></i>View Doctor</a>
                    
                    <a href="patient.php" class="nav-item nav-link"><i class="fas fa-comment me-2"></i>Patient</a>

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


        




            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                


<div class="container mt-5">
<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
//Selecting Registered Doctors
$reg_doc = mysqli_query($connect,"SELECT * FROM `doctor`");
    

                while ($reg_doc_fetch = mysqli_fetch_assoc($reg_doc)) {
                    $doctor_id = $reg_doc_fetch["doctor_id"];
                    $doctor_firstname = $reg_doc_fetch["firstname"];
                    $doctor_lastname = $reg_doc_fetch["lastname"];
                    $doctor_othername = $reg_doc_fetch["othername"] ?? null;
                    $doctor_email = $reg_doc_fetch["email"];
                    $doctor_password = $reg_doc_fetch["password"];
                    $doctor_specialization = $reg_doc_fetch["specialization"] ?? 'Not set';
                    
                    echo '
                                <tr>
                                    <td>'.$doctor_firstname . " " . $doctor_lastname ." ".$doctor_othername.' </td>
                                    <td>'. $doctor_email  .'</td>
                                    <td>'. $doctor_specialization  .'</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-target="#changePasswordModal'.$doctor_id.'" data-bs-toggle="modal">Edit</button>
                                        <a href="delete-doctor.php?doctor_id='. $doctor_id .'" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                    
                                </tr>
                            ';                           
                            

                            echo '
                            <!-- Modal for changing Doctor Password  -->
                            <div class="modal fade" id="changePasswordModal'.$doctor_id.'" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form action="view_doctor.php" method="POST">
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="doctor_id" class="form-control" id="floatingText" value="'.$doctor_id .'" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="firstname" class="form-control" id="floatingText" value="'.$doctor_firstname .'" required>
                                    <label for="floatingText">First Name</label>
                                    <p class="text-danger"> '.$firstname_err.'</p>
                                </div>
            
                                <div class="form-floating mb-3">
                                    <input type="text" name="lastname" class="form-control" id="floatingText" value="'.$doctor_lastname .'" required>
                                    <label for="floatingText">Last Name</label>
                                    <p class="text-danger">'.$lastname_err.'</p>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" name="othername" class="form-control" id="floatingText" value="'.$doctor_othername .'">
                                    <label for="floatingText">Other Name</label>
                                    <p class="text-danger"> '.$othername_err.'</p>
                                </div>
            
            
                                <div class="form-floating mb-4">
                                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="New Password" required>
                                    <label for="floatingPassword">Password</label>
                                    <p class="text-danger">'.$password_err.'</p>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Save</button>
                            </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>
                    <!--End of  Modal for changing Doctor Password -->            
                            
                            ';
                            
                
                }    
              ?>


            </tbody>
        </table>
    </div> 
</div>


        
                    
            
                    










                </div>
            </div>
            <!-- Recent Sales End -->


            


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">MediPro</a>, All Right Reserved. 
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

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