<?php

$notifications = $notifications ?? [];

?>

<!DOCTYPE html>

<html>

<head>

    <title>RentEase Payment Notifications</title>

    <link rel="stylesheet" href="/HouseRentalManagementSystem/View/style1.css">

</head>

<body>

<div class="container">

    <!-- Sidebar -->

    <div class="sidebar">

        <div class="logo">

            <img
                src="../logo.png"
                alt="RentEase Logo"
            >

            <div>

                <h3>
                    RentEase
                </h3>

                <p>
                    CLIENT PORTAL
                </p>

            </div>

        </div>


        <div class="menu">

            <a href="../Controller/dashboard-controller.php">

                <p>
                    Dashboard
                </p>

            </a>


            <a href="../Controller/rentals-controller.php">

                <p>
                    My Rentals
                </p>

            </a>


            <a href="../Controller/payment-controller.php">

                <p>
                    Payments
                </p>

            </a>


            <a href="../Controller/compare-controller.php">

                <p>
                    Compare
                </p>

            </a>


            <a href="../Controller/notifications-controller.php">

                <p class="active">
                    Notifications
                </p>

            </a>

        </div>


        <!-- Profile -->

        <div class="profile">

            <div class="circle">
                SJ
            </div>


            <div>

                <h5>
                    <?php echo htmlspecialchars($_SESSION['username'] ?? 'Client'); ?>
                </h5>

                <p></p>

            </div>

        </div>

    </div>


    <!-- Main Area -->

    <div class="main">

        <h1>
            Payment Notifications
        </h1>


        <div
            class="notification-box"
            id="notificationBox"
        >

            <?php if (empty($notifications)): ?>

                <div class="notification">

                    <div>

                        <h4>
                            No Notifications
                        </h4>

                        <p>
                            You currently have no notifications.
                        </p>

                    </div>

                </div>


            <?php else: ?>


                <?php foreach ($notifications as $notification): ?>

                    <div class="notification">

                        <div class="dot"></div>


                        <div>

                            <h4>

                                <?php
                                echo htmlspecialchars(
                                    $notification['title'] ?? ''
                                );
                                ?>

                            </h4>


                            <p>

                                <?php
                                echo htmlspecialchars(
                                    $notification['message'] ?? ''
                                );
                                ?>

                            </p>

                        </div>


                        <small>

                            <?php
                            echo htmlspecialchars(
                                $notification['created_at'] ?? ''
                            );
                            ?>

                        </small>

                    </div>

                <?php endforeach; ?>


            <?php endif; ?>

        </div>

    </div>

</div>

</body>

</html>