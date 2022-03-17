<?php
$showError = "false";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include '_dbconnect.php';
        $psno = $_POST['psno'];
        $user_email = $_POST['signupEmail'];
        $pass = $_POST['signupPassword'];
        $cpass = $_POST['signupcPassword'];
        $existSql = "SELECT * FROM `users` WHERE user_email = '$user_email' OR psno = '$psno'";
        $result = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($result);
        echo $numRows;
        if ($numRows > 0) {
            $showError = "Email or PS Number already in use";
        }
        else {
            if ($pass == $cpass) {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`psno`, `user_email`, `user_pass`, `rights`) VALUES ('$psno', '$user_email', '$hash', '0');";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $showAlert = true;
                    header("Location: /prototype/index.php?signupsuccess=true");
                    exit();
                }
            }
            else {
                $showError = "passwords doesnot matched";
            }
        }
        header("Location: /prototype/index.php?signupsuccess=false&error=$showError");
    }
?>