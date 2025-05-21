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
        
        // ส่วนของการจัดการ statement
        $showstatement = "SELECT * FROM statement";
        $resultshowstatement = $conn->query($showstatement);

        // นำไปแสดงตารางรายการ

        // ทำการ ยืนยันการโอนเงิน
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $submit = trim($_POST['submit']);
            if(!empty($submit)) {
                $getstate_id = trim($_POST['state_id']);
                echo $getstate_id;  
                if(isset($getstate_id)) {
                    
                    $updatestatusstatement = "UPDATE statement SET status = 'checked' WHERE state_id = '$getstate_id' ";
                    $resultupdatestatement = $conn->query($updatestatusstatement);

                    $updatestatushis = "UPDATE history SET status = 'checked' WHERE state_id = '$getstate_id' ";
                    $resultupdatestatushis = $conn->query($updatestatushis);

                    echo "<script>alert('ทำการตรวจสอบยอดชำระเงินสำเร็จ')</script>";
                    echo "<script>window.location = 'checkstatement.php' </script>";

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
            <a class="navbar-brand" href="checkstatement.php">EggShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="checkstatement.php">จัดการตรวจสอบยอดชำระเงิน</a>
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
    <!-- ส่วนเนื้อหาแสดงรายการไข่ -->
     <h1 class="my-3">รายการตรวจสอบยอดชำระเงิน</h1>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th class="text-center" scope="col">รายการที่</th>
                <th class="text-center" scope="col">ชื่อผู้ทำธุระกรรม</th>
                <th class="text-center" scope="col">หลักฐานการโอน</th>
                <th class="text-center" scope="col">สถานะ</th>
                <th class="text-center" scope="col">จัดการสถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php if($resultshowstatement->num_rows > 0) { ?>
                <?php while($row=$resultshowstatement->fetch_assoc()) { ?>
                    <tr>
                    <form action="" method="post">
                        <th scope="row"><?php echo$row['state_id'] ?><input type="hidden" name="state_id" value="<?php echo$row['state_id'] ?>"></th>
                        <td class="text-center"><?php echo$row['payment_user'] ?></td>
                            <td class="text-center"><a href="../<?php echo$row['payment_picture'] ?>" target="_blank"><img src="../<?php echo$row['payment_picture']?>" style="width: 50xp; height: 50px; border-radius: 5px;" alt=""></a></td>
                        <td class="text-center"><?php echo$row['status'] ?></td>
                        <td class="text-center">
                            
                                <input class="btn" name="submit" style="background-color: #A0C878;" type="submit" value="ยืนยันสถานะ">

                        </td>
                    </tr>
                    </form>
               <?php } ?>
           <?php } ?>
        </tbody>
    </table>


<!-- script effet ในการใช้ js -->
 <!-- sweetalert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>