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

            $sql = "SELECT
                        propertyID,
                        rent,
                        status
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

                $conn->rollback();

                return [
                    'success' => false,
                    'message' => 'Property not found.'
                ];
            }



            // -------------------------------------------------
            // Check property availability
            // -------------------------------------------------

            if (strtolower($property['status']) !== 'accepted') {

                $conn->rollback();

                return [
                    'success' => false,
                    'message' => 'This property is no longer available.'
                ];
            }



            // -------------------------------------------------
            // Check existing booking
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


            $check->bind_param(
                "ii",
                $userId,
                $propertyId
            );


            $check->execute();


            $result = $check->get_result();


            if ($result->fetch_assoc()) {

                $conn->rollback();

                return [
                    'success' => false,
                    'message' => 'You have already booked this property.'
                ];
            }



            // -------------------------------------------------
            // Create rental
            // -------------------------------------------------

            $sql = "INSERT INTO rentals
                    (
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
                        CURDATE(),
                        'active',
                        'due'
                    )";


            $stmt = $conn->prepare($sql);


            if (!$stmt) {
                throw new Exception($conn->error);
            }


            $rent = (float)$property['rent'];


            $stmt->bind_param(
                "iid",
                $userId,
                $propertyId,
                $rent
            );


            $stmt->execute();



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


            $update->bind_param(
                "i",
                $propertyId
            );


            $update->execute();



            // Commit transaction
            $conn->commit();


            return [
                'success' => true,
                'message' => 'Booking successful.'
            ];


        } catch (Exception $e) {

            $conn->rollback();


            return [
                'success' => false,
                'message' => 'Booking failed. Please try again.'
            ];
        }
    }



    // =========================================================
    // MARK PAYMENT AS PAID
    // =========================================================

    public function markPaid($rentalId, $userId)
    {
        $conn = $this->establishConnection();


        $sql = "UPDATE rentals
                SET payment_status = 'paid'
                WHERE id = ?
                AND userID = ?
                AND payment_status <> 'paid'";


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


        $success = $stmt->affected_rows > 0;


        $stmt->close();


        return $success;
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