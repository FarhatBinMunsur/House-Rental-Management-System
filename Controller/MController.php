<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkManager()
{
    if (!isset($_SESSION["userId"])) {
        header("Location: ../index.php");
        exit();
    }

    if (
        !isset($_SESSION["userRole"]) ||
        !($_SESSION["userRole"]==="manager") 
    ) {
        exit("Access denied");
    }
}
?>