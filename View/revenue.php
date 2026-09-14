<?php
session_start();

if (!isset($_SESSION["userId"]) || ($_SESSION["userRole"] ?? "") !== "owner") {
    header("Location: ./index.php");
    exit();
}

require_once "../db/db.php";
require_once "../Model/Payment.php";
$conn=new DBconnection();
$connection=$conn->connect();

$paymentModel = new Payment($connection);
$summary = $paymentModel->getSummary((int)$_SESSION["userId"]);
$payments = $paymentModel->getOwnerPayments((int)$_SESSION["userId"]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentEase - Revenue</title>
    <link rel="stylesheet" href="owner1.css">
</head>
<body>

<div class="dashboard">


<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-icon">⌂</div>
        <div class="logo-text">
            <h2>RentEase</h2>
            <span>OWNER PORTAL</span>
        </div>
    </div>
    
<!-- Navigation menu -->
    <nav class="navigation">
        <a href="ownerDashboard.php" class="nav-item ">Dashboard</a>
        <a href="post-rental.php" class="nav-item ">Post Rental</a>
        <a href="bookings.php" class="nav-item ">Bookings</a>
        <a href="revenue.php" class="nav-item active">Revenue</a>
        <a href="../Controller/logoutHandler.php" class="nav-item">Logout</a>
    </nav>

    <div class="profile">
        <div class="profile-avatar">
            <?php echo htmlspecialchars(strtoupper(substr($_SESSION["username"], 0, 2))); ?>
        </div>
        <div class="profile-info">
            <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>
            <small><?php echo htmlspecialchars($_SESSION["userEmail"]); ?></small>
        </div>
    </div>
</aside>


<main class="main-content">

    <header class="top-header">
        <h1>Total Revenue</h1>
    </header>

    <div class="content-box">

        <div class="cards">

            <div class="card">
                <p class="card-title">Total Revenue</p>
                <h2 class="card-value">
                    $<?php echo number_format($summary["totalRevenue"], 2); ?>
                </h2>
            </div>

            <div class="card">
                <p class="card-title">This Month</p>
                <h2 class="card-value">
                    $<?php echo number_format($summary["thisMonth"], 2); ?>
                </h2>
            </div>

            <div class="card">
                <p class="card-title">Active Tenants</p>
                <h2 class="card-value">
                    <?php echo (int)$summary["activeTenants"]; ?>
                </h2>
            </div>

        </div>

        <div class="payment-box">

            <h3 class="payment-title">Payment Records</h3>

            <table>
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Tenant</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                <?php // Display payment records for each property with client name 

                while ($row = mysqli_fetch_assoc($payments)) { ?>

                    <tr>
                        <td>
                            <?php echo htmlspecialchars($row["propertyTitle"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["tenantName"]); ?>
                        </td>

                        <td class="amount">
                            $<?php echo number_format((float)$row["amount"], 2); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["paymentDate"]); ?>
                        </td>

                        <td>
                            <span class="status 
                            <?php
                                echo strtoupper($row["status"]) === "RECEIVED"? "received": "pending";
                            ?>">
                                <?php echo htmlspecialchars(ucfirst(strtolower($row["status"]))); ?>
                            </span>
                        </td>

                    </tr>

                <?php } 
                ?>

                </tbody>

            </table>

        </div>

    </div>

</main>
</div>
</body>
</html>
