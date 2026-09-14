```php
<?php

require_once __DIR__ . '/../db/db.php';

class Notification
{
    private $conn;

    public function establishConnection()
    {
        $db = new DBConnection();

        return $db->connect();
    }

    public function getByUser($clientID)
    {
        $conn = $this->establishConnection();

        $sql = "SELECT
                    notificationID,
                    bookingID,
                    managerID,
                    clientID,
                    message,
                    dueDate,
                    sentDate
                FROM notification
                WHERE clientID = ?
                ORDER BY sentDate DESC";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $clientID);

        $stmt->execute();

        $result = $stmt->get_result();

        $notifications = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $notifications;
    }
}

?>
```
