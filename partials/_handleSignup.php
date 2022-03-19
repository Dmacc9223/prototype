<?php
$showError = "false";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include '_dbconnect.php';
        $psno = $conn->real_escape_string($_POST['psno']);
        $user_email = $conn->real_escape_string($_POST['signupEmail']);
        $pass = $conn->real_escape_string($_POST['signupPassword']);
        $cpass = $conn->real_escape_string($_POST['signupcPassword']);
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