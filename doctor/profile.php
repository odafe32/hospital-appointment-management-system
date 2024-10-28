<?php 
session_start();
include("../include/connect.php");

$new_password_err = null;

if (isset($_SESSION["doctor_id"])) {

    //LOGGED IN USER ID
    $user_id = $_SESSION["doctor_id"];
    
    $sql = mysqli_query($connect,"SELECT * FROM `doctor` WHERE doctor_id = $user_id");
    
    $fetch = mysqli_fetch_assoc($sql);
    
    
    $firstname = $fetch["firstname"];
    $lastname = $fetch["lastname"];
    $othername = $fetch["othername"];
    $email = $fetch["email"];
    if (isset($fetch["blood_group"])) {
      $bloodgroup = $fetch["blood_group"];
      $genotype = $fetch["genotype"];      
      $specialization = $fetch["specialization"];      
    }else {
      $bloodgroup = 'Not Set';
      $genotype = 'Not Set';      
      $specialization = 'Not Set';      
    }



    if (isset($_POST["submit"])) {
      $new_firstname = $_POST["firstname"];
      $new_lastname = $_POST["lastname"];
      $new_othername = $_POST["othername"];
      $new_email = $_POST["email"];
      $new_password = $_POST["password"];
      $new_bloodgroup = $_POST["bloodgroup"];
      $new_genotype = $_POST["genotype"];
      $new_specialization = $_POST["specialization"];

      if (strlen($new_password) < 6) {
        echo '
            <script>
              alert("Update not Successful!");
            </script>
        ';
         $new_password_err = "Password value must be up to six(6)";
      }else {
          //hashing updated password
      $new_password = password_hash($new_password,PASSWORD_DEFAULT);



      $updating_profile = mysqli_query($connect,"UPDATE `doctor` SET `firstname`='$new_firstname',`lastname`='$new_lastname',`othername`='$new_othername',`email`='$new_email',`password`='$new_password',`blood_group`='$new_bloodgroup',`genotype`='$new_genotype',`specialization`='$new_specialization' WHERE doctor_id = $user_id");

      if ($updating_profile) {
         echo '
            <script>
              alert("Update Successful!");
              window.location.href="profile.php";
            </script>
         ';
      }        
      }

  }


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

                    <a href="all-appointments.php" class="nav-item nav-link"><i class="fas fa-history me-2"></i>All Appointments history</a>
        
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
                   
                   

                <div class="container w-100">
                        <div class="card personal-card">
                          <div class="card-body w-100">
                            <h4 class="card-title mb-4">Personal Information</h4>
                      
                            <div class="info-row">
                              <h6 class="mb-0">First Name</h6>
                              <p class="mb-0 text-truncate"><?php echo $firstname;?></p>
                            </div>
                      
                            <div class="info-row">
                              <h6 class="mb-0">Last Name</h6>
                              <p class="mb-0 text-truncate"><?php echo $lastname;?></p>
                            </div>
                      
                            <div class="info-row">
                              <h6 class="mb-0">Other Name</h6>
                              <p class="mb-0 text-truncate"><?php echo $othername;?></p>
                            </div>
                      
                            <div class="info-row">
                              <h6 class="mb-0">Email</h6>
                              <p class="mb-0 truncated"><?php echo $email;?></p>
                            </div>

                            
                            <div class="info-row">
                              <h6 class="mb-0">Blood Group</h6>
                              <p class="mb-0 truncated"><?php echo $bloodgroup;?></p>
                            </div>


                            <div class="info-row">
                              <h6 class="mb-0">Genotype</h6>
                              <p class="mb-0 truncated"><?php echo $genotype;?></p>
                            </div>

                            
                            <div class="info-row">
                              <h6 class="mb-0">Specialization</h6>
                              <p class="mb-0 truncated"><?php echo $specialization;?></p>
                            </div>
                          </div>
                        </div>
                      </div>


        
                <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Update</title>
  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 50px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Profile Update</h5>
          <form action="profile.php" method="post">
            <div class="form-group">
              <input type="text" class="form-control" value="<?php echo $firstname?>"  placeholder="First Name" name="firstname" required>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" value="<?php echo $lastname ?>" placeholder="Last Name" name="lastname" required>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" value="<?php echo $othername ?>" placeholder="Other Name" name="othername">
            </div>


            <div class="form-group">
              <input type="email" class="form-control" value="<?php echo $email ?>" placeholder="Email" id="email" name="email" required>
            </div>


            <div class="form-group">
              <input type="password" class="form-control" placeholder="Password" id="email" name="password" required>
            </div>

            <div class="form-group">
              <select class="form-control  bg-danger text-white" id="bloodGroup" name="bloodgroup" required>
              <option value="">----Select Blood Group----</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
              </select>
            </div>

            <div class="form-group">
              <select class="form-control bg-success text-white" id="genotype" name="genotype" required>
              <option value="">----Select Genotype----</option>
                <option value="AA">AA</option>
                <option value="AS">AS</option>
                <option value="SS">SS</option>
                <option value="AC">AC</option>
                <!-- Add more options as needed -->
              </select>
            </div>

            <div class="form-group">
              <select class="form-control  bg-danger text-white" id="bloodGroup" name="specialization" required>
              <option value="">----Select Specialization----</option>
                <option value="A+">Pharmacist</option>
                <option value="A-">Dentist</option>
                <option value="B+">Surgeon</option>
                <option value="B-">Paediatri</option>
                <option value="AB+">Lab tech</option>
              </select>
            </div>

            <!-- Add more fields for other profile information -->

            <button type="submit" name="submit" class="btn btn-primary btn-block">Update Profile</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and Popper.js scripts (needed for Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

                    
            
                    










                </div>
            </div>
            <!-- Recent Sales End -->


            


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