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
    if($_SESSION['user_level'] != 'm'){
        session_destroy();
        unset($_SESSION['name']);
        unset($_SESSION['user_level']);
        header('location: index.php');
    }
    if(isset($_GET['cancel'])){
        $id = $_GET['cancel'];
        $name = $_SESSION['name'];
        mysqli_query($conn, "UPDATE user SET selected = '0' WHERE name = '$name' ");
        mysqli_query($conn, "UPDATE club SET club_member = club_member - 1 WHERE club_id = '$id' ");

        header('location: ./user_page.php');
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



    <h2 class="mt-5" style="margin-left:100px">สวัสดี <span style="color:#4275ff"><?php echo $_SESSION['name'] ?> </span></h2>
    
    <h5 style="margin-left:100px"><a href="user_page.php?logout='1'" style="color:#dc3545; text-decoration:none">ออกจากระบบ</a></h5>

    <div class="container">
        <table class="mt-5 table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">ครูที่ปรึกษา</th>
                    <th scope="col">จำนวนสมาชิก</th>
                    <th scope="col">ลงทะเบียน</th>
                    <th scope="col">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM club";
                    $query = mysqli_query($conn, $sql);

                    $selected_check = "SELECT * FROM user";
                    $result = mysqli_query($conn, $selected_check);
                    $user = mysqli_fetch_array($result);
                ?>
                <?php while($row = mysqli_fetch_array($query) ){ ?>
                
                <tr>
                
                    <th scope="row"><?php echo $row['club_id'] ?></th>
                    <td><a href="club_detail.php?id=<?php echo $row['club_id'] ?>"><?php echo $row['club_name'] ?></a></td>
                    <td><?php echo $row['club_teacher'] ?></td>
                    <td><?php echo $row['club_member'] ?> / <?php echo $row['club_fullmember']?></td>

                    <?php if($row['club_member'] == $row['club_fullmember'] && $user['selected'] == 0){ ?>
                        <td>สมาชิกเต็มแล้ว</td>
                    <?php } ?>

                    <?php if($row['club_member'] < $row['club_fullmember'] && $user['selected'] == 0 ){ ?>
                        <td><button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#submit">ลงทะเบียน</button></td>
                    <?php } ?>

                    <?php if($user['selected'] != 0 && $user['selected'] != $row['club_id']){ ?>
                        <td>คุณได้ลงทะเบียนชุมนุมไปแล้ว</td>
                    <?php } ?>

                    <?php if($user['selected'] = $row['club_id'] && $user['selected'] != 0){ ?>
                        <td><button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancel">ยกเลิกการลงทะเบียน</button></td>
                    <?php } ?>

                    <td>
                        <?php if($row['club_member'] == $row['club_fullmember']){ ?>
                            <span style="color:red">เต็ม</span>
                        <?php } ?>
                        <?php if($row['club_member'] < $row['club_fullmember']){ ?>
                            <span style="color:green">ว่าง</span>
                        <?php } ?>
                    </td>
                </tr>


                
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
        <a href="./process/select_process.php?id=<?php echo $row['club_id']?>" type="button" class="btn btn-success">ตกลง</a>
      </div>
    </div>
  </div>
</div>

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
            </tbody>
        </table>
    </div>
 




    <?php include('./component/js.php') ?>
</body>
</html>