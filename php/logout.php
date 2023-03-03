<?php
    session_start();
    if(isset($_COOKIE['unique_id'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Logged out";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
            if($sql){
                 unset($_COOKIE['user_idunique_id']);
                setcookie('unique_id', $user_data['unique_id'], time() - 3600, '/');
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>