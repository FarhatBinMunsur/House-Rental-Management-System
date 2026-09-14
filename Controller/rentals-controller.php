<?php

require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../Model/Rental.php';


// Create Rental model
$rentalModel = new Rental();


// Get rentals belonging to logged-in user
$rentals = $rentalModel->getByUser($userId);


// Make sure rentals is always an array
if (!is_array($rentals)) {
    $rentals = [];
}


// Calculate summary information
$activeRentals = 0;
$totalPaid = 0;


foreach ($rentals as $rental) {

    // Count active rentals
    if (
        isset($rental['lease_status']) &&
        strtolower($rental['lease_status']) === 'active'
    ) {
        $activeRentals++;
    }


    // Count paid transactions
    if (
        isset($rental['payment_status']) &&
        strtolower($rental['payment_status']) === 'paid'
    ) {
        $totalPaid++;
    }
}


// Load the view
require_once __DIR__ . '/../View/ClientRentals.php';

?>