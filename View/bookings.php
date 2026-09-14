<?php
session_start();

if (!isset($_SESSION["userId"]) || ($_SESSION["userRole"] ?? "") !== "owner") {
    header("Location: index.php");
    exit();
}

// require_once "../db/db.php";
require_once "../Model/Booking.php";

$bookingModel = new Booking();

$bookings = $bookingModel->getOwnerBookings(
    (int)$_SESSION["userId"]
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentEase - Booking Requests</title>
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
        <a href="bookings.php" class="nav-item active">Bookings</a>
        <a href="revenue.php" class="nav-item ">Revenue</a>
        <a href="../Controller/LogoutHandler.php" class="nav-item">Logout</a>
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
        <h1>Booking Requests</h1>
    </header>

    <section class="booking-content">

        <div class="booking-card">

            <div id="bookingMessage"></div>

            <table class="booking-table">

                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Property</th>
                        <th>Requested Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($row = mysqli_fetch_assoc($bookings)) { ?>

                    <tr id="booking-<?php echo (int)$row["bookingID"]; ?>">

                        <td class="booking-client">
                            <?php echo htmlspecialchars($row["clientName"]); ?>
                        </td>

                        <td class="booking-property">
                            <?php echo htmlspecialchars($row["propertyTitle"]); ?>
                        </td>

                        <td class="booking-date">
                            <?php echo htmlspecialchars($row["bookingDate"]); ?>
                        </td>

                        <td class="booking-action-cell">

    <?php
    $status = strtoupper($row["status"]);
    ?>

    <?php 
    if ($status === "PENDING" || $status === "ACTIVE") { ?>

        <div class="booking-actions">

            <button type="button" class="accept-btn" onclick="updateBookingStatus(

                    <?php echo $row['bookingID']; ?>,'ACCEPTED')"> Accept

            </button>


            <button type="button" class="reject-btn" onclick="updateBookingStatus(

                    <?php echo $row['bookingID']; ?>, 'REJECTED')"> Reject

            </button>

        </div>

    <?php } elseif ($status === "ACCEPTED") { ?>

        <span class="status-badge status-accepted"> Accepted </span>

    <?php } elseif ($status === "REJECTED") { ?>

        <span class="status-badge status-rejected"> Rejected </span>

    <?php } ?>

</td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </section>

</main>
</div>

<script src="owner.js"></script>
</body>
</html>
