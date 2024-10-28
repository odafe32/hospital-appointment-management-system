<?php
session_start();
include("../include/connect.php");

if (isset($_SESSION["student_id"])) {
    if (isset($_GET["appointment_id"])) {
        $appointment_id = $_GET["appointment_id"];
    
        $sql = mysqli_query($connect,"DELETE FROM `appointment` WHERE appointment_id = '$appointment_id'");
    
        if ($sql) {
            echo '
                <script>
                    alert("Appointment cancelled!");
                    window.location.href="appointment-status.php";
                </script>
            ';
            exit();
        }
    }        
}
?>