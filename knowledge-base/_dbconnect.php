<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "prototype";
    $conn = mysqli_connect($servername, $username, $password, $database );
    if (!$conn) {
        die("Unable to connect with the server");
    }
?>