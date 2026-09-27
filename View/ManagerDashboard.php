<?php

require_once __DIR__ . '/../Controller/MController.php';
checkManager();

?>

<html>

<head>
    <link rel="stylesheet" href="View/style2.css">
</head>

<body>
    

<div class="container">

    <div class="sidebar">

    <div class="logo">
        <div>
            <h3>RentEase</h3>
            <p>MANAGER PORTAL</p>
        </div>
    </div>

    <div class="menu">

        <a href="">
            <p>Dashboard</p>
        </a>

        <a href="View/ManagerPosts.php">
            <p>Posts</p>
        </a>

        <a href="View/ManagerPayments.php">
            <p>Payments</p>
        </a>

        <a href="View/ManagerNotifications.php">
            <p>Notifications</p>
        </a>

        <a href="./controller/logoutHandler.php">
            <p>Logout</p>
        </a>

    </div>

    <div class="profile">

        <div class="circle">
            <?php
            echo htmlspecialchars(
                strtoupper(
                    substr($_SESSION["username"], 0, 2)
                )
            );
            ?>
        </div>

        <div>
            <h5>
                <?php
                echo htmlspecialchars(
                    $_SESSION["username"]
                );
                ?>
            </h5>

            <p>
                <?php
                echo htmlspecialchars(
                    $_SESSION["userEmail"]
                );
                ?>
            </p>
        </div>

    </div>

</div>

    <div class="main">

        <h1>Dashboard Overview</h1>

        <div class="dashboard-card">

            <div class="status-card">
                <p>Total Rental Posts</p>
                <h2 id="totalPosts">0</h2>
            </div>

            <div class="status-card">
                <p>Accepted Posts</p>
                <h2 id="acceptedPosts">0</h2>
            </div>

            <div class="status-card">
                <p>Rejected Posts</p>
                <h2 id="rejectedPosts">0</h2>
            </div>

            <div class="status-card">
                <p>Pending Posts</p>
                <h2 id="pendingPosts">0</h2>
            </div>

        </div>

    </div>

</div>

<script>
window.pageName = "dashboard";
</script>

<script src="View/manager.js"></script>

</body>
</html>
