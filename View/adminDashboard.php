<?php
session_start();

if (!isset($_SESSION['dashboardData'])) {
    header('Location: ../controller/DashboardController.php');
    exit();
}
$summary = $_SESSION['dashboardData'];
?>

<html>
  <head>
    <title>RentEase Admin Dashboard</title>

    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <div class="container">

      <div class="sidebar">
        <div class="logo">
          <img src="logo.png" />

          <div>
            <h3>RentEase</h3>

            <p>ADMIN PORTAL</p>
          </div>
        </div>

        <div class="menu">
          <a href="../controller/DashboardController.php">
            <p class="active">Dashboard</p>
          </a>

          <a href="adminManagersOperation.php">
            <p>Managers</p>
          </a>

          <a href="adminOwnerOperation.php">
            <p>Owners</p>
          </a>

          <a href="adminEarnings.php">
            <p>$ Earnings</p>
          </a>
        </div>

        <div class="profile">
          <div class="circle">AD</div>

          <div>
            <h5>Admin Supervisor</h5>

            <p>admin@rentease.com</p>
          </div>
        </div>
      </div>

      <!-- Dashboard -->

      <div class="main">
        <h1>Dashboard Overview</h1>

        <div class="top-cards">
          <div class="card">
            <p>Total Clients</p>
            <h2 id="totalClients"> <?php echo $summary['totalClients'];?></h2>
          </div>

          <div class="card">
            <p>Total Managers</p>
            <h2 id="totalClients"> <?php echo $summary['totalManagers'];?></h2>
          </div>

          <div class="card">
            <p>Total Owners</p>
            <h2 id="totalClients"> <?php echo $summary['totalOwners'];?></h2>
          </div>

          <div class="card">
            <p>Total Properties</p>
            <h2 id="totalClients"> <?php echo $summary['totalProperties'];?></h2>
          </div>
        </div>

        <div class="bottom-cards">
          <div class="big-card">
            <span> Available </span>
            <h4>Available Properties</h4>
            <h1 id="availableProperties"><?php echo $summary['availableProperties']; ?></h1>
          </div>

          <div class="big-card">
            <span> Rented </span>
            <h4>Rented Properties</h4>
            <h1 id="rentedProperties"><?php echo $summary['rentedProperties']; ?></h1>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
