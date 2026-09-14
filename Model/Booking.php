<?php

require_once __DIR__ . '/../db/db.php';

class Booking
{
    public function establishConnection()
    {
        $db = new DBconnection();
        $conn = $db->connect();
        return $conn;
    }


    public function getOwnerBookings($ownerID)
    {
        $sql = "SELECT b.bookingID, b.bookingDate, b.status,
                       u.userName AS clientName,
                       p.Title AS propertyTitle
                FROM booking b
                INNER JOIN property p
                    ON b.propertyID = p.propertyID
                INNER JOIN users u
                    ON b.clientID = u.userID
                WHERE p.ownerID = ?
                ORDER BY b.bookingDate DESC";

        $conn = $this->establishConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ownerID);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateStatus($bookingID, $ownerID, $status)
    {
        $sql = "UPDATE booking b
                INNER JOIN property p
                    ON b.propertyID = p.propertyID
                SET b.status = ?
                WHERE b.bookingID = ? AND p.ownerID = ?";

        $conn = $this->establishConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $status, $bookingID, $ownerID);
        if (!$stmt->execute()) {
            return false;
        }

        return $stmt->affected_rows > 0;
    }
}

?>