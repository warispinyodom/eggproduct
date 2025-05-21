<?php
require_once 'header.php';

    if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {

        // ดึงข้อมูลมาแสดงหน้าแก้ไขข้อมูล
        $oldemail = $_SESSION['email'];
        $showdata = "SELECT m_id , m_user , m_tell , m_pass FROM members WHERE m_id = '$oldemail' ";
        $resultshowdata = $conn->query($showdata);  
        
        if ($resultshowdata->num_rows >0) {
            while($row=$resultshowdata->fetch_assoc()) {
                $showuser = $row['m_user'];
                $oldpassdata = $row['m_pass'];
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $oldpass = trim($_POST['oldpass']);
            $newpass = trim($_POST['newpass']);

            if ($oldpass !== $oldpassdata) {
                echo "<script>alert('รหัสผ่านเก่าของท่าน ไม่ตรงกันกรุณาลองใหม่!')</script>";
            } elseif (empty($oldpass) || empty($newpass)) {
                echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!')</script>";
            } elseif (strlen($oldpass) < 8 || strlen($newpass) < 8) {
                echo "<script>alert('รหัสผ่านของท่านส้นเกินไป กรุณากรอกให้ครบ 8 ตัวอักษร!')</script>";
            } else {
                if (!empty($newpass)) {

                    $updatepass = "UPDATE members SET m_pass = '$newpass' WHERE m_id = '$oldemail' AND m_pass = '$oldpass' ";
                    $resultupdatepass = $conn->query($updatepass);

                    echo "<script>alert('แก้ไขรหัสผ่านสำเร็จแล้ว!')</script>";
                    echo "<script>window.location = 'mainpage.php'</script>";


                } else {
                    echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!')</script>";
                }
            }

        }
    }

    $conn->close();

?>
<div class="container">
    <div class="banner bg-dark p-5" style="width: 100%;">
        <div class="text-center text-white"><h1>จัดการแก้ไขรหัสผ่าน</h1></div>
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
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
    </nav>
    <!-- main content in this pages -->
    <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="card shadow p-3" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h2 class="text-center my-3">แก้ไขรหัสผ่าน</h2>
                    <form action="" method="post">  
                        <div class="mb-3">
                            <label for="oldpass" class="form-label">รหัสผ่านเก่า</label>
                            <input type="password" name="oldpass" class="form-control" id="oldpass" value="" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="newpass" class="form-label">รหัสผ่านใหม่</label>
                            <input type="password" name="newpass" class="form-control" id="newpass" value="" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
                        <a class="d-block text-center" href="mainpage.php">ย้อนกลับ</a>
                    </form>
            </div>
        </div>
    </div>

</div>

<!-- script effet ในการใช้ js -->
 <!-- sweetalert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>