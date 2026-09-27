<?php

require_once __DIR__ . '/../db/db.php';


class Rental
{
    private $conn;


    // Establish database connection
    public function establishConnection()
    {
        $db = new DBConnection();

        return $db->connect();
    }



    // =========================================================
    // GET ALL RENTALS FOR ONE USER
    // =========================================================

    public function getByUser($userId)
    {
        $conn = $this->establishConnection();


        $sql = "SELECT
                    r.id,
                    r.userID,
                    r.propertyID,
                    r.monthly_rent,
                    r.start_date,
                    r.lease_status,
                    r.payment_status,
                    r.created_at,
                    p.Title AS title,
                    p.location AS address
                FROM rentals r
                INNER JOIN property p
                    ON p.propertyID = r.propertyID
                WHERE r.userID = ?
                ORDER BY r.start_date DESC";


        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }


        $stmt->bind_param("i", $userId);


        $stmt->execute();


        $result = $stmt->get_result();


        $rentals = $result->fetch_all(MYSQLI_ASSOC);


        $stmt->close();


        return $rentals;
    }



    // =========================================================
    // CREATE BOOKING
    // =========================================================

public function createBooking($userId, $propertyId)
{
    $conn = $this->establishConnection();

    try {

        // Start transaction
        $conn->begin_transaction();

        // -------------------------------------------------
        // Get property
        // -------------------------------------------------

        $sql = "SELECT propertyID, rent, status
                FROM property
                WHERE propertyID = ?
                FOR UPDATE";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception($conn->error);
        }

        $stmt->bind_param("i", $propertyId);
        $stmt->execute();

        $result = $stmt->get_result();
        $property = $result->fetch_assoc();

        if (!$property) {
            throw new Exception("Property not found.");
        }

        // -------------------------------------------------
        // Check property availability
        // -------------------------------------------------

        if (strtolower($property['status']) !== 'accepted') {
            throw new Exception("This property is no longer available.");
        }

        // -------------------------------------------------
        // Check existing rental
        // -------------------------------------------------

        $sql = "SELECT id
                FROM rentals
                WHERE userID = ?
                AND propertyID = ?
                AND lease_status = 'active'
                LIMIT 1";

        $check = $conn->prepare($sql);

        if (!$check) {
            throw new Exception($conn->error);
        }

        $check->bind_param("ii", $userId, $propertyId);
        $check->execute();

        $result = $check->get_result();

        if ($result->fetch_assoc()) {
            throw new Exception("You have already booked this property.");
        }

        // -------------------------------------------------
        // CREATE BOOKING
        // -------------------------------------------------

        $sql = "INSERT INTO booking
                (
                    clientID,
                    propertyID,
                    bookingDate,
                    status
                )
                VALUES
                (
                    ?,
                    ?,
                    CURDATE(),
                    'ACCEPTED'
                )";

        $bookingStmt = $conn->prepare($sql);

        if (!$bookingStmt) {
            throw new Exception($conn->error);
        }

        $bookingStmt->bind_param(
            "ii",
            $userId,
            $propertyId
        );

        if (!$bookingStmt->execute()) {
            throw new Exception($bookingStmt->error);
        }

        // Get the newly created bookingID
        $bookingID = $conn->insert_id;

        $bookingStmt->close();

        // -------------------------------------------------
        // CREATE RENTAL
        // -------------------------------------------------

        $rent = (float)$property['rent'];

        $sql = "INSERT INTO rentals
                (
                    bookingID,
                    userID,
                    propertyID,
                    monthly_rent,
                    start_date,
                    lease_status,
                    payment_status
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    CURDATE(),
                    'active',
                    'due'
                )";

        $rentalStmt = $conn->prepare($sql);

        if (!$rentalStmt) {
            throw new Exception($conn->error);
        }

        $rentalStmt->bind_param(
            "iiid",
            $bookingID,
            $userId,
            $propertyId,
            $rent
        );

        if (!$rentalStmt->execute()) {
            throw new Exception($rentalStmt->error);
        }

        $rentalStmt->close();

        // -------------------------------------------------
        // Change property status to rented
        // -------------------------------------------------

        $sql = "UPDATE property
                SET status = 'rented'
                WHERE propertyID = ?";

        $update = $conn->prepare($sql);

        if (!$update) {
            throw new Exception($conn->error);
        }

        $update->bind_param("i", $propertyId);

        if (!$update->execute()) {
            throw new Exception($update->error);
        }

        $update->close();

        // -------------------------------------------------
        // Commit
        // -------------------------------------------------

        $conn->commit();

        return [
            'success' => true,
            'message' => 'Booking successful.',
            'bookingID' => $bookingID
        ];

    } catch (Exception $e) {

        $conn->rollback();

        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}



    // =========================================================
    // MARK PAYMENT AS PAID
    // =========================================================

