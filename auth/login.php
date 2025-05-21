<?php
session_start();
require_once 'header.php'; 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if (!empty($email)) {

            // ทำการดึงฐานข้อมูลมาตรวจสอบ อีเมล รหัสผ่าน ว่าตรงตามฐานข้อมูลรายชื่อไหนจะทำการเก็บ บัญชีนี้ไว้ใช้งานในระบบ สามารถทำระบบโปรไฟล์ได้
            $sqlselector = "SELECT m_id , m_user , m_tell, m_pass , m_status FROM members WHERE m_id = '$email' AND m_pass = '$password'";
            $resultselector = $conn->query($sqlselector);

            if ($resultselector->num_rows > 0) {
                while($row = $resultselector->fetch_assoc()) {
                    
                    $_SESSION['email'] = $row['m_id'];
                    $_SESSION['password'] = $row['m_pass'];
                    $_SESSION['username'] = $row['m_user'];
                    $_SESSION['tell'] = $row['m_tell'];
                    
                    if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {
                        if($row['m_status'] === 'user') {
                            echo "<script>alert('เข้าสู่ระบบสำเร็จ! ยินดีตอนรับ!')</script>";
                            echo "<script>window.location = '../src/mainpage.php'</script>";
                        } elseif ($row['m_status'] === 'admin') {
                            echo "<script>alert('เข้าสู่ระบบสำเร็จ! ยินดีตอนรับ!')</script>";
                            echo "<script>window.location = '../src/admin/checkstatement.php'</script>";
                        }
                    }

                }
            } else {
                echo "<script>alert('อีเมลหรือรหัสผ่านของท่านไม่ถูกต้อง!')</script>";
            }

        }

    }

    $conn->close();

?>

    <div class="d-flex justify-content-center align-items-center " style="height: 100vh;">
        <div class="card shadow w-100 p-3" style="max-width: 400px;">
            <div class="card-body">
                <h2 class="text-center">เข้าสู่ระบบ</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" name="email" id="form-control" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" name="password" id="form-control" class="form-control" >
                    </div>

                    <button class="btn btn-primary w-100 mb-4" type="submit">เข้าสู่ระบบ</button>
                    <a class="d-block text-center " style="font-weight: 400;" href="register.php">หากท่านไม่มีบัญชี คลิก!</a>
                </form>
            </div>
        </div>
    </div>

<!-- script effet ในการใช้ js -->
 <!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>