<?php
require_once __DIR__ . '/../model/User.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if(empty($email) || empty($pass)){
        $_SESSION['errormsg'] = "Invalid email or password";
        header('Location: ../index.php');
        exit();
    }

    $user = new User();
    $userData = $user->loginCheck($email, $pass);
    
    if ($userData) {
        $_SESSION['username'] = $userData['userName'];
        $_SESSION['userId'] = $userData['userID'];
        $_SESSION['userRole'] = $userData['userRole'];
        unset($_SESSION['errormsg']);

        // // Route based on role
        // if ($userData['userRole'] === 'admin') {
        //     header('Location: ../view/AdminDashboard.php');
        // } 
        // elseif ($userData['userRole'] === 'manager') {
        //     header('Location: ../view/managerHome.php');
        // } 
        // elseif ($userData['userRole'] === 'owner') {
        //     header('Location: ../view/ownerHome.php');
        // } 
        // else {
        //     header('Location: ../view/clientHome.php');
        // }

        header('Location:../index.php');
        exit();
    } 
    else {
        $_SESSION['errormsg'] = "Invalid email or password.";
        header('Location: ../index.php');
        exit();
    }
}
?>