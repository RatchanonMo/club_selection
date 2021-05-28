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

        $already_club_check = "SELECT * FROM club WHERE club_name = '$club_name' ";
        $query = mysqli_query($conn, $already_club_check);
        $result = mysqli_fetch_assoc($query);

        if($result){
            if($result['club_name'] == $club_name){
                array_push($errors, "ชื่อชุมนุมนี้ถูกใช้ไปแล้ว");
            }
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