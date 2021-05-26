<?php
    session_start();
    include('../connect/server.php');

    $errors = array();

    if(isset($_POST['login_user'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(count($errors) == 0){
            $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password' ";
            $query = mysqli_query($conn, $sql);

            if(mysqli_num_rows($query) == 1){
                $row = mysqli_fetch_array($query);

                $_SESSION['name'] = $row['name'];
                $_SESSION['user_level'] = $row['user_level'];
    
                if($_SESSION['user_level'] == 'm'){
                    header('location: ../user_page.php');
                }
                if($_SESSION['user_level'] == 'a'){
                    header('location: ../admin_page.php');
                }
            }else{
                $_SESSION['error'] = "เลขประจำตัวและรหัสผ่านไม่ตรงกัน";
                header('location: ../index.php');
            }  
        }
    }

?>