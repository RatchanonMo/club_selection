<?php 

    session_start();
    include('../connect/server.php');

    $errors = array();

    if(isset($_POST['update_club'])){
        $club_id = $_POST['club_id'];
        $club_name = $_POST['club_name'];
        $club_desc = $_POST['club_desc'];
        $club_teacher = $_POST['club_teacher'];
        $club_fullmember = $_POST['club_fullmember'];

        if($club_fullmember <= 0){
            array_push($errors, "จำนวนสมาชิกไม่ถูกต้อง");
        }

        if(count($errors) == 0){
            $sql = "UPDATE club SET club_name = '$club_name', club_desc = '$club_desc', club_teacher = '$club_teacher', club_fullmember = '$club_fullmember' WHERE club_id = '$club_id' ";
            $query = mysqli_query($conn, $sql);
    
            $_SESSION['success'] = "แก้ไขชุมนุมเรียบร้อย";
            header('location: ../admin_page.php');
        }else{
            $_SESSION['error'] = implode($errors);
            header('location: ../update_club.php?edit='. $club_id);
        }

 
    }

?>