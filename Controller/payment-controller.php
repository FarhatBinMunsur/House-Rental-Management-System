<?php

session_start();

require_once __DIR__ . '/../model/Rental.php';


// =====================================================
// CHECK LOGIN
// =====================================================

if (!isset($_SESSION['userId'])) {

    header("Location: ../View/login.php");
    exit();

}


$userId = (int)$_SESSION['userId'];

$rentalModel = new Rental();


// =====================================================
// PAY NOW
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rentalId = (int)($_POST['rental_id'] ?? 0);


    if ($rentalId <= 0) {

        header(
            "Location: payment-controller.php?payment=failed"
        );

        exit();

    }


    // Mark this rental as paid

    $success = $rentalModel->markPaid(
        $rentalId,
        $userId
    );


    if ($success) {

        header(
            "Location: payment-controller.php?payment=success"
        );

        exit();

    }


    header(
        "Location: payment-controller.php?payment=failed"
    );

    exit();

}


// =====================================================
// GET RENTALS
// =====================================================

$rentals = $rentalModel->getByUser($userId);


// =====================================================
// CALCULATE SUMMARY
// =====================================================

$activeRentals = 0;

$totalPaid = 0;


foreach ($rentals as $rental) {


    if (
        strtolower(
            $rental['lease_status'] ?? ''
        ) === 'active'
    ) {

        $activeRentals++;

    }


    if (
        strtolower(
            $rental['payment_status'] ?? ''
        ) === 'paid'
    ) {

        $totalPaid++;

    }

}


// =====================================================
// SHOW PAYMENT PAGE
// =====================================================

require_once __DIR__ . '/../View/ClientPayment.php';

?>
