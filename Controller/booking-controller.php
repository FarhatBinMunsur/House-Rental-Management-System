<?php

require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../Model/Rental.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /HouseRentalManagementSystem/index.php');
    exit();
}

$propertyId = (int)($_POST['property_id'] ?? 0);

if ($propertyId <= 0) {
    header('Location: /HouseRentalManagementSystem/index.php');
    exit();
}

$rentalModel = new Rental();

$result = $rentalModel->createBooking($userId, $propertyId);

if ($result['success']) {

    header(
        'Location: /HouseRentalManagementSystem/Controller/rentals-controller.php?booking=success'
    );
    exit();

}

header(
    'Location: /HouseRentalManagementSystem/Controller/property-details-controller.php?id='
    . $propertyId
    . '&booking_error='
    . urlencode($result['message'])
);

exit();

?>