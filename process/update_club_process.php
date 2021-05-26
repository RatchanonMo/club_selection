<?php 

    session_start();
    include('../connect/server.php');

    if(isset($_POST['update_club'])){
        $club_id = $_POST['club_id'];
        $club_name = $_POST['club_name'];
        $club_desc = $_POST['club_desc'];
        $club_teacher = $_POST['club_teacher'];
        $club_fullmember = $_POST['club_fullmember'];

        $sql = "UPDATE club SET club_name = '$club_name', club_desc = '$club_desc', club_teacher = '$club_teacher', club_fullmember = '$club_fullmember' WHERE club_id = '$club_id' ";
        $query = mysqli_query($conn, $sql);

        $_SESSION['success'] = "แก้ไขชุมนุมเรียบร้อย";
        header('location: ../admin_page.php');
    }

?>