<?php
ob_start();
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
$errors = [];
if(isset($_POST)){
    $firstName = trim($_POST["fName"]);
    $lastName = trim($_POST["lName"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["cpassword"]);
    // validations
     
    if(empty($firstName)){
        $errors[]="firstName must not be empty";
    }
    if(empty($email)){
        $errors[]="email must not be empty";
    }
    if(!empty($email)&& !filter_var($email, FILTER_VALIDATE_EMAIL)){
                 $errors[] = "Invalid email address";
    }
    if(empty($password)){
        $errors[]="password must not be empty";
    }

    if(empty($confirmPassword)){
        $errors[]="confirm password must not be empty";
    }
 
    if(!empty($password) && !empty($confirmPassword) && $password != $confirmPassword){
        $errors[] = "Confirm password does not match";
    }
        if(!empty($errors)){
             $_SESSION['errors'] = $errors;
             header('location:' .SITEURL . 'signup.php');
             exit();  
        }

       

        // if email already exists

        if(!empty($email)){
            $conn = db_connect();
            $sanitizeEmail = mysqli_real_escape_string($conn , $email);
            $emailsql = "SELECT id From `users` WHERE `email` = '{$sanitizeEmail}'";
            $sqlResult = mysqli_query($conn, $emailSql);
            $emailRow = mysqli_num_rows();
            if($emailRow > 0){
                $errors[] = "Email Address already exists.";
            } 
            db_close($conn);

        }

         // if no errors

        $passwordHash = password_hash($password , PASSWORD_DEFAULT);
        $sql ="INSERT INTO `users` (first_name,last_name,email, password) VALUES ('{$firstName}' , '{$lastName}', '{$email}') ,'{$password}','{$passwordHash}')";
  
        $conn = db_connect();

        if(mysqli_query($conn, $sql)){
            db_close($conn);
            $message = "You are registered successfully!";
            $_SESSION['success']  = $message;
            header('location: ' . SITEURL . 'signup.php'); 
        }
        
        if(!empty($email) && !empty($password) && !empty($confirmPassword) && !empty($firstName)  && !empty($lastName) && $password  == $confirmPassword ){
            echo "all good";
        }

}