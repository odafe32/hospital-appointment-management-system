<?php
session_start();
include("../include/connect.php");

if (isset($_SESSION["student_id"])) {

  //LOGGED IN USER ID
  $user_id = $_SESSION["student_id"];

  $sql = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $user_id");

  $fetch = mysqli_fetch_assoc($sql);


  $firstname = $fetch["firstname"];
  $lastname = $fetch["lastname"];
  $othername = $fetch["othername"];
  $email = $fetch["email"];
  $matric = $fetch["matric"];
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
  <title>CLINICAL BOOKING SYSTEM APP-CBSA</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="cbsa" name="keywords">
  <meta content="Clinical booking system app for nsuk " name="description">

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
    <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
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
            <h6 class="mb-0"><?php echo $firstname . " " . $lastname; ?></h6>
            <span>Student</span>
          </div>
        </div>
        <div class="navbar-nav w-100">
          <a href="dashboard.php" class="nav-item nav-link"><i class="fas fa-columns me-2"></i>Dashboard</a>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-calendar me-2"></i>Appointments</a>
            <div class="dropdown-menu bg-transparent border-0">
              <a href="book-appointment.php" class="nav-item nav-link"><i class="fas fa-calendar-plus me-2"></i>Book Appointment</a>
              <a href="appointment-status.php" class="nav-item nav-link active"><i class="fas fa-info-circle"></i>Appointment Status</a>

              <a href="all-appointments.php" class="nav-item nav-link"><i class="fas fa-history me-2"></i>All Appointment history</a>
            </div>
          </div>


          <a href="report.php" class="nav-item nav-link mb-5"><i class="fas fa-comment me-2"></i>Report</a>

          <a href="#" onclick="logout()" class="nav-item nav-link mt-5"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>

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
            <a href="#" class="dropdown-item">
              <?php
              //Fetching user's appointment status  messages from database
              $select_msg = mysqli_query($connect, "SELECT * FROM `appointment` WHERE student_id = $user_id ORDER BY appointment_date DESC LIMIT 5");


              while ($fetch_msg = mysqli_fetch_assoc($select_msg)) {
                $appointment_id = $fetch_msg["appointment_id"];
                $appointment_status = $fetch_msg["appointment_status"];
                $appointment_date = $fetch_msg["appointment_date"];
                $appointment_time = $fetch_msg["appointment_time"];

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
            </a>
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


        <?php
        // Fetching the user's appointment status
        $appointment_query = mysqli_query($connect, "SELECT * FROM `appointment` WHERE student_id = $user_id ORDER BY booking_time DESC LIMIT 1");

        if ($appointment_query) {
          $appointment_row = mysqli_fetch_assoc($appointment_query);

          $appointment_id = $appointment_row["appointment_id"] ?? null;
          $appointment_status = $appointment_row["appointment_status"] ?? null;
          $appointment_date = $appointment_row["appointment_date"] ?? null;
          $appointment_date = strtotime($appointment_date) ?? null;
          $appointment_date = date("d, D M Y", $appointment_date) ?? null;
          $appointment_time = $appointment_row["appointment_time"] ?? null;
          $appointment_time = strtotime($appointment_time) ?? null;
          $appointment_time = date("h:i:s a", $appointment_time) ?? null;
        }

        switch ($appointment_status) {
          case 'PENDING':
            echo '
       <div class="container" style="margin-top: 50px;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Your Appointment is Pending!</h5>
          <p class="card-text">
            Your appointment has been booked and current status is pending. Check your appointment status regularly to know if it is approved or not.
          </p>
          <button class="btn btn-warning text-white" data-toggle="modal" data-target="#pendingModal">
            View Appointment Details
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap Modal -->
<div class="modal fade" id="pendingModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Appointment ID: ' . $appointment_id . ' </p>
        <p>Date: ' . $appointment_date . '</p>
        <p>Time: ' . $appointment_time . '</p>
      </div>
      <div class="modal-footer">
        <a href="process-cancel-appointment.php?appointment_id=' . $appointment_id . '" class="btn btn-danger">Cancel Appointment</a>
      </div>
    </div>
  </div>
</div>
<!--End of  Bootstrap Modal -->


       ';
            break;


          case 'APPROVED':
            echo '
          <div class="container" style="margin-top: 50px;">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-center">Your Appointment is Approved!</h5>
                  <p class="card-text">
                    Your appointment has been approved. We look forward to seeing you on your scheduled date.
                  </p>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#appointmentModal">
                    View Appointment Details
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        
        <!-- Bootstrap Modal -->
        <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <p>Appointment ID: ' . $appointment_id . ' </p>
              <p>Date: ' . $appointment_date . '</p>
              <p>Time: ' . $appointment_time . '</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!--End of  Bootstrap Modal -->
        
          ';
            break;


          case 'DECLINED':
            echo '
            <div class="container" style="margin-top: 50px;">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title text-center">Your Appointment is Not Approved</h5>
                    <p class="card-text">
                      We regret to inform you that your appointment request has not been approved. If you have any questions or concerns, please contact us.
                    </p>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#declinedModal">
                      View Details
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Bootstrap Modal -->
          <div class="modal fade" id="declinedModal" tabindex="-1" role="dialog" aria-labelledby="declinedModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="declinedModalLabel">Declined Appointment Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Appointment ID: ' . $appointment_id . ' </p>
                  <p>Date: ' . $appointment_date . '</p>
                  <p>Time: ' . $appointment_time . '</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
                      
            ';
            break;


          default:
            echo '
        <div class="container" style="margin-top: 50px;">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">You have not initiated any Appointment yet</h5>
                <p class="card-text">
                  Kindly book for an appointment if you would love to meet our doctors.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>            
        ';
            break;
        }

        ?>











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
        window.location.href = "logout.php";
      }
    }
  </script>
</body>

</html>