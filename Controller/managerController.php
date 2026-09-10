<?php
session_start();
require_once __DIR__.'/../model/ManagerModel.php';

$managerModel = new ManagerModel();

if($_SERVER['REQUEST_METHOD']=='POST'){

    $formAction = $_POST['formAction'];
    $id = $_POST['managerID'];

    if($formAction=='Save'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $salary = $_POST['salary'];
        $joiningDate = $_POST['joiningDate'];

        //php validation
        if(empty($name) || empty($email) || empty($phone) || empty($salary) || empty($joiningDate)){
            $_SESSION['MgOpError']=" Please fill up all the fields !!!";
            header('Location: ../view/adminManagersOperation.php');
            exit;
        }

        $managerModel->insertManager($name,$email,$phone,$salary,$joiningDate);

        header('Location: ../view/adminManagersOperation.php');
        exit();
    }

    if($formAction=='Update'){
        // acts as Update
        if(!empty($id)){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $salary = $_POST['salary'];
            $joiningDate = $_POST['joiningDate'];

            $managerModel->updateManager($id,$name,$email,$phone,$salary,$joiningDate);

            header('Location: ../view/adminManagersOperation.php?id='.$id);
            exit();
        }else{
            // No row selected
            $_SESSION['MgOpError']= "Please select a manager first !!!";
            header('Location: ../view/adminManagersOperation.php');
            exit();
        }
    }

    if($formAction=='Delete'){
        if(!empty($id)){
            echo "deleted";
            $managerModel->deleteManager($id);
        }
        header('Location: ../view/adminManagersOperation.php');
        exit();
    }
}
?>