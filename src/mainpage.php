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

         // ส่วนของการแสดง รายการไข่
        $showproduct = "SELECT * FROM eggstock";
        $resultshowproduct = $conn->query($showproduct);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $eggstock_id = trim($_POST['eggstock_id']);
            
            if(!empty($eggstock_id)) {
                $_SESSION['eggstock_id'] = $eggstock_id;
                $_SESSION['buyer_user'] = $showuser;
                $buyer_user = $_SESSION['buyer_user']; // เราระบุ buyer_user เพื่อให้ทราบถึงผู้ซื้อ ว่าคนใดเป็น ตะกร้า ใด 
                // echo $_SESSION['buyer_user'];
                // echo "<br>";
                // echo $_SESSION['eggstock_id'];

                // insertcart ไปที่ฐานข้อมุลของ cart 
                $insertcart = "INSERT INTO `cart`(`cart_id`, `es_id`, `buyer_user`) VALUES ('','$eggstock_id','$buyer_user')";
                $resultinsertcart = $conn->query($insertcart);
                echo "<script>alert('คุณได้ทำการเพิ่มสินค้าลงในตะกร้าแล้ว')</script>";

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
    <h1 class="my-4">เลือกซื้อสินค้า</h1>
    <div class="row">
        <?php if($resultshowproduct->num_rows > 0) { ?>
        <?php while($row=$resultshowproduct->fetch_assoc()) { ?>
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="eggstock_id" value="<?php echo $row['es_id'] ?>">
                                <h3 class="text-center">ไข่เบอร์ : <?php echo $row['es_number'] ?></h3>
                                <p class="text-center">จำนวน 1 แผง</p>
                                <img src="<?php echo $row['es_picture'] ?>" alt="" style="width: 100%; border-radius: 5px;">
                                <p class="text-center my-3"><b>ราคา : <?php echo $row['es_price'] ?> บาท</b></p>
                                <div class="d-flex justify-content-center">
                                    <button class="btn w-50 my-3" style="background-color: #A0C878;" type="submit">เลือก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
           <?php } ?>
        <?php } ?>
    </div>
<!-- script effet ในการใช้ js -->
 <!-- sweetalert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>