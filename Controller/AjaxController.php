<?php

session_start();

header("Content-Type: application/json");

require_once "../Model/user.php";
require_once "../Model/UserModel.php";
require_once "../Model/PropertyModel.php";
require_once "../Model/PaymentModel.php";
require_once "../Model/NotificationModel.php";

if (!isset($_SESSION["userId"]) || $_SESSION["userRole"] != "manager") {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);
    exit();
}

$action = $_GET["action"] ?? "";

$propertyModel = new PropertyModel();
$paymentModel = new PaymentModel();
$userModel = new User();
$notificationModel = new NotificationModel();


if ($action == "dashboard") {

    $data = $propertyModel->getDashboardCounts();

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
    exit();
}


if ($action == "posts") {

    $status = $_GET["status"] ?? "all";

    $allowed = ["all", "Pending", "Accepted", "Rejected"];

    if (!in_array($status, $allowed)) {
        $status = "all";
    }

    $data = $propertyModel->getPosts($status);

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
    exit();
}


if ($action == "postStatus") {

    $input = json_decode(file_get_contents("php://input"), true);

    $propertyID = filter_var(
        $input["propertyID"] ?? "",
        FILTER_VALIDATE_INT
    );

    $status = $input["status"] ?? "";

    if (!$propertyID ||
        !in_array($status, ["Accepted", "Rejected"])) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid data"
        ]);
        exit();
    }

    $result = $propertyModel->updateStatus(
        $propertyID,
        $status
    );

    echo json_encode([
        "success" => $result,
        "message" => $result
            ? "Post updated successfully"
            : "Update failed"
    ]);

    exit();
}


if ($action == "payments") {

    $search = trim($_GET["search"] ?? "");

    $data = $paymentModel->searchPayments($search);

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

    exit();
}


if ($action == "clients") {

    $data = $userModel->getClients();

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

    exit();
}


if ($action == "clientProperties") {

    $clientID = filter_input(
        INPUT_GET,
        "clientID",
        FILTER_VALIDATE_INT
    );

    if (!$clientID) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid client"
        ]);
        exit();
    }

    $data = $propertyModel->getClientProperties($clientID);

    foreach ($data as &$row) {
        $row["amount"] =
            $paymentModel->getAmountByBooking(
                $row["bookingID"]
            );
    }

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

    exit();
}


if ($action == "sendNotification") {

    $input = json_decode(file_get_contents("php://input"), true);

    $clientID = filter_var(
        $input["clientID"] ?? "",
        FILTER_VALIDATE_INT
    );

    $propertyID = filter_var(
        $input["propertyID"] ?? "",
        FILTER_VALIDATE_INT
    );

    $dueDate = trim($input["dueDate"] ?? "");
    $message = trim($input["message"] ?? "");

    if (!$clientID ||
        !$propertyID ||
        $dueDate == "" ||
        $message == "") {

        echo json_encode([
            "success" => false,
            "message" => "All fields are required"
        ]);
        exit();
    }

    if (strlen($message) > 1000) {
        echo json_encode([
            "success" => false,
            "message" => "Message is too long"
        ]);
        exit();
    }

    $booking = $propertyModel->getBooking(
        $clientID,
        $propertyID
    );

    if (!$booking) {
        echo json_encode([
            "success" => false,
            "message" => "Booking not found"
        ]);
        exit();
    }

    $result = $notificationModel->addNotification(
        $booking["bookingID"],
        $_SESSION["userId"],
        $clientID,
        $message,
        $dueDate
    );

    echo json_encode([
        "success" => $result,
        "message" => $result
            ? "Notification sent"
            : "Notification failed"
    ]);

    exit();
}


if ($action == "notifications") {

    $data = $notificationModel->getNotifications(
        $_SESSION["userId"]
    );

    foreach ($data as &$row) {

        $row["amount"] =
            $paymentModel->getAmountByBooking(
                $row["bookingID"]
            );
    }

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

    exit();
}


echo json_encode([
    "success" => false,
    "message" => "Invalid action"
]);
?>
