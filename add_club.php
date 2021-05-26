<?php
    session_start();
    include('./connect/server.php');
    if(!isset($_SESSION['user_level'])){
        header('location: index.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['name']);
        header('location: index.php');
    }
    if($_SESSION['user_level'] != 'a'){
        session_destroy();
        unset($_SESSION['name']);
        unset($_SESSION['user_level']);
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <?php include('./component/css.php') ?>
</head>
<body>



    <h2 class="mt-5" style="margin-left:100px">สวัสดี <span style="color:#20c997"><?php echo $_SESSION['name'] ?> </span></h2>
    
    <h5 style="margin-left:100px"><a href="user_page.php?logout='1'" style="color:#dc3545; text-decoration:none">ออกจากระบบ</a></h5>


    <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger mb-3" role="alert" style="max-width:800px; margin:auto">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                ?>
            </div>
        <?php } ?>
    <div class="container mt-5">
        <form action="./process/add_club_process.php" method="post" style="max-width:800px; margin:auto">


            <label>ชื่อชุมนุม</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="club_name" required>
            </div>
            <label>รายละเอียด</label>
            <div class="input-group mb-3">
                <textarea class="form-control" type="text" name="club_desc" rows="3"></textarea>
            </div>
            <label>ครูที่ปรึกษา</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="club_teacher" value="<?php echo $_SESSION['name']?>" required>
            </div>
            <label>จำนวนสมาชิก</label>
            <div class="input-group mb-3">
                <input type="number" class="form-control" name="club_fullmember" required>
            </div>
            <div class="input-group mb-3">
                <button class="btn btn-primary form-control" type="submit" name="add_club">เพิ่มชุมนุม</button>
            </div>
        </form>
    </div>

    <?php include('./component/js.php') ?>
</body>
</html>