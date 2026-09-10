<?php
require_once __DIR__.'/../model/User.php';
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $fullname=$_POST['fullname'];
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $userRole='client'; // default role for public sign-up

    $user=new User();

    if($user->emailExists($email)){
        $_SESSION['signuperrormsg']="An account with this email already exists";
        header('Location: ../view/signup.php');
        exit();
    }

    $result=$user->createUser($fullname,$email,$pass,$phone,$address,$userRole);

    if(is_int($result)){
        unset($_SESSION['signuperrormsg']);
        header('Location: ../view/signin.php');
        exit();
    }else{
        $_SESSION['signuperrormsg']="Unable to create account: ".$result;
        header('Location: ../view/signup.php');
        exit();
    }
}
?>