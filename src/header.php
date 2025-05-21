<?php 
session_start();
require_once '../config/database.php'; 

    if (empty($_SESSION['email']) && empty($_SESSION['password'])) {

        echo "<script>alert('กรุณาเข้าสู่ระบบ!</script>";
        header('Location: ../auth/login.php');
        echo "<script>location.reload()</script>";
        echo "<script>location.reload()</script>";  
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EggShop</title>
     <!-- sweetalert -->
      <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- icon website href="คือที่อยู่ icon" type="image/ คือ ประเภทไฟล์รูปภาพ" -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- font link google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Mitr:wght@200;300;400;500;600;700&family=Pridi:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- link css font -->
     <link rel="stylesheet" href="../css/style.css">
    <!-- ใช้ cdn bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
