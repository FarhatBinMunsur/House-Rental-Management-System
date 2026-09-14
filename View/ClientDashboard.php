<!DOCTYPE html>

<html>

<head>

    <title>RentEase Client Portal</title>

    <link rel="stylesheet" href="/HouseRentalManagementSystemRayen/View/style1.css">

</head>


<body>


<div class="container">


    <!-- ================= SIDEBAR ================= -->

    <div class="sidebar">


        <div class="logo">

            <img src="../logo.png">

            <div>

                <h3>
                    RentEase
                </h3>

                <p>
                    CLIENT PORTAL
                </p>

            </div>

        </div>



        <!-- Menu -->

        <div class="menu">


            <a href="">

                <p class="active">
                    Dashboard
                </p>

            </a>



            <a href="/HouseRentalManagementSystem/Controller/rentals-controller.php">

                <p>
                    My Rentals
                </p>

            </a>



            <a href="/HouseRentalManagementSystem/Controller/payment-controller.php">

                <p>
                    Payments
                </p>

            </a>



<a href="../Controller/compare-controller.php?id=<?php echo (int)$property['propertyID']; ?>">
                <p>
                    Compare
                </p>

            </a>



            <a href="../Controller/notifications-controller.php">

                <p>
                    Notifications
                </p>

            </a>


        </div>



        <!-- Profile -->

        <div class="profile">


            <div class="circle">
                CL
            </div>


            <div>

                <h5>
                    <?php echo $_SESSION['username'] ?>
                </h5>

                <p>
                    
                </p>

            </div>


        </div>


    </div>



    <!-- ================= MAIN CONTENT ================= -->

    <div class="main">


        <h1>
            Available Properties
        </h1>



        <!-- ================= SEARCH SECTION ================= -->

        <form
            class="search-area"
            method="get"
            action="../Controller/dashboard-controller.php"
        >


            <!-- Location search -->

            <input
                type="text"
                id="location"
                name="location"
                value="<?php echo htmlspecialchars($location); ?>"
                placeholder="Search location..."
            >



            <!-- Price range -->

            <select name="price_range">

                <option value="">
                    Price Range
                </option>


                <option
                    value="under_2000"
                    <?php echo ($priceRange === "under_2000") ? "selected" : ""; ?>
                >
                    Under $2,000
                </option>


                <option
                    value="2000_3000"
                    <?php echo ($priceRange === "2000_3000") ? "selected" : ""; ?>
                >
                    $2,000 - $3,000
                </option>


                <option
                    value="over_3000"
                    <?php echo ($priceRange === "over_3000") ? "selected" : ""; ?>
                >
                    Over $3,000
                </option>

            </select>



            <!-- Property type -->

            <select name="property_type">

                <option value="">
                    Property Type
                </option>


                <?php foreach ($types as $type): ?>

                    <option
                        value="<?php echo htmlspecialchars($type); ?>"
                        <?php echo ($propertyType === $type) ? "selected" : ""; ?>
                    >

                        <?php echo htmlspecialchars($type); ?>

                    </option>

                <?php endforeach; ?>

            </select>



            <!-- Search button -->

            <input
                type="submit"
                value="Search"
            >


        </form>



        <!-- ================= PROPERTY CARDS ================= -->


        <div class="property-list">


            <?php if (!empty($properties)): ?>


                <?php foreach ($properties as $property): ?>


                    <div class="property-card">


                        <!-- Property image -->

                        <img
                            src="<?php
                                echo !empty($property['images'])
                                    ? htmlspecialchars($property['images'])
                                    : 'house1.jpg';
                            ?>"
                            alt="Property Image"
                        >



                        <!-- Property title -->

                        <h3>

                            <?php
                            echo htmlspecialchars($property['Title']);
                            ?>

                        </h3>



                        <!-- Location -->

                        <p>

                            <?php
                            echo htmlspecialchars($property['location']);
                            ?>

                        </p>



                        <!-- Details -->

                        <div class="details">


                            <span>

                                <?php
                                echo (int)$property['bedrooms'];
                                ?>

                                Beds

                            </span>



                            <span>

                                <?php
                                echo htmlspecialchars($property['bathrooms']);
                                ?>

                                Baths

                            </span>


                        </div>



                        <!-- Bottom -->

                        <div class="bottom">


                            <h2>

                                $<?php
                                echo number_format(
                                    (float)$property['rent'],
                                    0
                                );
                                ?>/mo

                            </h2>



                        <a href="/HouseRentalManagementSystemRayen/Controller/property-details-controller.php?id=<?php echo (int)$property['propertyID']; ?>">
    View Details
</a>


                        </div>


                    </div>


                <?php endforeach; ?>


            <?php else: ?>


                <!-- No properties -->

                <div class="no-properties">

                    <h3>
                        No properties found
                    </h3>

                    <p>
                        Try changing your search filters.
                    </p>

                </div>


            <?php endif; ?>


        </div>


    </div>


</div>


</body>

</html>