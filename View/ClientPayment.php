<?php

$rentals = $rentals ?? [];
$activeRentals = $activeRentals ?? 0;
$totalPaid = $totalPaid ?? 0;

?>

<!DOCTYPE html>

<html>

<head>

```
<title>RentEase Payments</title>

<link rel="stylesheet" href="/HouseRentalManagementSystem/View/style1.css">
```

</head>

<body>

<div class="container">

```
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

        <a href="../Controller/rentals-controller.php">

            <p>
                My Rentals
            </p>

        </a>



        <!-- Payments -->

        <a href="../Controller/payment-controller.php">

            <p class="active">
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
        Payments
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
         PAYMENT TABLE
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



            <tbody>


                <?php if (!empty($rentals)): ?>


                    <?php foreach ($rentals as $rental): ?>


                        <tr>


                            <!-- Property Name -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $rental['title'] ?? ''
                                );

                                ?>

                            </td>



                            <!-- Address -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $rental['address'] ?? ''
                                );

                                ?>

                            </td>



                            <!-- Monthly Rent -->

                            <td>

                                $<?php

                                echo number_format(
                                    (float)($rental['monthly_rent'] ?? 0),
                                    0
                                );

                                ?>

                            </td>



                            <!-- Start Date -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $rental['start_date'] ?? ''
                                );

                                ?>

                            </td>



                            <!-- Lease Status -->

                            <td>


                                <?php

                                $leaseStatus =
                                    strtolower(
                                        $rental['lease_status'] ?? ''
                                    );

                                ?>


                                <span class="<?php

                                    echo $leaseStatus === 'active'
                                        ? 'active-status'
                                        : 'expired-status';

                                ?>">

                                    <?php

                                    echo htmlspecialchars(
                                        $rental['lease_status'] ?? ''
                                    );

                                    ?>

                                </span>


                            </td>



                            <!-- Payment Status -->

                            <td>


                                <?php

                                $paymentStatus =
                                    strtolower(
                                        $rental['payment_status'] ?? ''
                                    );

                                ?>


                                <span class="<?php

                                    echo $paymentStatus === 'paid'
                                        ? 'paid-status'
                                        : 'due-status';

                                ?>">

                                    <?php

                                    echo htmlspecialchars(
                                        $rental['payment_status'] ?? ''
                                    );

                                    ?>

                                </span>


                            </td>



                            <!-- Action -->

                            <td>


                                <?php if ($paymentStatus === 'paid'): ?>


                                    <span>
                                        Paid
                                    </span>


                                <?php else: ?>


                                    <form
                                        method="post"
                                        action="/HouseRentalManagementSystem/Controller/payment-controller.php"
                                        style="margin:0;"
                                    >


                                        <input
                                            type="hidden"
                                            name="rental_id"
                                            value="<?php
                                                echo (int)$rental['id'];
                                            ?>"
                                        >


                                        <input
                                            type="hidden"
                                            name="payment_method"
                                            value="cash"
                                        >


                                        <button
                                            type="submit"
                                        >
                                            Pay Now
                                        </button>


                                    </form>


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
```

</div>

</body>

</html>
