<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "_dbconnect.php";
    $psno = $conn->real_escape_string($_POST['psno']);
    $pass = $conn->real_escape_string($_POST['loginPass']);
    $sql = "SELECT * FROM `users` WHERE psno = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Failed!";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $psno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);
        if ($numRows == 1) {
            $row = mysqli_fetch_assoc($result);
            $sql  = "SELECT * FROM `users` WHERE psno=? AND add_status=0";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Failed!";    
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $psno);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $numRow = mysqli_num_rows($result);
            if ($numRow == 1) {
                header("Location: /prototype/wait.php?approveStatus=false");
            } elseif (password_verify($pass, $row['user_pass'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['psno'] = $psno;
                $_SESSION['sno'] = $row['sno'];
                header("Location: /prototype/index.php?loginsuccess=true");
                exit();
            } else {
                $loginError = "Please provide proper email and password";
                header("Location: /prototype/index.php?loginsuccess=$loginError");
            }
        }
        } else {
            $loginError = "Unable to find your account";
            header("Location: /prototype/index.php?loginsuccess=$loginError");
        }
    }
}
?>