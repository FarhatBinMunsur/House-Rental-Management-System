<?php

$compareProperties = $compareProperties ?? [];

?>

<!DOCTYPE html>
<html>

<head>

    <title>Compare Properties</title>

    <link rel="stylesheet" href="/HouseRentalManagementSystem/View/style1.css">

</head>

<body>

<div class="container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">

            <img src="../logo.png" alt="RentEase Logo">

            <div>

                <h3>
                    RentEase
                </h3>

                <p>
                    CLIENT PORTAL
                </p>

            </div>

        </div>


        <div class="menu">

            <a href="../Controller/dashboard-controller.php">

                <p>
                    Dashboard
                </p>

            </a>


            <a href="../Controller/rentals-controller.php">

                <p>
                    My Rentals
                </p>

            </a>


            <a href="../Controller/payment-controller.php">

                <p>
                    Payments
                </p>

            </a>


            <a href="../Controller/compare-controller.php">

                <p class="active">
                    Compare
                </p>

            </a>


            <a href="../ClientNotifications.php">

                <p>
                    Notifications
                </p>

            </a>

        </div>


        <div class="profile">

            <div class="circle">
                CL
            </div>

            <div>

                <h5>
                    <?php echo htmlspecialchars($_SESSION['username'] ?? 'Client'); ?>
                </h5>

                <p></p>

            </div>

        </div>

    </div>


    <!-- MAIN CONTENT -->

    <div class="main">

        <h1>
            Compare Properties
        </h1>


        <?php if (empty($compareProperties)): ?>

            <div class="no-properties">

                <h3>
                    No properties selected for comparison.
                </h3>

                <p>
                    Go to the dashboard and select properties to compare.
                </p>

            </div>

        <?php else: ?>


            <div class="property-list">


                <?php foreach ($compareProperties as $property): ?>


                    <div class="property-card">


                        <!-- PROPERTY IMAGE -->

                        <img
                            src="<?php
                                echo !empty($property['images'])
                                    ? htmlspecialchars($property['images'])
                                    : '../house1.jpg';
                            ?>"
                            alt="Property Image"
                        >


                        <!-- PROPERTY TITLE -->

                        <h3>

                            <?php
                            echo htmlspecialchars(
                                $property['Title'] ?? ''
                            );
                            ?>

                        </h3>


                        <!-- LOCATION -->

                        <p>

                            <?php
                            echo htmlspecialchars(
                                $property['location'] ?? ''
                            );
                            ?>

                        </p>


                        <!-- PROPERTY DETAILS -->

                        <div class="details">


                            <span>

                                <?php
                                echo (int)($property['bedrooms'] ?? 0);
                                ?>

                                Beds

                            </span>


                            <span>

                                <?php
                                echo htmlspecialchars(
                                    $property['bathrooms'] ?? ''
                                );
                                ?>

                                Baths

                            </span>


                            <span>

                                <?php
                                echo htmlspecialchars(
                                    $property['area'] ?? ''
                                );
                                ?>

                                sqft

                            </span>


                        </div>


                        <!-- PRICE -->

                        <div class="bottom">


                            <h2>

                                $

                                <?php
                                echo number_format(
                                    (float)($property['rent'] ?? 0),
                                    0
                                );
                                ?>

                                /mo

                            </h2>


                            <a
                                href="../Controller/compare-remove-controller.php?id=<?php echo (int)$property['propertyID']; ?>"
                            >

                                Remove

                            </a>


                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </div>

</div>

</body>

</html>