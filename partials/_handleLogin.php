<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "_dbconnect.php";
    $psno = $conn->real_escape_string($_POST['psno']);
    $pass = $conn->real_escape_string($_POST['loginPass']);
    $sql = "SELECT * FROM `users` WHERE psno = '$psno'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row['user_pass'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['psno'] = $psno;
            $_SESSION['sno'] = $row['sno'];
            header("Location: /prototype/index.php?loginsuccess=true");
            exit();
        }    
        else {
            $loginError = "Please provide proper email and password";
            header("Location: /prototype/index.php?loginsuccess=$loginError");
        }
    }
    else{
        $loginError = "Unable to find your account";
    header("Location: /prototype/index.php?loginsuccess=$loginError");
    }
}
?>