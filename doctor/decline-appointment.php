<?php
include("../include/connect.php");

if (isset($_GET["appointment_id"])) {
    $appointment_id = $_GET["appointment_id"];

    $sql = mysqli_query($connect,"UPDATE `appointment` SET appointment_status = 'DECLINED' WHERE appointment_id = '$appointment_id'");

    if ($sql) {
        echo '
            <script>
                alert("Appointment declined!");
                window.location.href="new-appointments.php";
            </script>
        ';
        exit();
    }
}
?>