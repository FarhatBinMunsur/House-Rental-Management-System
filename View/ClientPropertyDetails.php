<?php
$property = $property ?? null;

if (!$property) {
    exit('Property information not available.');
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Property Insights</title>

    <link rel="stylesheet" href="/HouseRentalManagementSystem/View/style1.css">

</head>


<body>


<div class="container">


    <!-- Sidebar -->

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

                <p class="active">
                    Dashboard
                </p>

            </a>


            <a href="../Controller/rentals-controller.php">

                <p>
                    My Rentals
                </p>

            </a>


            <a href="../Controller/rentals-controller.php">

                <p>
                    Payments
                </p>

            </a>


            <a href="../ClientCompare.php?id=<?php echo (int)$property['propertyID']; ?>">

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


        <div class="profile">


            <div class="circle">
                CL
            </div>


            <div>

                <h5>
                    Sarah Jenkins
                </h5>


                <p>
                    sarah@gmail.com
                </p>

            </div>


        </div>


    </div>


    <!-- Main Area -->

    <div class="main">


        <h1>
            Property Insights
        </h1>


        <!-- Property Image -->

        <div class="property-image">

            <img
                src="<?php echo htmlspecialchars(
                    !empty($property['images'])
                        ? $property['images']
                        : '../house1.jpg'
                ); ?>"
                alt="Property Image"
            >

        </div>


        <div class="details-section">


            <!-- Property Information -->

            <div class="property-info">


                <div class="title-price">


                    <h2>

                        <?php
                        echo htmlspecialchars(
                            $property['Title'] ?? ''
                        );
                        ?>

                    </h2>


                    <h2 class="price">

                        $
                        <?php
                        echo number_format(
                            (float)($property['rent'] ?? 0),
                            0
                        );
                        ?>
                        /mo

                    </h2>


                </div>


                <p>

                    <?php
                    echo htmlspecialchars(
                        $property['location'] ?? ''
                    );
                    ?>

                </p>


                <hr>


                <div class="property-data">


                    <div>

                        <h5>
                            Bedrooms
                        </h5>

                        <p>

                            <?php
                            echo (int)($property['bedrooms'] ?? 0);
                            ?>
                            Beds

                        </p>

                    </div>


                    <div>

                        <h5>
                            Bathrooms
                        </h5>

                        <p>

                            <?php
                            echo htmlspecialchars(
                                $property['bathrooms'] ?? ''
                            );
                            ?>
                            Baths

                        </p>

                    </div>


                    <div>

                        <h5>
                            Area Size
                        </h5>

                        <p>

                            <?php
                            echo htmlspecialchars(
                                $property['area'] ?? ''
                            );
                            ?>
                            sqft

                        </p>

                    </div>


                    <div>

                        <h5>
                            Type
                        </h5>

                        <p>

                            <?php
                            echo htmlspecialchars(
                                $property['propertyType'] ?? ''
                            );
                            ?>

                        </p>

                    </div>


                    <div>

                        <h5>
                            Available From
                        </h5>

                        <p>

                            <?php
                            echo htmlspecialchars(
                                $property['availabilityDate'] ?? ''
                            );
                            ?>

                        </p>

                    </div>


                </div>


                <hr>


                <h4>
                    About this Property
                </h4>


                <p class="description">

                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $property['description'] ?? ''
                        )
                    );
                    ?>

                </p>


            </div>


            <!-- Owner Contact -->

            <div class="owner-box">


                <h3>
                    Owner Contact
                </h3>


                <div class="owner">


                    <div class="circle">
                        DM
                    </div>


                    <div>

                        <h5>

                            <?php
                            echo htmlspecialchars(
                                $property['owner_name']
                                ?? 'Property Owner'
                            );
                            ?>

                        </h5>


                        <p>
                            Premium Listing Partner
                        </p>

                    </div>


                </div>


                <p>

                    ✉
                    <?php
                    echo htmlspecialchars(
                        $property['owner_email'] ?? ''
                    );
                    ?>

                </p>


                <p>

                    ☎
                    <?php
                    echo htmlspecialchars(
                        $property['owner_phone'] ?? ''
                    );
                    ?>

                </p>


                <?php if (!empty($_GET['booking_error'])): ?>

                    <div class="booking-error">

                        <?php
                        echo htmlspecialchars(
                            $_GET['booking_error']
                        );
                        ?>

                    </div>

                <?php endif; ?>


                <!-- Book Now -->

                <form
                    method="post"
                    action="../Controller/booking-controller.php"
                    class="booking-form"
                >

                    <input
                        type="hidden"
                        name="property_id"
                        value="<?php echo (int)$property['propertyID']; ?>"
                    >


                    <button
                        type="submit"
                        class="book"
                    >
                        Book Now
                    </button>

                </form>


                <!-- Compare -->

                <a href="../Controller/compare-controller.php?id=<?php echo (int)$property['propertyID']; ?>">

                    <button
                        type="button"
                        class="compare"
                    >
                        Compare Property
                    </button>

                </a>


            </div>


        </div>


    </div>


</div>


</body>

</html>