<?php
session_start(); 
require_once __DIR__ . '/../model/managerModel.php';

$managerModel = new ManagerModel();
$managers = $managerModel->getAllManagers();

// If a row was selected via ?id=, load that manager into the form
$selectedManager = null;
if (isset($_GET['id'])) {
  $selectedManager = $managerModel->getManagerById($_GET['id']);
}
?>
<html>

<head>
  <title>RentEase Managers</title>
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
          <p class="active">Managers</p>
        </a>
        <a href="AdminOwnerOperation.php">
          <p>Owners</p>
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
      <h1>Managers</h1>

      <form action="../controller/managerController.php" method="post">

        <!-- Carries the currently selected manager's ID (empty if none selected) -->
        <input type="hidden" name="managerID" value="<?php echo $selectedManager['userID'] ?? ''; ?>">

        <div class="manager-section">
          <!-- Manager Table -->

          <div class="manager-list">
            <input type="text" id="search" name="search" class="search"
              placeholder="Search listings, people, emails..." />

            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Salary</th>
                  <th></th>
                </tr>
              </thead>

              <tbody id="managerTable">
                <?php foreach ($managers as $m): ?>
                  <tr onclick="window.location='?id=<?php echo $m['userID']; ?>' " ">
                  <td><?php echo $m['userID']?></td>  
                  <td><?php echo $m['userName']; ?></td>
                    <td><?php echo $m['userEmail']; ?></td>
                    <td><?php echo $m['phone']; ?></td>
                    <td><?php echo $m['salary']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

            <!-- Buttons -->

            <div class="buttons">
              <a href="adminManagersOperation.php"><input type="button" class="new" value="New" /></a>

              <input type="submit" name="formAction" value="Update" class="refresh" />

              <!-- DELETE removes the selected manager -->
              <input type="submit" name="formAction" value="Delete" class="delete" />

              <!-- SAVE inserts a new manager -->
              <input type="submit" name="formAction" value="Save" class="save" />
            </div>

            <?php
            if(isset($_SESSION['MgOpError']))
            echo "<p style=color:red; align-items:center; >" . $_SESSION['MgOpError'] . "</p>" ;
            unset($_SESSION['MgOpError']);
            ?>
            
            
          </div>

          <!-- Manager Form -->

          <div class="manager-form">
            <label class="label" for="name"> Name </label>
            <input type="text" id="name" name="name" value="<?php echo $selectedManager['userName'] ?? ''; ?>" />

            <label class="label" for="email"> Email </label>
            <input type="email" id="email" name="email" value="<?php echo $selectedManager['userEmail'] ?? ''; ?>" />

            <label class="label" for="phone"> Phone </label>
            <input type="text" id="phone" name="phone" value="<?php echo $selectedManager['phone'] ?? ''; ?>" />

            <label class="label" for="salary"> Salary </label>
            <input type="text" id="salary" name="salary" value="<?php echo $selectedManager['salary'] ?? ''; ?>" />

            <label class="label" for="joiningDate"> Joining Date </label>
            <input type="date" id="joiningDate" name="joiningDate"
              value="<?php echo $selectedManager['joiningDate'] ?? ''; ?>" />
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

</html>