<?php
require_once __DIR__.'/../model/User.php';
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_POST['email'];
    $newPass=$_POST['pass'];

    $user=new User();

    if(!$user->emailExists($email)){
        $_SESSION['fpasserrormsg']="No account found with that email";
        header('Location:../index.php?page=forgotPass');
        exit();
    }

    $success=$user->resetPassword($email,$newPass);

    if($success){
        unset($_SESSION['fpasserrormsg']);
        $_SESSION['fpasssuccess']="Password Updated Successfully";
        header('Location:../index.php?page=signin');
        exit();
    }else{
        $_SESSION['fpasserrormsg']="Failed to reset password. Please try again.";
        header('Location:../index.php?page=forgotPass');
        exit();
    }
}
?>