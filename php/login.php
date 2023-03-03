<?php 
    session_start();
    include_once "config.php";
    $field = mysqli_real_escape_string($conn, $_POST['field']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($field) && !empty($password)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$field}'");
        $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE uname = '{$field}'");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            $user_pass = $password;//md5($password)
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){
                $status = "Logged in";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                if($sql2){
                    setcookie('unique_id', $row['unique_id'], time() + 3600, '/');
                    $_COOKIE['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else if(mysqli_num_rows($sql2) > 0){
            $row = mysqli_fetch_assoc($sql2);
            $user_pass = $password;//md5($password)
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){
                $status = "Logged in";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                if($sql2){
                    setcookie('unique_id', $row['unique_id'], time() + 3600, '/');
                    $_COOKIE['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$field - This email or name not Exist!";
        }
    }else{
        echo "All input fields are required!";
    }
?>