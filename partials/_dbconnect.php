<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "prototype";
    $conn = false;
    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        $conn = true;
        die("Unable to connect with the server");
    }
?>