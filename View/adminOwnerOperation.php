<?php

?>
<html>
  <head>
    <title>RentEase Owners</title>

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

          <a href="AdminOwnerOperation.php">
            <p class="active">Owners</p>
          </a>

          <a href="adminEarnings.php">
            <p>Earnings</p>
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
        <h1>Owners</h1>

        <div class="manager-section">
          <!-- Owner Table -->

          <div class="manager-list">
            <input
              type="text"
              id="search"
              name="search"
              class="search"
              placeholder=" Search listings, people, emails..."
            />

            <table>
              <thead>
                <tr>
                  <th>Name</th>

                  <th>Email</th>

                  <th>Phone</th>

                  <th>Status</th>
                </tr>
              </thead>

              <tbody id="ownerTable">
                <!-- Database output will appear here -->
              </tbody>
            </table>

            <!-- Buttons -->

            <div class="buttons">
              <input type="button" class="new" value="New" />

              <input type="button" class="refresh" value="Refresh" />

              <input type="button" class="delete" value="Delete" />

              <input type="button" class="save" value="Save" />
            </div>
          </div>

          <!-- Owner Form -->

          <div class="manager-form">
            <label class="label" for="name"> Name </label>

            <input type="text" id="name" name="name" />

            <label class="label" for="email"> Email </label>

            <input type="email" id="email" name="email" />

            <label class="label" for="phone"> Phone </label>

            <input type="text" id="phone" name="phone" />

            <label class="label" for="address"> Address </label>

            <textarea id="address" name="address"> </textarea>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
