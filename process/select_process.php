<?php
    session_start();
    include('../connect/server.php');

    if(isset($_GET['id'])){
        $club_id = $_GET['id'];
        $name = $_SESSION['name'];

        $add_member = "UPDATE club SET club_member = club_member + 1 WHERE club_id = '$club_id' ";
        mysqli_query($conn, $add_member);

        $select = "UPDATE user SET selected = '$club_id' WHERE name = '$name' ";
        mysqli_query($conn, $select);

        $_SESSION['success'] = "ลงทะเบียนชุมนุมเรียบร้อย";
        header('location: ../user_page.php');
    }
?>