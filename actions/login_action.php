<?php
ob_start();
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
$errors = [];
if(isset($_POST)){
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if(empty($email)){
        $errors[]="email must not be empty";
    }
    if(!empty($email)&& !filter_var($email, FILTER_VALIDATE_EMAIL)){
                 $errors[] = "Invalid email address";
    }
    if(empty($password)){
        $errors[]="password must not be empty";
    }

    if(!empty($errors)){
        $_SESSION['errors'] = $errors;
        header('location:' . SITEURL . "login.php");
    }

    // if no errors
    if(!empty($email) && !empty($password)){
        $conn  = db_connect();
        $santizeEmail = mysqli_real_escape_string($conn,$email);
        $sql = "SELECT * FROM `users` WHERE `email` = '{$santizeEmail}'";
        $sqlResult = mysqli_query($conn,$sql);
        if(mysqli_num-rows($sqlResult) > 0 ){
            $userInfo = mysqli_fetch_assoc($sqlResult);
            print_arr($userInfo);
        }
    }

}