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

        <h1>Rental Posts</h1>

        <div class="post-filter">

            <button
                class="filterButton active-filter"
                data-status="all"
            >
                All Posts
            </button>

            <button
                class="filterButton"
                data-status="Pending"
            >
                Pending
            </button>

            <button
                class="filterButton"
                data-status="Accepted"
            >
                Accepted
            </button>

            <button
                class="filterButton"
                data-status="Rejected"
            >
                Rejected
            </button>

        </div>

        <p id="postMessage"></p>

        <div class="post-table-box">

            <table>

                <thead>

                <tr>
                    <th>Property Name</th>
                    <th>Owner</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                </thead>

                <tbody id="postTable"></tbody>

            </table>

        </div>

    </div>

</div>

<script>
window.pageName = "posts";
</script>

<script src="manager.js"></script>

</body>
</html>
