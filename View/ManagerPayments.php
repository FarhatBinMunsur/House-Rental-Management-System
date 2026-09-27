<?php


require_once __DIR__ . '/../Controller/MController.php';

checkManager();

?>

<html>

<head>
    <link rel="stylesheet" href="style2.css">
</head>

<body>

<div class="container">

<?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main">

        <h1>Payment Histories</h1>

        <input
            type="text"
            id="search"
            class="payment-search"
            placeholder="Search client name, property, transaction id..."
        >

        <div class="payment-table-box">

            <table>

                <thead>

                <tr>
                    <th>Client Name</th>
                    <th>Property</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                   
                    <th>Status</th>
                </tr>

                </thead>

                <tbody id="paymentTable"></tbody>

            </table>

        </div>

    </div>

</div>

<script>
window.pageName = "payments";
</script>

<script src="manager.js"></script>

</body>
</html>
