<?php

require_once __DIR__ . '/../db/db.php';

class NotificationModel
{
    private $conn;

    public function establishConnection()
    {
        $db = new DBConnection();
        return $db->connect();
    }


    private function getNextID()
    {
        $conn = $this->establishConnection();

        $sql = "SELECT COALESCE(MAX(notificationID), 0) + 1 AS nextID
                FROM notification";

        $result = $conn->query($sql);

        $row = $result->fetch_assoc();

        return $row["nextID"];
    }


    public function addNotification(
        $bookingID,
        $managerID,
        $clientID,
        $message,
        $dueDate
    )
    {
        $conn = $this->establishConnection();

        $notificationID = $this->getNextID();

        $sql = "INSERT INTO notification
                (notificationID, bookingID, managerID, clientID, message, dueDate)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "iiiiss",
            $notificationID,
            $bookingID,
            $managerID,
            $clientID,
            $message,
            $dueDate
        );

        return $stmt->execute();
    }


    public function getNotifications($managerID)
    {
        $conn = $this->establishConnection();

        $sql = "SELECT
                    n.notificationID,
                    n.bookingID,
                    n.message,
                    n.dueDate,
                    n.sentDate,
                    u.userName AS clientName,
                    p.Title AS propertyTitle

                FROM notification n

                JOIN users u
                ON n.clientID = u.userID

                JOIN booking b
                ON n.bookingID = b.bookingID

                JOIN property p
                ON b.propertyID = p.propertyID

                WHERE n.managerID = ?

                ORDER BY n.notificationID DESC";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "i",
            $managerID
        );

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>