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
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $sql = "DELETE FROM club WHERE club_id = '$id' ";
        mysqli_query($conn, $sql);

        header('location: ./admin_page.php');
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

    <div class="container">

        <?php if(isset($_SESSION['success'])){ ?>
            <div class="alert alert-success mb-3" role="success" >
                <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']); 
                ?>
            </div>
        <?php } ?>

        <a href="add_club.php" class="btn btn-primary mt-3">เพิ่มชุมนุม</a>
        <table class="mt-2 table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">ครูที่ปรึกษา</th>
                    <th scope="col">จำนวนสมาชิก</th>
                    <th scope="col">แก้ไข</th>
                    <th scope="col">ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM club";
                    $query = mysqli_query($conn, $sql);
                ?>
                <?php while($row = mysqli_fetch_array($query)){ ?>
                
                <tr>
                
                    <th scope="row"><?php echo $row['club_id'] ?></th>
                    <td><a href="club_detail.php?id=<?php echo $row['club_id'] ?>"><?php echo $row['club_name'] ?></a></td>
                    <td><?php echo $row['club_teacher'] ?></td>
                    <td><?php echo $row['club_member'] ?> / <?php echo $row['club_fullmember']?></td>
                    <td><a href="update_club.php?edit=<?php echo $row['club_id'] ?>" class="btn btn-sm btn-warning">แก้ไข</a></td>
                    <td><a href="admin_page.php?del=<?php echo $row['club_id'] ?>" class="btn btn-sm btn-danger">ลบ</a></td>
                </tr>
                
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include('./component/js.php') ?>
</body>
</html>