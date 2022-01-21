<?php
    $server_domain ="127.0.0.1";
    $user_name="root";
    $user_pass="";
    $db_name="db_jareanrubber";
    $conn = mysqli_connect($server_domain,$user_name,$user_pass,$db_name);
    @mysqli_set_charset($conn,"utf8");
    @date_default_timezone_set("Asia/Bangkok");

    if($conn->connect_error){
        die("Connection failed".$conn->connect_error);
    }else{
        //echo "Good connect";
    }
?>