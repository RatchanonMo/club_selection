<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php 
        include('./component/css.php');
    ?>
</head>
<body>

    <div class="container-fluid  pb-5" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; border-radius:15px; max-width:600px; margin-top:120px">
        <h1 class="pt-5 pb-5" align="center">ระบบลงทะเบียนชุมนุม</h1>

        <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger mb-3" role="alert" style="max-width:400px; margin:auto">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                ?>
            </div>
        <?php } ?>

        <form action="./process/login_process.php" method="post" style="max-width: 400px;margin:auto">
            <label>เลขประจำตัวนักเรียน</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="username" placeholder="XXXXX">
            </div>
            <label>รหัสผ่าน</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="XXXXX">
            </div>
            <div class="input-group mb-3">
                <button class="btn btn-success form-control" type="submit" name="login_user">เข้าสู่ระบบ</button>
            </div>
        </form>
    </div>
    


    <?php 
        include('./component/js.php');
    ?>
</body>
</html>