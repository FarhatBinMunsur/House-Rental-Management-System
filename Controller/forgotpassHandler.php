<?php
require_once __DIR__.'/../model/User.php';
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_POST['email'];
    $newPass=$_POST['pass'];

    $user=new User();

    if(!$user->emailExists($email)){
        $_SESSION['errormsg']="No account found with that email";
        header('Location: ../view/forgotPass.php');
        exit();
    }

    $success=$user->resetPassword($email,$newPass);

    if($success){
        unset($_SESSION['errormsg']);
        header('Location: ../view/signin.php');
        exit();
    }else{
        $_SESSION['errormsg']="Failed to reset password. Please try again.";
        header('Location: ../view/forgotPass.php');
        exit();
    }
}
?>