public function markPaid($rentalId, $userId)
{
    $conn = $this->establishConnection();

    // 1. Get rental information
    $sql = "SELECT propertyID, monthly_rent
            FROM rentals
            WHERE id = ?
            AND userID = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare rental failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $rentalId, $userId);

    if (!$stmt->execute()) {
        die("Execute rental failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Rental not found. Rental ID = $rentalId, User ID = $userId");
    }

    $rental = $result->fetch_assoc();

    $stmt->close();


    // 2. Find booking
    $sql = "SELECT bookingID
            FROM booking
            WHERE clientID = ?
            AND propertyID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare booking failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ii",
        $userId,
        $rental['propertyID']
    );

    if (!$stmt->execute()) {
        die("Execute booking failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die(
            "Booking not found. Client ID = " .
            $userId .
            ", Property ID = " .
            $rental['propertyID']
        );
    }

    $booking = $result->fetch_assoc();

    $stmt->close();


    // 3. Update rental payment status
    $sql = "UPDATE rentals
            SET payment_status = 'paid'
            WHERE id = ?
            AND userID = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare update failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ii",
        $rentalId,
        $userId
    );

    if (!$stmt->execute()) {
        die("Update rental failed: " . $stmt->error);
    }

    $stmt->close();


    // 4. Insert payment
    $sql = "INSERT INTO payment
            (bookingID, amount, paymentDate, status)
            VALUES (?, ?, NOW(), 'paid')";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare payment failed: " . $conn->error);
    }

    $amount = (float)$rental['monthly_rent'];

    $stmt->bind_param(
        "id",
        $booking['bookingID'],
        $amount
    );

    if (!$stmt->execute()) {
        die("Insert payment failed: " . $stmt->error);
    }

    $stmt->close();

    return true;
}



    // =========================================================
    // GET ONE RENTAL FOR USER
    // =========================================================

    public function getOneByUser($rentalId, $userId)
{
    $conn = $this->establishConnection();

    $sql = "SELECT
                r.id,
                r.userID,
                r.propertyID,
                r.monthly_rent,
                r.start_date,
                r.lease_status,
                r.payment_status,
                r.created_at,
                p.Title AS title,
                p.location AS address
            FROM rentals r
            INNER JOIN property p
                ON p.propertyID = r.propertyID
            WHERE r.id = ?
            AND r.userID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $rentalId, $userId);

    $stmt->execute();

    $result = $stmt->get_result();

    $rental = $result->fetch_assoc();

    $stmt->close();

    return $rental;
}



    // =========================================================
    // CANCEL RENTAL
    // =========================================================

    public function cancelRental($rentalId, $userId)
    {
        $conn = $this->establishConnection();


        // First find the property ID
        $sql = "SELECT propertyID
                FROM rentals
                WHERE id = ?
                AND userID = ?
                AND lease_status = 'active'
                LIMIT 1";


        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            return false;
        }


        $stmt->bind_param(
            "ii",
            $rentalId,
            $userId
        );


        $stmt->execute();


        $result = $stmt->get_result();


        $rental = $result->fetch_assoc();


        $stmt->close();


        if (!$rental) {
            return false;
        }


        $propertyId = (int)$rental['propertyID'];



        // Cancel rental
        $sql = "UPDATE rentals
                SET lease_status = 'cancelled'
                WHERE id = ?
                AND userID = ?
                AND lease_status = 'active'";


        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            return false;
        }


        $stmt->bind_param(
            "ii",
            $rentalId,
            $userId
        );


        $stmt->execute();


        $cancelled = $stmt->affected_rows > 0;


        $stmt->close();



        // If cancellation succeeded, make property available again
        if ($cancelled) {

            $sql = "UPDATE property
                    SET status = 'available'
                    WHERE propertyID = ?";


            $update = $conn->prepare($sql);


            if ($update) {

                $update->bind_param(
                    "i",
                    $propertyId
                );


                $update->execute();


                $update->close();
            }
        }


        return $cancelled;
    }
}

?>