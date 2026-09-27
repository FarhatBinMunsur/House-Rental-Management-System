<?php

require_once __DIR__ . '/../db/db.php';

class Property
{
    public function establishConnection()
    {
        $db = new DBconnection();
        $conn = $db->connect();
        return $conn;
    }


    public function create(
        $ownerID,
        $title,
        $propertyType,
        $status,
        $rent,
        $location,
        $bedrooms,
        $bathrooms,
        $area,
        $availabilityDate,
        $description,
        $images
    )
    {
        $sql = "INSERT INTO property
                (ownerID, Title, propertyType, status, rent, location, bedrooms, bathrooms,
                area, availabilityDate, description, images)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $conn = $this->establishConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "isssdsiiisss",
            $ownerID,
            $title,
            $propertyType,
            $status,
            $rent,
            $location,
            $bedrooms,
            $bathrooms,
            $area,
            $availabilityDate,
            $description,
            $images
        );

        return $stmt->execute();
    }


    // Calculate dashboard statistics for one owner

    public function getOwnerStats($ownerID)
    {
        $stats = [
            "totalPosts" => 0,
            "availableRents" => 0,
            "rentOngoing" => 0
        ];

        $conn = $this->establishConnection();


        // Total rental posts

        $sql1 = "SELECT COUNT(*) AS total
                 FROM property
                 WHERE ownerID = ?";

        $stmt1 = $conn->prepare($sql1);

        $stmt1->bind_param(
            "i",
            $ownerID
        );

        $stmt1->execute();

        $result1 = $stmt1->get_result();

        $row1 = $result1->fetch_assoc();

        $stats["totalPosts"] = (int)$row1["total"];


        // Available rentals

        $sql2 = "SELECT COUNT(*) AS total
                 FROM property
                 WHERE ownerID = ?
                 AND UPPER(status) = 'AVAILABLE'";

        $stmt2 = $conn->prepare($sql2);

        $stmt2->bind_param(
            "i",
            $ownerID
        );

        $stmt2->execute();

        $result2 = $stmt2->get_result();

        $row2 = $result2->fetch_assoc();

        $stats["availableRents"] = (int)$row2["total"];


        // Ongoing rentals

        $sql3 = "SELECT COUNT(*) AS total
                 FROM booking b
                 INNER JOIN property p
                 ON b.propertyID = p.propertyID
                 WHERE p.ownerID = ?
                 AND UPPER(b.status) = 'ACCEPTED'";

        $stmt3 = $conn->prepare($sql3);

        $stmt3->bind_param(
            "i",
            $ownerID
        );

        $stmt3->execute();

        $result3 = $stmt3->get_result();

        $row3 = $result3->fetch_assoc();

        $stats["rentOngoing"] = (int)$row3["total"];


        return $stats;
    }
}

?>