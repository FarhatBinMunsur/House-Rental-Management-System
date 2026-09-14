<?php
require_once __DIR__.'/../model/DashboardModel.php';

session_start();

$dashboardModel = new DashboardModel();
$summary = $dashboardModel->getDashboardData();

$_SESSION['dashboardData'] = $summary;

header('Location: ../view/adminDashboard.php');
exit();
?>