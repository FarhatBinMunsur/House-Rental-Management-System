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
        <!-- <img src="logo.png" /> -->

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
          <form action="../controller/logoutHandler.php">
            <button class="logout">Log Out</button>
          </form>
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

          </tbody>
        </table>
      </div>

      <div id="refresh">
        <button class="refresh" id="refreshbutton">Refresh</button>
      </div>
    </div>
  </div>





  <!-- Api call Script code -->


  <script>
    function loadEarningsData() {
      const xhr = new XMLHttpRequest();

      xhr.open('GET', 'http://localhost/HouseRentalManagementSystem/api/earningsData.php', true);

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {

            var data = JSON.parse(xhr.responseText);

            console.log(xhr.responseText);

            // Fill summary cards
            document.getElementById('totalEarnings').innerText = data.summary.totalEarnings;
            document.getElementById('monthlyEarnings').innerText = data.summary.monthlyEarnings;
            document.getElementById('pendingPayments').innerText = data.summary.pendingPayments;

            // Fill transaction table
            var table = document.getElementById('transactionTable');
            table.innerHTML = '';
            var transactions = data.transactions;

            for (let i = 0; i < transactions.length; i++) {

              var date_td = document.createElement('td');
              var property_td = document.createElement('td');
              var client_td = document.createElement('td');
              var amount_td = document.createElement('td');
              var status_td = document.createElement('td');

              date_td.innerText = transactions[i].paymentDate;
              property_td.innerText = transactions[i].Title;
              client_td.innerText = transactions[i].clientName;
              amount_td.innerText = transactions[i].amount;
              status_td.innerText = transactions[i].status;

              var tr = document.createElement('tr');
              tr.appendChild(date_td);
              tr.appendChild(property_td);
              tr.appendChild(client_td);
              tr.appendChild(amount_td);
              tr.appendChild(status_td);

              table.appendChild(tr);
            }
          }
        }
      }

      xhr.send();
    }

    document.getElementById("refreshbutton").addEventListener('click', loadEarningsData);
    document.addEventListener('DOMContentLoaded', loadEarningsData); // load once on page open too
  </script>

</body>



</html>