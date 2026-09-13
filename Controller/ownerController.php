<?php
session_start();

require_once __DIR__ . '/../model/ownerModel.php';

$ownerModel = new OwnerModel();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $formAction= $_POST['formAction'];
    $id=$_POST['ownerID'];

    if($formAction == 'Save'){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $address=$_POST['address'];

        if(empty($name) || empty($email) || empty($phone) || empty($address)){
            $_SESSION['OnOpError']=" Please fill up all the fields !!!";
            header('Location: ../view/adminOwnerOperation.php');
            exit();
        }
        $ownerModel->insertOwner($name,$email,$phone,$address);

        header('Location: ../view/adminOwnerOperation.php');
        exit();
    }

    if($formAction=='Update'){

        if(!empty($id)){

        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $address=$_POST['address'];

        $ownerModel->updateOwner($id,$name,$email,$phone,$address);

        header('Location: ../view/adminOwnerOperation.php');
        exit();

        }
        else{
            $_SESSION['OnOpError']="Please select a manager first !!!";
            header('Location: ../view/adminOwnerOperation.php');
            exit();
        }

    }

    if($formAction=='Delete'){
        if(!empty($id)){
            $ownerModel->deleteOwner($id);
        }
        header('Location: ../view/adminOwnerOperation.php');
        exit();
    }
}

?>