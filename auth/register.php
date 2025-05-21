<?php require_once 'header.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // เก็บตัวแปรจาก form ที่เรากรอก

        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $tell = trim($_POST['tell']);

        // ทำการตรวจสอบหาก ช่อง email ไม่ว่างหรือก็คือถูกกรอกข้อมูล ให้ทำการเช็ค ฐานข้อมูลว่ามีอีเมล ตรงกับ ที่เรากรอกหรือไม่ เพื่อป้องกันการ สมัครอีเมลซ้ำ

        if (!empty($email)) {

            // ตรวจสอบฐานข้อมูล 
            
            $sqlcheck = "SELECT m_id , m_user , m_tell FROM members WHERE m_id = '$email' OR m_user = '$username' OR m_tell = '$tell' ";
            $result = $conn->query($sqlcheck);

            // หากมีข้อมูลมากกว่า 0 หรือก็มีข้อมูล ให้ทำการดึง email จากฐานข้อมูลและตอบกลับ ว่ามีผู้ใช้อีเมลนี้แล้ว

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<script>alert('มีผู้ใช้งานในระบบแล้ว กรุณาลองใหม่อีกครั้ง!')</script>";
                }
            } else {
                if (strlen($password) < 8) {
                    echo "<script>alert('รหัสผ่านของท่านสั้นเกินไป ต้องมีอย่างน้อย 8 ตัวอักษร!')</script>";
                } elseif (strlen($tell) < 10) {
                    echo "<script>alert('เบอร์โทรศัพท์ของท่านไม่ถูกต้อง กรุณากรอกให้ครบ 10 ตัว!')</script>";
                } else {
                    // ทำการอัพโหลดข้อมูลไปที่ ฐานข้อมูลหรือก็คือ สมัครสมาชิก
                    $sqlinsert = "INSERT INTO members (m_id, m_user, m_pass, m_tell, m_status) VALUES ('$email', '$username', '$password', '$tell', 'user')";
                    $resultinsert = $conn->query($sqlinsert);

                    echo "<script>alert('ลงทะเบียนเข้าสู่ระบบสำเร็จ!')</script>";
                    echo "<script>window.location = 'login.php'</script>";
                }
            }
        }
    }
    $conn->close();
?>
<div class="d-flex justify-content-center align-items-center " style="height: 100vh;">
    <div class="card shadow w-100 p-3" style="max-width: 400px;">
        <div class="card-body">
            <h2 class="text-center">สมัครสมาชิก</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">ชื่อ - นามสกุล</label>
                    <input type="username" name="username" id="form-control" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">อีเมล</label>
                    <input type="email" name="email" id="form-control" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน</label>
                    <input type="password" name="password" id="form-control" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="tell" class="form-label">เบอร์โทรศัพท์</label>
                    <input type="tell" name="tell" id="form-control" class="form-control" >
                </div>
                <button class="btn btn-primary w-100 mb-4" type="submit">สมัครสมาชิก</button>
                <a class="d-block text-center " style="font-weight: 400;" href="login.php">หากท่านมีบัญชี คลิก!</a>
            </form>
        </div>
    </div>
</div>

<!-- script effet ในการใช้ js -->
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>