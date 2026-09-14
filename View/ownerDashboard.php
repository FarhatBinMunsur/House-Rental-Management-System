<?php

if (!isset($_SESSION["userId"]) || ($_SESSION["userRole"] ?? "") !== "owner") {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentEase Dashboard</title>
    <link rel="stylesheet" href="View/owner1.css">
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
    <a href="../index.php" class="nav-item" active>Dashboard</a>
    <a href="View/post-rental.php" class="nav-item">Post Rental</a>
    <a href="View/bookings.php" class="nav-item">Bookings</a>
    <a href="View/revenue.php" class="nav-item ">Revenue</a>
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
        <h1>Dashboard Overview</h1>
    </header>

    <section class="content">

        <div class="stats-card">

            <div class="stat-box">
                <span class="stat-label">Total Rental Posts</span>
                <strong class="stat-number" id="totalPosts">0 Posts</strong>
            </div>

            <div class="stat-box">
                <span class="stat-label">My available rents</span>
                <strong class="stat-number" id="availableRents">0 Rents</strong>
            </div>

            <div class="stat-box">
                <span class="stat-label">Rent Ongoing</span>
                <strong class="stat-number" id="rentOngoing">0 Rents</strong>
            </div>

        </div>

    </section>

</main>
</div>

<script src="View/owner.js"></script>
<script>
loadDashboardStats();
</script>
</body>
</html>
