<?php
require_once 'header.php';

    if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {

        // ทำการดึงข้อมูลมาแสดงหน้า แก้ไขข้อมูล
        $oldemail = $_SESSION['email'];
        $showdata = "SELECT m_id , m_user , m_tell FROM members WHERE m_id = '$oldemail' ";
        $resultshowdata = $conn->query($showdata);  
        
        if ($resultshowdata->num_rows >0) {
            while($row=$resultshowdata->fetch_assoc()) {
                $showuser = $row['m_user'];
                $showemail = $row['m_id'];
                $showtell = $row['m_tell'];
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $newuser = trim($_POST['newuser']);
            $newemail = trim($_POST['newemail']);
            $newtell = trim($_POST['newtell']);

            // เช็ค duplicate primarykey 
            $checkdataduplicate = "SELECT m_id FROM members WHERE m_id = '$newemail'";
            $resultduplicate = $conn->query($checkdataduplicate);

            if ($resultduplicate->num_rows >0) {
                echo "<script>alert('มีผู้ใช้อีเมลนี้แล้ว กรุณาลองใหม่!')</script>";
            } else {
                if (!empty($newemail) && !empty($newuser) && !empty($newtell)) {

                    $updatedata = "UPDATE members SET m_id = '$newemail' , m_user = '$newuser' , m_tell = '$newtell' WHERE m_id = '$oldemail' ";
                    $resultupdate = $conn->query($updatedata);
    
                    $_SESSION['email'] = $newemail;
                    
                    echo "<script>alert('แก้ไขข้อมูลสำเร็จแล้ว!')</script>";
                    echo "<script>window.location = 'editprofile.php'</script>";
    
                }
            }
        }
    }

    $conn->close();

?>
<div class="container">
    <div class="banner bg-dark p-5" style="width: 100%;">
        <div class="text-center text-white"><h1>จัดการแก้ไขข้อมูลส่วนตัว</h1></div>
    </div>
    <nav class="navbar navbar-expand-lg " style="background-color: #A0C878;">
        <div class="container-fluid">
            <a class="navbar-brand" href="checkstatement.php">EggShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                <h2 class="text-center my-3">แก้ไขข้อมูลส่วนตัว</h2>
                    <form action="" method="post">  
                        <div class="mb-3">
                            <label for="newuser" class="form-label">ชื่อผู้ใช้งาน</label>
                            <input type="text" name="newuser" class="form-control" id="newuser" value="<?php echo $showuser; ?>" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="newemail" class="form-label">อีเมล</label>
                            <input type="email" name="newemail" class="form-control" id="newemail" value="<?php echo $showemail; ?>" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="newtell" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" name="newtell" class="form-control" id="newtell" value="<?php echo $showtell; ?>" aria-describedby="emailHelp">
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