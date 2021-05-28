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

        $club_id = $_SESSION['club_id'];

        mysqli_query($conn, "UPDATE club SET club_member = club_member - 1 WHERE club_id = '$club_id' ");

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
                            <td><?php echo $member['name']. " " ."ม." .$member['class']. "/" .$member['room'] ?></td>

                   
                           
                            
                            <?php if($_SESSION['user_level'] == 'a'){ ?>
                                <td><a class="btn btn-outline-danger btn-sm"  data-bs-toggle="modal" data-bs-target="#deleteMember">ลบสมาชิก</a></td>





                                <div class="modal fade" id="deleteMember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบสมาชิก</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>ต้องการลบสมาชิกคนนี้หรือไม่ ?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <a href="club_detail.php?delmem=<?php echo $member['id'] ?>" type="button" class="btn btn-danger">ตกลง</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                   
                    

                </tbody>
            </table>
                     
            <?php if($_SESSION['user_level'] == 'm' && $member['selected'] = $row['club_id'] && $user['selected'] != 0){ ?>
                        <p align="center"> 
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancel">ยกเลิกการลงทะเบียน</button>
                        </p>
                        <div class="modal fade" id="cancel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ยกเลิกการลงทะเบียนชุมนุม</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>ต้องการยกเลิกลงทะเบียนชุมนุมนี้หรือไม่ ?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                    <a href="./user_page.php?cancel=<?php echo $row['club_id']?>" type="button" class="btn btn-danger">ตกลง</a>
                                </div>
                                </div>
                            </div>
                            </div>
                    <?php } ?>

           


            <?php if($_SESSION['user_level'] == 'a'){ ?>
                <p align="center">
                    <a href="update_club.php?edit=<?php echo $row['club_id'] ?>" class="btn btn-sm btn-warning">แก้ไขชุมนุม</a>
                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete">ลบชุมนุม</a>

                    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบชุมนุม</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5>ต้องการลบชุมนุมนี้หรือไม่ ?</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <a href="admin_page.php?del=<?php echo $row['club_id'] ?>" type="button" class="btn btn-danger">ตกลง</a>
                            </div>
                            </div>
                        </div>
                    </div>

                </p>
            <?php } ?>

            <?php if($_SESSION['user_level'] == 'm'){ ?>
                <p align="center">
                    <?php if($row['club_member'] < $row['club_fullmember'] && $user['selected'] == 0 ){ ?>
                        <td><a class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#submit">ลงทะเบียน</a></td>
                        <div class="modal fade" id="submit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลงทะเบียนชุมนุม</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>ต้องการลงทะเบียนชุมนุมนี้หรือไม่ ?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                    <a href="./process/select_process.php?id=<?php echo $row['club_id'] ?>" type="button" class="btn btn-success">ตกลง</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    
                    <?php } ?>
                    
                </p>
            <?php } ?>

        </div>

    <?php include('./component/js.php') ?>
</body>
</html>