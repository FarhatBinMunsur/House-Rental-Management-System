<?php
session_start();
require_once __DIR__ . '/../model/ownerModel.php';

$ownerModel= new OwnerModel();
$owners=$ownerModel->getAllOwners();

$selectedOwner;
if(isset($_GET['id'])){
  $selectedOwner = $ownerModel->getOwnerById($_GET['id']);
}

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
        <div class="circle"><?php echo $_SESSION['username'][0];?></div>
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

        <form action="../controller/ownerController.php" method="POST">
          
        <input type="hidden" name="ownerID" value="<?php echo $selectedOwner['userID']?? ''; ?>">

        <div class="manager-section">
          <!-- Owner Table -->

          <div class="manager-list">
            <input type="text" id="search" name="search" class="search"
              placeholder=" Search listings, people, emails..."/>

            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                </tr>
              </thead>


              <tbody id="ownerTable">
                <?php foreach  ($owners as $on) { ?>
                <tr onclick = "window.location = '?id=<?php echo $on['userID'];?>'">
                  <td><?php echo $on['userID']?></td>
                  <td><?php echo $on['userName']?></td>
                  <td><?php echo $on['userEmail']?></td>
                  <td><?php echo $on['phone']?></td>
                  <td><?php echo $on['address']?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>

            <!-- Buttons -->

            <div class="buttons">
              <a href="adminOwnerOperation.php"><input type="button" class="new" value="New" /></a>

              <input type="submit" name="formAction" class="refresh" value="Update" />

              <input type="submit" name="formAction" class="delete" value="Delete" />

              <input type="submit" name="formAction" class="save" value="Save" />
            </div>

          </div>

          <!-- Form -->

          <div class="manager-form">
            <label class="label" for="name"> Name </label>
            <input type="text" id="name" name="name" value=" <?php echo $selectedOwner['userName']??'' ?>"/>

            <label class="label" for="email"> Email </label>
            <input type="email" id="email" name="email" value=" <?php echo $selectedOwner['userEmail']??'' ?>" />

            <label class="label" for="phone"> Phone </label>
            <input type="text" id="phone" name="phone" value="<?php echo $selectedOwner['phone']??'' ?>"/>

            <label class="label" for="address"> Address </label>
            <textarea id="address" name="address" > <?php echo $selectedOwner['address']??'' ?> </textarea>
          </div>
          
          
        </div>
        </form>
        <?php
              if(isset($_SESSION['OnOpError']))
                echo "<p style='color:red;font-family:Cambria;font-weight: bold;  text-align:right; margin-right:70px;margin-top:20px' >" . $_SESSION['OnOpError'] . "</p>";
                unset($_SESSION['OnOpError']); 
        ?>
      </div>
    </div>
  </body>
</html>
