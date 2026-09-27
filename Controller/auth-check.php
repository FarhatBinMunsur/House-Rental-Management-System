<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header('Location: ../index.php');
    exit();
}

$userId = (int) $_SESSION['userId'];

?>