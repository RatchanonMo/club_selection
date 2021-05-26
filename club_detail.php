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
    if(isset($_GET['delmem'])){
        $id = $_GET['delmem'];
        $sql = "UPDATE user SET selected = '0' WHERE id = '$id' ";
        mysqli_query($conn, $sql);

        header('location: club_detail.php?id='. $_SESSION['club_id']);
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



    <h2 class="mt-5" style="margin-left:100px">สวัสดี 
        <span style="color:
            <?php 
                if($_SESSION['user_level'] == 'm'){ 
                    echo '#4275ff';
                } 
                if($_SESSION['user_level'] == 'a'){ 
                    echo '#20c997';
                } 
            ?>
            
        ">
            <?php echo $_SESSION['name'] ?> 
        </span>
    </h2>
    
    <h5 style="margin-left:100px"><a href="user_page.php?logout='1'" style="color:#dc3545; text-decoration:none">ออกจากระบบ</a></h5>

    <?php

            if(isset($_GET['id'])){
                $club_id = $_GET['id'];
                $sql = "SELECT * FROM club WHERE club_id = '$club_id' ";
                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($query);

                $_SESSION['club_id'] = $club_id;

                $selected_check = "SELECT * FROM user";
                $result = mysqli_query($conn, $selected_check);
                $user = mysqli_fetch_array($result);
            }
        ?>

        <div class="container mt-5">
            <h3 align="center"><?php echo $row['club_name'] ?></h3>
            <p align="center"><?php echo $row['club_desc'] ?></p>

            <table class="table table-bordered mb-3" style="max-width:400px; margin:auto; text-align:center">
                <thead>
                    <tr>
                    <th >สมาชิก</th>

                    <?php if($_SESSION['user_level'] == 'a'){ ?>
                        <th>ลบสมาชิก</th>
                    <?php } ?>

                    </tr>
                </thead>
                <tbody>
                    

                    <?php 
                        $member_check = "SELECT * FROM user WHERE selected = '$club_id' ";
                        $q = mysqli_query($conn, $member_check);
                    ?>

                    <?php while($member = mysqli_fetch_array($q)){ ?>
                        <tr>
                            <td><?php echo $member['name'] ?></td>
                            <?php if($_SESSION['user_level'] == 'a'){ ?>
                                <td><a class="btn btn-outline-danger btn-sm" href="club_detail.php?delmem=<?php echo $member['id'] ?>">ลบสมาชิก</a></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                   
                    

                </tbody>
            </table>
           


            <?php if($_SESSION['user_level'] == 'a'){ ?>
                <p align="center">
                    <a href="update_club.php?edit=<?php echo $row['club_id'] ?>" class="btn btn-sm btn-warning">แก้ไขชุมนุม</a>
                    <a href="admin_page.php?del=<?php echo $row['club_id'] ?>" class="btn btn-sm btn-danger">ลบชุมนุม</a>
                </p>
            <?php } ?>

            <?php if($_SESSION['user_level'] == 'm'){ ?>
                <p align="center">
                    <?php if($row['club_member'] < $row['club_fullmember'] && $user['selected'] == 0 ){ ?>
                        <td><a href="./process/select_process.php?id=<?php echo $row['club_id'] ?>" class="btn btn-success">ลงทะเบียน</a></td>
                    <?php } ?>
                    
                </p>
            <?php } ?>

        </div>

    <?php include('./component/js.php') ?>
</body>
</html>