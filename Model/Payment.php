<?php

class Payment
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getSummary($ownerID)
    {
        $summary = [
            "totalRevenue" => 0,
            "thisMonth" => 0,
            "activeTenants" => 0
        ];

// total received revenue calculate

        $sql1 = "SELECT COALESCE(SUM(pay.amount), 0) AS total
                 FROM payment pay
                 INNER JOIN booking b ON pay.bookingID = b.bookingID
                 INNER JOIN property p ON b.propertyID = p.propertyID
                 WHERE p.ownerID = ?
                 AND UPPER(pay.status) = 'RECEIVED'";

        $stmt1 = mysqli_prepare($this->conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $ownerID);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $summary["totalRevenue"] = (float)mysqli_fetch_assoc($result1)["total"];


// Current month er total received revenue calculate 

        $sql2 = "SELECT COALESCE(SUM(pay.amount), 0) AS total
                 FROM payment pay
                 INNER JOIN booking b ON pay.bookingID = b.bookingID
                 INNER JOIN property p ON b.propertyID = p.propertyID
                 WHERE p.ownerID = ?
                 AND UPPER(pay.status) = 'RECEIVED'
                 AND YEAR(pay.paymentDate) = YEAR(CURDATE())
                 AND MONTH(pay.paymentDate) = MONTH(CURDATE())";

        $stmt2 = mysqli_prepare($this->conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $ownerID);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $summary["thisMonth"] = (float)mysqli_fetch_assoc($result2)["total"];

// tenant or client er total number count 

        $sql3 = "SELECT COUNT(DISTINCT b.clientID) AS total
                 FROM booking b
                 INNER JOIN property p ON b.propertyID = p.propertyID
                 WHERE p.ownerID = ?
                 AND UPPER(b.status) = 'ACCEPTED'";

        $stmt3 = mysqli_prepare($this->conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $ownerID);
        mysqli_stmt_execute($stmt3);
        $result3 = mysqli_stmt_get_result($stmt3);
        $summary["activeTenants"] = (int)mysqli_fetch_assoc($result3)["total"];

        return $summary;
    }

    public function getOwnerPayments($ownerID)
    {
        $sql = "SELECT
                    p.Title AS propertyTitle,
                    u.userName AS tenantName,
                    pay.amount,
                    pay.paymentDate,
                    pay.status
                FROM payment pay
                INNER JOIN booking b ON pay.bookingID = b.bookingID
                INNER JOIN property p ON b.propertyID = p.propertyID
                INNER JOIN users u ON b.clientID = u.userID
                WHERE p.ownerID = ?
                ORDER BY pay.paymentDate DESC";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $ownerID);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }
}
?>
