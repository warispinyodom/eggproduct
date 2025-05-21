<?php
    $hostname = "localhost";
    $hostuser = "root";
    $hostpass = "";
    $db = "eggproduct";

    $conn = new mysqli($hostname, $hostuser, $hostpass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); 
    }
?>