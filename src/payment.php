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

        if(isset($_SESSION['getcart_id'])) {
            $getcart_id = $_SESSION['getcart_id'];
            // echo $getcart_id;    
            $selectcart = "SELECT es.es_id, es.es_number, es.es_price, es.es_picture, ct.cart_id FROM eggstock es JOIN cart ct ON es.es_id = ct.es_id WHERE ct.cart_id = '$getcart_id' ";
            $resultselectcart = $conn->query($selectcart);
            
            // นำข้อมูลไปแสดงเพื่อ ระบบุ สินค้า // ก่อนทำการชำระเงิน

            if(isset($_SESSION['es_id'])) {
                // echo "you have a value";
                $es_idforstatement = $_SESSION['es_id'];

                // หากเกิดมาการส่งหลักฐานการโอนเงินมา

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
                    $target_dir = "payevidence/";
                    $target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
                    $uploadok = 1;
                    $imagefiletype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
                    if(isset($_POST['submit'])) {
                        $check = getimagesize($_FILES["fileupload"]["tmp_name"]);
                        if($check !== false) {
                            $uploadok = 1;
                        } else {
                            echo "<script>alert('ไฟล์นี้ไม่ใช่รูปภาพ')</script>";
                            $uploadok = 0; 
                        }
                    }
            
                    if (file_exists($target_file)) {
                        echo "<script>alert('ไฟล์หลักฐานมีอยู่ในระบบแล้ว')</script>";
                        $uploadok = 0;
                    }
            
                    if ($imagefiletype != "jpg" && $imagefiletype != "png" && $imagefiletype != "jpeg" && $imagefiletype != "gif") {
                        echo "<script>alert('ไฟล์นี้รองรับแค่ jpg,png,jpeg,gif')</script>";
                        $uploadok = 0;
                    }
            
                    if ($uploadok == 0) {
                        echo "<script>alert('ขออภัยไฟล์ของท่าน อัปโหลดไม่สำเร็จ')</script>";
                    } else {
                        if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
                            $getprice = $_SESSION['es_price'];
                            $default_status = "checking";
                                $insertstatement = "INSERT INTO `statement`(`state_id`, `es_id` , `payment_user`, `payment_picture`, `status`) VALUES ('' , '$es_idforstatement' ,'$showuser','$target_file','$default_status')";
                                $resultinsertstatement = $conn->query($insertstatement);

                            $selectorstate_id = "SELECT state_id FROM statement WHERE payment_user = '$showuser' ";
                            $resultselectorstate_id = $conn->query($selectorstate_id);

                            if($resultselectorstate_id->num_rows > 0) {
                                while($row=$resultselectorstate_id->fetch_assoc()) {
                                    echo $row['state_id'];
                                    $getstate_id = $row['state_id'];
                                }       
                            }

                            echo $getcart_id;
                            $inserthistory = "INSERT INTO history (his_id , state_id , cart_id , his_user , his_price , status) VALUES ( '', '$getstate_id' , '$getcart_id' , '$showuser' , '$getprice' , '$default_status' )";
                            $resultinserthis = $conn->query($inserthistory);
            
                            echo "<script>alert('อัปโหลดหลักฐานโอนเงินสำเร็จ')</script>";
                            echo "<script>window.location = 'statement.php'</script>";
                        } else {
                            echo "<script>alert('อัปโหลดหลักฐานโอนเงินไม่สำเร็จ')</script>";
                        }
                    }
                }     
            } else {
                echo "<script>alert('เกิดข้อผิพลาดกรุณาลองใหม่!  ')</script>";
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
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
    </nav>
    <!-- ส่วนเนื้อหาแสดงรายการไข่ -->
    <?php if($resultselectcart->num_rows > 0) { ?>
        <?php while($row=$resultselectcart->fetch_assoc()) { ?>
            <h1 class="my-3">รายการสินค้า</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ไข่เบอร์</th>
                        <th class="text-center">ราคา</th>
                        <th class="text-center">รูปภาพ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <input type="hidden" value="<?php $_SESSION['es_id'] = $row['es_id'] ?>">
                        <th scope="row"><?php echo$row['es_number'] ?></th>
                        <td class="text-center"><?php $_SESSION['es_price'] = $row['es_price']; echo $row['es_price'] ?> บาท</td>
                        <td class="text-center"><img src="<?php echo$row['es_picture'] ?>" alt="" style="width: 100px; height: 100px; border-radius: 1rem;"></td>
                    </tr>
                </tbody>
            </table>
            <h1 class="my-3">ทำการชำระเงิน</h1>
                <div class="d-flex justify-content-center my-5">
                    <img src="images/qrpromptpay.jpg" alt="" style="width: 300px; height: 300px; border-radius: 5px;">
                </div>
            <h1>หากท่านชำระเงินสำเร็จ กรุณาส่งหลักฐานการโอนเงิน</h1>
                <div class="d-flex justify-content-center my-5">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <h3>ส่งหลักฐานการโอนเงิน</h3>
                                <input type="file" name="fileupload" id="" required>
                                <br>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <input class="btn w-100" style="background-color: #A0C878;" value="ยืนยันการโอนเงิน" type="submit" name="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        <?php } ?>
   <?php } ?>
<!-- script effet ในการใช้ js -->
 <!-- sweetalert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>