<?php
session_start();

if (!isset($_SESSION["userId"]) || ($_SESSION["userRole"] ?? "") !== "owner") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentEase - Post Rental</title>
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
        <a href="post-rental.php" class="nav-item active ">Post Rental</a>
        <a href="bookings.php" class="nav-item ">Bookings</a>
        <a href="revenue.php" class="nav-item ">Revenue</a>
        <a href="../Controller/logoutHandler.php" class="nav-item">Logout</a>
    </nav>

        <div class="profile">

            <div class="profile-avatar">
                <?php
                echo htmlspecialchars( strtoupper(substr($_SESSION["username"], 0, 2)));
                ?>
            </div>

            <div class="profile-info">

                <strong>
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                </strong>

                <small>
                    <?php echo htmlspecialchars($_SESSION["userEmail"]); ?>
                </small>

            </div>

        </div>

    </aside>


    <main class="main-content">

        <header class="top-header">

            <h1> Post a Rental </h1>

        </header>

        <section class="post-content">

            <div class="rental-card">

                <h2> Enter Property Details </h2>

                <form id="propertyForm" enctype="multipart/form-data" novalidate >
                    
                    <div class="form-row">

                        <div class="form-group">

                            <label> Property Title </label>
                            <input type="text" name="title" id="title" placeholder="Enter property title">
                            <small class="field-error" id="titleError" ></small>

                        </div>

                        <div class="form-group">

                            <label> Property Type </label>

                            <select name="propertyType" id="propertyType" >

                            <option value="">  Select property type </option>

                            <option value="Villa"> Villa </option>

                            <option value="Apartment"> Apartment </option>

                            <option value="House"> House </option>

                            <option value="Townhouse"> Townhouse </option>

                             <option value="Cabin"> Cabin </option>

                            <option value="Studio"> Studio </option>

                            </select>

                            <small class="field-error" id="propertyTypeError"></small>

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group">

                            <label> Location / Address </label>

                            <input type="text" name="location" id="location" placeholder="Enter property location">

                            <small class="field-error" id="locationError"></small>

                        </div>


                        <div class="form-group">

                            <label> Monthly Rent ($) </label>

                            <input type="number" name="rent" id="rent" min="1"
                                step="0.01"
                                placeholder="Enter monthly rent">

                            <small class="field-error" id="rentError" ></small>

                        </div>

                    </div>

                    <div class="form-row four-columns">

                        <div class="form-group">

                            <label> Bedrooms </label>

                            <input type="number" name="bedrooms" id="bedrooms" min="0" placeholder="0" >

                            <small class="field-error" id="bedroomsError"></small>

                        </div>

                        <div class="form-group">

                            <label> Bathrooms </label>

                            <input type="number" name="bathrooms" id="bathrooms" min="0" placeholder="0">

                            <small class="field-error" id="bathroomsError" ></small>

                        </div>


                        <div class="form-group">

                            <label> Area (sqft) </label>

                            <input type="number" name="area" id="area" min="1" placeholder="0">

                            <small class="field-error" id="areaError"> </small>

                        </div>


                        <div class="form-group">

                            <label> Availability Date </label>

                            <input type="date" name="availabilityDate" id="availabilityDate">

                            <small class="field-error" id="availabilityDateError"> </small>

                        </div>

                    </div>

                    <div class="form-group description-group">

                        <label> Description </label>

                        <textarea name="description" id="description" maxlength="1000"
                            placeholder="Describe the property's features, amenities, local neighborhood, school district and transit accessibility..."
                        ></textarea>

                        <small class="field-error" id="descriptionError"> </small>

                    </div>


                    <div class="form-group">

                        <label> Property Images </label>

                        <label class="upload-box">

                            <input type="file" name="images[]" id="images"
                                multiple accept=".png,.jpg,.jpeg">

                            <span class="upload-title">Click to upload images </span>

                            <span class="upload-info"> PNG, JPG or JPEG up to 10MB each </span>

                        </label>

                        <small class="field-error" id="imagesError" ></small>

                    </div>


                    <div id="propertyMessage"></div>

                    <div class="button-area">

                        <button type="submit"> Post </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

<script src="owner.js"></script>

</body>
</html>
