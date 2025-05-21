<?php
require_once 'header.php';

    if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {

        $emailforprofile = $_SESSION['email'];
        // ทำการดึงข้อมูลผู้ใช้งานจาก session มาตรวจสอบผู้ใช้งานและเก็บข้อมูล
        $sqlselectprofile = "SELECT m_id , m_user , m_pass , m_tell FROM members WHERE m_id = '$emailforprofile' ";
        $resultprofile = $conn->query($sqlselectprofile);

        if ($resultprofile->num_rows > 0) {
            while($row = $resultprofile->fetch_assoc()) {
                $showuser = $row['m_user'];
            }
        }

        // ดึง history มาแสดง โดยอิงค์จาก user 
        $selecthis = "SELECT his_id , cart_id , his_user , his_price , status FROM history WHERE his_user = '$showuser' ";
        $resultselecthis = $conn->query($selecthis);

        $checkstatus = "SELECT status FROM statement WHERE payment_user = '$showuser' ";
        $resultcheckstatus = $conn->query($checkstatus);

        if($resultcheckstatus->num_rows > 0) {
            while($row=$resultcheckstatus->fetch_assoc()) {
                $getstatusonstatement = $row['status'];
                // echo $getstatusonstatement; 

                if ($row['status'] === 'checked') {
                    // เช็คยอดแล้ว
                    $changestatushistory = "UPDATE history SET status = '$getstatusonstatement' WHERE his_user = '$showuser' ";
                    $resultchagnestatushistory = $conn->query($changestatushistory);

                    $deletecartout = " DELETE cart FROM cart JOIN statement ON cart.buyer_user = statement.payment_user AND cart.es_id = statement.es_id WHERE statement.status = 'checked' ";
                    $resultdeletecartout = $conn->query($deletecartout);

                } else {

                    //กำลังเช็คยอด
                    $changestatushistory = "UPDATE history SET status = '$getstatusonstatement' WHERE his_user = '$showuser' ";
                    $resultchagnestatushistory = $conn->query($changestatushistory);
                    // echo "<script>alert('สถานะสินค้าของคุณอยู่ในขั้นตอนในการเช็คยอดชำระเงิน')</script>";  
                }
            }
        }
    }

    $conn->close();
    
?>
<div class="container">
    <div class="banner bg-dark p-5" style="width: 100%;">
        <div class="text-center text-white"><h1>ยินดีตอนรับ เว็บขายไข่ออนไลน์</h1></div>
    </div>
    <nav class="navbar navbar-expand-lg " style="background-color: #A0C878;">
        <div class="container-fluid">
            <a class="navbar-brand" href="mainpage.php">EggShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="mainpage.php">สั่งซื้อสินค้า</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="cart.php">ตะกร้าสินค้า</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="statement.php">ประวัติการทำรายการ</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    การจัดการข้อมูล
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="editprofile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                    <li><a class="dropdown-item" href="forgotpassword.php">รีเซ็ตรหัสผ่าน</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">ออกจากระบบ</a></li>
                </ul>
                </li>
                <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">ชื่อผู้ใช้งาน : <?php echo $showuser ?></a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <!-- ส่วนเนื้อหาแสดงรายการไข่ -->
    <h1 class="my-4">ประวัติการทำรายการ</h1>
    <table class="table table-dark table-hover">

        <thead>
            <tr>
                <th class="text-center" scope="col">ลำดับรายการ</th>
                <th class="text-center" scope="col">ลำดับตะกร้าสินค้า</th>
                <th class="text-center" scope="col">ชื่อผู้ทำธุระกรรม</th>
                <th class="text-center" scope="col">ราคา</th>
                <th class="text-center" scope="col">สถานะการชำระเงิน</th>
            </tr>
        </thead>
        <tbody>
            <?php if($resultselecthis->num_rows > 0) { ?>
                <?php while($row=$resultselecthis->fetch_assoc()) { ?>
                    <tr>
                        <th class="text-center" scope="row"><?php echo$row['his_id'] ?></th>
                        <td class="text-center"><?php echo$row['cart_id'] ?></td>
                        <td class="text-center"><?php echo$row['his_user'] ?></td>
                        <td class="text-center"><?php echo$row['his_price'] ?></td>
                        <td class="text-center"><?php echo$row['status'] ?></td>
                    </tr>
               <?php } ?>
           <?php } ?>
        </tbody>
    </table>
<!-- script effet ในการใช้ js -->
 <!-- sweetalert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>