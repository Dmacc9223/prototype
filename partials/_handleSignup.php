<?php
$showError = "false";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '_dbconnect.php';
    $psno = $conn->real_escape_string($_POST['psno']);
    $user_email = $conn->real_escape_string($_POST['signupEmail']);
    $pass = $conn->real_escape_string($_POST['signupPassword']);
    $cpass = $conn->real_escape_string($_POST['signupcPassword']);
    $existSql = "SELECT * FROM `users` WHERE user_email = ? OR psno = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $existSql)) {
        echo "Failed!";    
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $user_email, $pass);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $showError = "Email or PS Number already in use";
        } else {
            if ($pass == $cpass) {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`psno`, `user_email`, `user_pass`, `rights`, `add_status`) VALUES (?,?,?,?,?);";

                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "Failed!";    
                }
                else {
                    $val = '0';
                    mysqli_stmt_bind_param($stmt, "sssss", $psno, $user_email, $hash, $val, $val);
                    $result = mysqli_stmt_execute($stmt);
                    // $result = mysqli_stmt_get_result($stmt);
                if ($result) {
                    $showAlert = true;
                    header("Location: /prototype/index.php?signupsuccess=true");
                    exit();
                }
            }
            } else {
                $showError = "passwords doesnot matched";
            }
        }
        header("Location: /prototype/index.php?signupsuccess=false&error=$showError");
    }
}
?>