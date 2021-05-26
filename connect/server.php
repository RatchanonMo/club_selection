<?php
    $conn = mysqli_connect('localhost','root','','club_selection');

    if(!$conn){
        die("Could not connect.". mysqli_connect_error());
    }
?>