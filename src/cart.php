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
    }   

    // นำ ราคาจาก ฐานข้อมูล eggstock มาแสดง โดยการเขียน sql เชิงสัมพันธ์
    $selectprice = "SELECT es.es_id, es.es_number, es.es_price , ct.cart_id , ct.buyer_user FROM eggstock es JOIN cart ct ON es.es_id = ct.es_id WHERE buyer_user = '$showuser' ";
    $resultselectprice = $conn->query($selectprice);
    //นำไปแสดงใน  content

    //การลบและชำระเงินใน cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_POST['deletebtn'])) {
            $getcart_id = trim($_POST['getcart_id']);
            echo $getcart_id;

            //กำหนดการลบออกจากฐานข้อมูลเมื่อมีการกดลบ
            $deletecart = "DELETE FROM cart WHERE cart_id = '$getcart_id' ";
            $resultdeletecar = $conn->query($deletecart);
            echo "<script>alert('ลบสินค้าออกจากตะกร้าแล้ว!')</script>";
            echo "<script>window.location = 'cart.php' </script>";
        }

        if(isset($_POST['submitbtn'])) {
            $getcart_id = trim($_POST['getcart_id']);
            echo $getcart_id;
            $_SESSION['getcart_id'] = $getcart_id;
            //ตรวจสอบ ก่อนเลยว่า cart_id เนี่ย ตรงกับที่กดไหม แล้วเราจะทำการ ชำระเงิน แล้วเมื่อชำระเงินเก็บ history ไว้ในฐานข้อมูล history
            echo "<script>window.location = 'payment.php' </script>";

        }

        if(isset($_POST['submitallbtn'])) {
            
            echo "<script>window.location = 'paymentall.php' </script>";

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
     <h1 class="my-4">ตะกร้าสินค้า</h1>
    <table class="table my-3 table-dark table-hover">
        <thead>
            <tr>
                <th class="text-center" scope="col">ไข่เบอร์</th>
                <th class="text-center" scope="col">ราคา</th>
                <th class="text-center" scope="col">ลบรายการ</th>
                <th class="text-center" scope="col">ทำการชำระเงิน</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultselectprice->num_rows > 0) { ?>
                <?php while($row=$resultselectprice->fetch_assoc()) { ?>
                    <tr>
                        <form action="" method="post">
                        <th class="text-center" scope="row"><?php echo$row['es_number'] ?><input type="hidden" name="getcart_id" value="<?php echo$row['cart_id']?>"></th>
                        <td class="text-center"><?php echo$row['es_price'] ?> บาท</td>
                        <td class="text-center"><input type="submit" name="deletebtn" class="btn btn-danger" value="ลบ"></td>
                        <td class="text-center"><input type="submit" name="submitbtn" class="btn" style="background-color: #A0C878;" value="ชำระเงิน"></td>
                        </form>
                    </tr>
               <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <form class="d-flex justify-content-center" action="" method="post">
        <input type="submit" name="submitallbtn" class="btn w-25" style="background-color: #A0C878;" value="ชำระทั้งหมด">
    </form>
    
<!-- script effet ในการใช้ js -->
 <!-- sweetalert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>