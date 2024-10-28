<?php
include("../include/connect.php");

if (isset($_GET["doctor_id"])) {
    $doctor_id = $_GET["doctor_id"];

    $sql = mysqli_query($connect,"DELETE FROM `doctor` WHERE doctor_id = $doctor_id");

    if ($sql) {
        echo '
            <script>
                alert("Doctor deleted!");
                window.location.href="view_doctor.php";
            </script>
        ';
        exit();
    }
}
?>