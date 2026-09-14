<?php

session_start();

require_once "../db/db.php";
require_once "../Model/Booking.php";

header("Content-Type: application/json");

// Check owner login
if (
    !isset($_SESSION["userId"]) ||
    strtoupper($_SESSION["userRole"] ?? "") !== "OWNER"
) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Please sign in as an owner."
    ]);

    exit();
}


$bookingModel = new Booking();

$action = $_GET["action"] ?? "";


if ($action === "updateStatus") {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {

        echo json_encode([
            "success" => false,
            "message" => "Invalid request."
        ]);

        exit();
    }

// Validate and check  booking ID

    $bookingID = filter_input(
        INPUT_POST,
        "bookingID",
        FILTER_VALIDATE_INT
    );

    $status = strtoupper(
        trim($_POST["status"] ?? "")
    );

    if (!$bookingID) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid booking ID."
        ]);

        exit();
    }


// Check booking status accepted or rejecred

    if (!in_array(
        $status,
        ["ACCEPTED", "REJECTED"],
        true
    )) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid booking status."
        ]);

        exit();
    }


    $updated = $bookingModel->updateStatus(
        $bookingID,
        (int)$_SESSION["userId"],
        $status
    );


    if ($updated) {

        echo json_encode([
            "success" => true,
            "message" => "Booking status updated.",
            "status" => $status
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" =>
                "Booking was not found or already has this status."
        ]);
    }

    exit();
}

echo json_encode([
    "success" => false,
    "message" => "Unknown action."
]);

?>