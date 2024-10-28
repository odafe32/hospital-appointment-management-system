<?php 

if (isset($_POST["submit"])) {
    $doctor_id = $_POST["doctor_id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $othername = $_POST["othername"];
    $password = $_POST["password"];

    //VALIDATION 1 CHECKING FOR SPECIAL CHARACTERS
    $firstname = htmlspecialchars($firstname);
    $lastname = htmlspecialchars($lastname);
    $othername = htmlspecialchars($othername);
    $password = htmlspecialchars($password);


    //VALIDATION 2 CHECKING FOR WRONG INPUTS 
    if (!preg_match('/^[a-zA-Z]+$/u', $firstname) || !preg_match('/^[a-zA-Z]+$/u', $lastname) || !preg_match('/^[a-zA-Z0-9]+$/u', $password) || strlen($password) < 6) {

        if (!preg_match('/^[a-zA-Z]+$/u', $firstname)) {
            $firstname_err = "Invalid characters in first name.";
        }
    
        if (!preg_match('/^[a-zA-Z]+$/u', $lastname)) {
            $lastname_err = "Invalid characters in last name.";
        }
    
        if (!preg_match('/^[a-zA-Z0-9]+$/u', $password)) {
            $password_err = "Invalid Password.";
        }
    
    if (strlen($password) < 6) {
        $password_err = "Password must be up to six characters";
    }

    } else {
    $password_hash = password_hash($password,PASSWORD_DEFAULT);

    $sql = mysqli_query($connect,"UPDATE `doctor` SET firstname = '$firstname' ,lastname = '$lastname', othername = '$othername', password = '$password_hash' WHERE doctor_id = $doctor_id");

    if ($sql = true) {
        echo "
        <script>
            alert('Update successful!');
        </script>
        ";
    }else {
        echo "<script>
            alert('Signup error:/n". mysqli_error($connect) ."');
        </script>";
    }
        
    }

}
?>