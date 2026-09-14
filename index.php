<?php
session_start();

if (isset($_SESSION['username'])) {

    if ($_SESSION['userRole'] =='admin') {

        require_once __DIR__ . '/View/adminDashboard.php';

    } 
    elseif ($_SESSION['userRole']=== 'manager')  {

    require_once __DIR__ . '/View/ManagerDashboard.php';

}
    elseif ($_SESSION['userRole'] === 'owner') {

        require_once __DIR__ . '/View/ownerDashboard.php';
        // header('Location:View/ownerDashboard.php');

    }
     else {

        require_once __DIR__ . '/Controller/dashboard-controller.php';

    }

} else {

    //kon page request krse
    if (isset($_GET['page'])) {

        if ($_GET['page'] === 'signup') {

            require_once __DIR__ . '/View/signup.php';

        } elseif ($_GET['page'] === 'forgotPass') {

            require_once __DIR__ . '/View/forgotPass.php';

        } else {
            // echo $_SESSION['userRole'];

            require_once __DIR__ . '/View/signin.php';

        }

    } else {

        require_once __DIR__ . '/View/signin.php';

    }

}
?>