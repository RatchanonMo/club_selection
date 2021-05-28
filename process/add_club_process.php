<?php
    session_start();
    include('../connect/server.php');

    $errors = array();

    if(isset($_POST['add_club'])){
        $club_name = $_POST['club_name'];
        $club_desc = $_POST['club_desc'];
        $club_teacher = $_POST['club_teacher'];
        $club_fullmember = $_POST['club_fullmember'];

        $already_club_check = "SELECT * FROM club WHERE club_name = '$club_name' ";
        $query = mysqli_query($conn, $already_club_check);
        $result = mysqli_fetch_assoc($query);

        if($result){
            if($result['club_name'] == $club_name){
                array_push($errors, "ชื่อชุมนุมนี้ถูกใช้ไปแล้ว");
            }
        }

        if($club_fullmember <= 0){
            array_push($errors, "จำนวนสมาชิกไม่ถูกต้อง");
        }

        if(count($errors) == 0){
            $sql = "INSERT INTO club (club_name, club_desc, club_teacher, club_fullmember, club_member) VALUES ('$club_name','$club_desc','$club_teacher','$club_fullmember', '0')";
            mysqli_query($conn, $sql);

            $_SESSION['success'] = "เพิ่มชุมนุมเรียบร้อย";
            header('location:../admin_page.php');
        }else{
            $_SESSION['error'] = implode($errors);
            header('location:../add_club.php');
        }
    }

?>  