<?php

require_once __DIR__ . '/../db/db.php';

class PaymentModel
{
    private $conn;

    public function establishConnection()
    {
        $db = new DBConnection();
        return $db->connect();
    }


    public function searchPayments($search)
    {
        $conn = $this->establishConnection();

        $sql = "SELECT
                    pay.paymentID,
                    pay.amount,
                    pay.paymentDate,
                    pay.status,
                    u.userName AS clientName,
                    p.Title AS propertyTitle
                FROM payment pay
                JOIN booking b ON pay.bookingID = b.bookingID
                JOIN users u ON b.clientID = u.userID
                JOIN property p ON b.propertyID = p.propertyID";

        if ($search != "") {

            $sql .= " WHERE
                        u.userName LIKE ?
                        OR p.Title LIKE ?
                        OR CAST(pay.paymentID AS CHAR) LIKE ?";
        }

        $sql .= " ORDER BY pay.paymentDate DESC";

        $stmt = $conn->prepare($sql);

        if ($search != "") {

            $value = "%" . $search . "%";

            $stmt->bind_param(
                "sss",
                $value,
                $value,
                $value
            );
        }

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getAmountByBooking($bookingID)
    {
        $conn = $this->establishConnection();

        $sql = "SELECT amount
                FROM payment
                WHERE bookingID = ?
                ORDER BY paymentDate DESC
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "i",
            $bookingID
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if ($row) {
            return $row["amount"];
        }

        return null;
    }
}

?>