<div class="sidebar">

    <div class="logo">
        <div>
            <h3>RentEase</h3>
            <p>MANAGER PORTAL</p>
        </div>
    </div>

    <div class="menu">

        <a href="../index.php">
            <p>Dashboard</p>
        </a>

        <a href="ManagerPosts.php">
            <p>Posts</p>
        </a>

        <a href="ManagerPayments.php">
            <p>Payments</p>
        </a>

        <a href="ManagerNotifications.php">
            <p>Notifications</p>
        </a>

        <a href="../controller/logoutHandler.php">
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
