<?php

require_once __DIR__ . '/../db/db.php';

class PropertyModel
{
    private $conn;

    public function establishConnection()
    {
        $db = new DBConnection();
        return $db->connect();
    }


    public function getDashboardCounts()
    {
        $conn = $this->establishConnection();

        $sql = "SELECT
                    COUNT(*) AS total,
                    SUM(LOWER(status) = 'accepted') AS accepted,
                    SUM(LOWER(status) = 'rejected') AS rejected,
                    SUM(LOWER(status) = 'pending') AS pending
                FROM property";

        $result = $conn->query($sql);

        $value = $result->fetch_assoc();

        $data = [
            'total' => $value['total'],
            'accepted' => $value['accepted'],
            'rejected' => $value['rejected'],
            'pending' => $value['pending']
        ];

        return $data;
    }


    public function getPosts($status)
    {
        $conn = $this->establishConnection();

        $sql = "SELECT
                    p.propertyID,
                    p.Title,
                    p.status,
                    p.rent,
                    p.location,
                    u.userName AS ownerName
                FROM property p
                JOIN users u ON p.ownerID = u.userID";

        if ($status != "all") {
            $sql .= " WHERE LOWER(p.status) = LOWER(?)";
        }

        $sql .= " ORDER BY p.propertyID DESC";

        if ($status != "all") {

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("s", $status);

            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);

        } else {

            $result = $conn->query($sql);

            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }


    public function updateStatus($propertyID, $status)
    {
        $conn = $this->establishConnection();

        $sql = "UPDATE property
                SET status = ?
                WHERE propertyID = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("si", $status, $propertyID);

        $result = $stmt->execute();

        return $result;
    }


    public function getClientProperties($clientID)
    {
        $conn = $this->establishConnection();

        $sql = "SELECT
                    b.bookingID,
                    p.propertyID,
                    p.Title,
                    p.location,
                    p.rent
                FROM booking b
                JOIN property p ON b.propertyID = p.propertyID
                WHERE b.clientID = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $clientID);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getBooking($clientID, $propertyID)
    {
        $conn = $this->establishConnection();

        $sql = "SELECT bookingID
                FROM booking
                WHERE clientID = ? AND propertyID = ?
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ii", $clientID, $propertyID);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}

?>