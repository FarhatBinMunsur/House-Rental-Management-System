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

        <h1>Send Payment Notification</h1>

        <div class="notification-form">

            <h2>New Payment Notification</h2>

            <label>Select Client</label>

            <select id="client">
                <option value="">Select Client</option>
            </select>

            <span id="clientError" class="error"></span>


            <label>Select Property</label>

            <select id="property">
                <option value="">Select Property</option>
            </select>

            <span id="propertyError" class="error"></span>


            <label>Amount Due ($)</label>

            <input
                type="text"
                id="amount"
                readonly
            >


            <label>Due Date</label>

            <input
                type="date"
                id="dueDate"
            >

            <span id="dueDateError" class="error"></span>


            <label>Notification Message</label>

            <textarea id="message"></textarea>

            <span id="messageError" class="error"></span>


            <button id="sendButton">
                Send Notification
            </button>

            <div style="clear:both"></div>

            <p id="notificationMessage"></p>

        </div>


        <div class="notification-table">

            <h2>Recently Sent Notifications</h2>

            <table>

                <thead>

                <tr>
                    <th>Client</th>
                    <th>Property</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Sent Date</th>
                    <th>Status</th>
                </tr>

                </thead>

                <tbody id="notificationTable"></tbody>

            </table>

        </div>

    </div>

</div>

<script>
window.pageName = "notifications";
</script>

<script src="manager.js"></script>

</body>
</html>
