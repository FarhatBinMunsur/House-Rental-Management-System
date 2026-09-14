<?php

require_once __DIR__ . '/../db/db.php';

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE userEmail = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function updatePassword($email, $password)
    {
        $sql = "UPDATE users SET userPassword = ? WHERE userEmail = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $password, $email);

        return $stmt->execute();
    }

    public function getClients()
    {
        $sql = "SELECT userID, userName, userEmail
                FROM users
                WHERE userRole = 'CLIENT'
                ORDER BY userName";

        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
