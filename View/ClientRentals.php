<?php

$rentals = $rentals ?? [];
$activeRentals = $activeRentals ?? 0;
$totalPaid = $totalPaid ?? 0;

?>

<!DOCTYPE html>

<html>

<head>

    <title>RentEase My Rentals</title>

    <link rel="stylesheet" href="/HouseRentalManagementSystem/View/style1.css">

</head>


<body>


<div class="container">


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

    <div class="sidebar">


        <!-- Logo -->

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



        <!-- Menu -->

        <div class="menu">


            <!-- Dashboard -->

            <a href="../Controller/dashboard-controller.php">

                <p>
                    Dashboard
                </p>

            </a>



            <!-- My Rentals -->

            <a href="">

                <p class="active">
                    My Rentals
                </p>

            </a>



            <!-- Payments -->

            <a href="/HouseRentalManagementSystem/Controller/payment-controller.php?id=<?php
                echo !empty($rentals)
                    ? (int)$rentals[0]['id']
                    : 0;
            ?>">

                <p>
                    Payments
                </p>

            </a>



            <!-- Compare -->

            <a href="../View/ClientCompare.php">

                <p>
                    Compare
                </p>

            </a>



            <!-- Notifications -->

            <a href="../Controller/notifications-controller.php">

                <p>
                    Notifications
                </p>

            </a>


        </div>



        <!-- =================================================
             PROFILE
        ================================================== -->

        <div class="profile">


            <div class="circle">
                SJ
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



    <!-- =====================================================
         MAIN AREA
    ====================================================== -->

    <div class="main">


        <!-- Booking success -->

        <?php if (
            isset($_GET['booking']) &&
            $_GET['booking'] === 'success'
        ): ?>

            <div class="booking-success">
                Booking completed successfully.
            </div>

        <?php endif; ?>



        <!-- Cancellation messages -->

        <?php if (
            isset($_GET['cancel']) &&
            $_GET['cancel'] === 'success'
        ): ?>

            <div class="booking-success">
                Booking cancelled successfully.
            </div>


        <?php elseif (
            isset($_GET['cancel']) &&
            $_GET['cancel'] === 'failed'
        ): ?>

            <div class="booking-success">
                Booking could not be cancelled.
            </div>

        <?php endif; ?>



        <!-- Payment success -->

        <?php if (
            isset($_GET['payment']) &&
            $_GET['payment'] === 'success'
        ): ?>

            <div class="booking-success">
                Payment completed successfully.
            </div>

        <?php endif; ?>



        <!-- Page title -->

        <h1>
            My Rentals & Payments
        </h1>



        <!-- =================================================
             SUMMARY CARDS
        ================================================== -->

        <div class="rental-cards">


            <!-- Active Rentals -->

            <div class="rental-card">

                <p>
                    Active Rentals
                </p>

                <h2 id="activeRentals">
                    <?php echo (int)$activeRentals; ?>
                </h2>

            </div>



            <!-- Total Paid -->

            <div class="rental-card">

                <p>
                    Total Paid Transactions
                </p>

                <h2 id="totalPaid">
                    <?php echo (int)$totalPaid; ?>
                </h2>

            </div>


        </div>



        <!-- =================================================
             RENTAL TABLE
        ================================================== -->

        <div class="rental-table-box">


            <table>


                <thead>

                    <tr>

                        <th>
                            Property Name
                        </th>

                        <th>
                            Address
                        </th>

                        <th>
                            Monthly Rent
                        </th>

                        <th>
                            Start Date
                        </th>

                        <th>
                            Lease Status
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>



                <tbody id="rentalTable">


                    <?php if (!empty($rentals)): ?>


                        <?php foreach ($rentals as $x): ?>


                            <tr>


                                <!-- Property name -->

                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $x['title'] ?? ''
                                    );
                                    ?>

                                </td>



                                <!-- Address -->

                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $x['address'] ?? ''
                                    );
                                    ?>

                                </td>



                                <!-- Monthly rent -->

                                <td>

                                    $<?php
                                    echo number_format(
                                        (float)($x['monthly_rent'] ?? 0),
                                        0
                                    );
                                    ?>

                                </td>



                                <!-- Start date -->

                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $x['start_date'] ?? ''
                                    );
                                    ?>

                                </td>



                                <!-- Lease status -->

                                <td>


                                    <?php

                                    $leaseStatus =
                                        strtolower(
                                            $x['lease_status'] ?? ''
                                        );

                                    ?>


                                    <span class="<?php
                                        echo $leaseStatus === 'active'
                                            ? 'active-status'
                                            : 'expired-status';
                                    ?>">

                                        <?php
                                        echo htmlspecialchars(
                                            $x['lease_status'] ?? ''
                                        );
                                        ?>

                                    </span>


                                </td>



                                <!-- Payment -->

                                <td>


                                    <?php

                                    $paymentStatus =
                                        strtolower(
                                            $x['payment_status'] ?? ''
                                        );

                                    ?>


                                    <span class="<?php
                                        echo $paymentStatus === 'paid'
                                            ? 'paid-status'
                                            : 'due-status';
                                    ?>">

                                        <?php
                                        echo htmlspecialchars(
                                            $x['payment_status'] ?? ''
                                        );
                                        ?>

                                    </span>



                                    <?php if ($paymentStatus !== 'paid'): ?>


                                        <br>


                                        <a href="payment-controller.php?id=<?php
                                            echo (int)$x['id'];
                                        ?>">

                                            Pay Now

                                        </a>


                                    <?php endif; ?>


                                </td>



                                <!-- Action -->

                                <td>


                                    <?php if ($leaseStatus === 'active'): ?>


                                        <form
                                            method="post"
                                            action="../Controller/cancel-booking-controller.php"
                                            onsubmit="return confirm('Are you sure you want to cancel this booking?');"
                                            style="margin:0;"
                                        >


                                            <input
                                                type="hidden"
                                                name="rental_id"
                                                value="<?php
                                                    echo (int)$x['id'];
                                                ?>"
                                            >


                                            <button
                                                type="submit"
                                                class="cancel-booking"
                                            >
                                                Cancel Booking
                                            </button>


                                        </form>


                                    <?php else: ?>


                                        <span>
                                            Cancelled
                                        </span>


                                    <?php endif; ?>


                                </td>


                            </tr>


                        <?php endforeach; ?>


                    <?php else: ?>


                        <!-- No rentals -->

                        <tr>

                            <td colspan="7">

                                <p>
                                    You currently have no rentals.
                                </p>

                            </td>

                        </tr>


                    <?php endif; ?>


                </tbody>


            </table>


        </div>


    </div>


</div>


</body>

</html>