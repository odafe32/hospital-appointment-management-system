<?php
    session_start();
    //Checking if user is logged in
    if (isset($_SESSION["doctor_id"])) {
            session_destroy();
            header("location:../signin.php");
    }
?>