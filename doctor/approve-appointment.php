<?php
include("../include/connect.php");

if (isset($_GET["appointment_id"])) {
    $appointment_id = $_GET["appointment_id"];

    $sql = mysqli_query($connect,"UPDATE `appointment` SET appointment_status = 'APPROVED' WHERE appointment_id = '$appointment_id'");

    if ($sql) {
        echo '
            <script>
                alert("Appointment approved!");
                window.location.href="new-appointments.php";
            </script>
        ';
        exit();
    }
}
?>