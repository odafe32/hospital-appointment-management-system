<?php
session_start();
include("../include/connect.php");

if (isset($_SESSION["student_id"])) {
    $user_id = $_SESSION["student_id"];
    
    // Handle POST request with cancellation reason
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["appointment_id"]) && isset($_POST["cancellation_reason"])) {
        $appointment_id = mysqli_real_escape_string($connect, $_POST["appointment_id"]);
        $cancellation_reason = mysqli_real_escape_string($connect, trim($_POST["cancellation_reason"]));

        // Validate cancellation reason is not empty
        if (empty($cancellation_reason)) {
            echo '
                <script>
                    alert("Please provide a reason for cancellation.");
                    window.history.back();
                </script>
            ';
            exit();
        }

        // Verify that the appointment belongs to the logged-in student
        $verify_query = mysqli_query($connect, "SELECT * FROM `appointment` WHERE appointment_id = '$appointment_id' AND student_id = $user_id");

        if (mysqli_num_rows($verify_query) > 0) {
            $appointment = mysqli_fetch_assoc($verify_query);
            $current_status = $appointment["appointment_status"];

            // Only allow cancellation of PENDING or APPROVED appointments
            if ($current_status == 'PENDING' || $current_status == 'APPROVED') {
                // Update appointment status to CANCELLED and save the reason
                $sql = mysqli_query($connect, "UPDATE `appointment` SET appointment_status = 'CANCELLED', cancellation_reason = '$cancellation_reason' WHERE appointment_id = '$appointment_id'");

                if ($sql) {
                    echo '
                        <script>
                            alert("Appointment cancelled successfully!");
                            window.location.href="appointment-status.php";
                        </script>
                    ';
                    exit();
                } else {
                    echo '
                        <script>
                            alert("Error cancelling appointment. Please try again.");
                            window.history.back();
                        </script>
                    ';
                    exit();
                }
            } else {
                echo '
                    <script>
                        alert("This appointment cannot be cancelled. Status: ' . $current_status . '");
                        window.history.back();
                    </script>
                ';
                exit();
            }
        } else {
            echo '
                <script>
                    alert("Appointment not found or you do not have permission to cancel it.");
                    window.history.back();
                </script>
            ';
            exit();
        }
    } else {
        echo '
            <script>
                alert("Invalid request. Please provide all required information.");
                window.history.back();
            </script>
        ';
        exit();
    }
} else {
    echo '
        <script>
            alert("Please login to continue.");
            window.location.href="../signin.php";
        </script>
    ';
    exit();
}
?>