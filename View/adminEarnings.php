<html>
  <head>
    <title>RentEase Earnings</title>

    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <div class="container">
      <!-- Sidebar -->

      <div class="sidebar">
        <div class="logo">
          <img src="logo.png" />

          <div>
            <h3>RentEase</h3>

            <p>ADMIN PORTAL</p>
          </div>
        </div>

        <div class="menu">
          <a href="adminDashboard.php">
            <p>Dashboard</p>
          </a>

          <a href="adminManagersOperation.php">
            <p>Managers</p>
          </a>

          <a href="adminOwnerOperation.php">
            <p>Owners</p>
          </a>

          <a href="adminEarnings.php">
            <p class="active">Earnings</p>
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

      <!-- Main Area -->

      <div class="main">
        <h1>Earnings & Revenue</h1>

        <!-- Earnings Summary Cards -->

        <div class="earning-cards">
          <div class="earning-card">
            <p>Total Earnings</p>

            <h2 id="totalEarnings"></h2>
          </div>

          <div class="earning-card">
            <p>This Month</p>

            <h2 id="monthlyEarnings"></h2>
          </div>

          <div class="earning-card">
            <p>Pending Payments</p>

            <h2 id="pendingPayments"></h2>
          </div>
        </div>

        <!-- Transaction Table -->

        <div class="transaction-box">
          <h3>Recent Transactions</h3>

          <table>
            <thead>
              <tr>
                <th>Date</th>

                <th>Property</th>

                <th>Client</th>

                <th>Amount</th>

                <th>Status</th>
              </tr>
            </thead>

            <tbody id="transactionTable">
              <!-- Database data will be loaded here -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
