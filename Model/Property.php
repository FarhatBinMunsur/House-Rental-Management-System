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

// owner create rental post ..........

    public function create($ownerID, $title,$propertyType,$status,$rent,$location,
    $bedrooms,$bathrooms,$area,$availabilityDate,$description,$images)
    
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


    public function getOwnerStats($ownerID)
    {
        $stats = [
            "totalPosts" => 0,
            "availableRents" => 0,
            "rentOngoing" => 0
        ];

        $conn = $this->establishConnection();


// total rental posts

        $sql1 = "SELECT COUNT(*) AS total
                 FROM property
                 WHERE ownerID = ?";

        $stmt1 = $conn->prepare($sql1);

<<<<<<< HEAD
        $stmt1->bind_param(
            "i",
            $ownerID
        );
=======
        $stmt1->bind_param("i",$ownerID);
>>>>>>> addf976 (Final updated owner)

        $stmt1->execute();

        $result1 = $stmt1->get_result();

        $row1 = $result1->fetch_assoc();

        $stats["totalPosts"] = (int)$row1["total"];


// count available rentals

        $sql2 = "SELECT COUNT(*) AS total
                 FROM property
                 WHERE ownerID = ?
                 AND UPPER(status) = 'AVAILABLE'";

        $stmt2 = $conn->prepare($sql2);

<<<<<<< HEAD
        $stmt2->bind_param(
            "i",
            $ownerID
        );
=======
        $stmt2->bind_param("i",$ownerID);
>>>>>>> addf976 (Final updated owner)

        $stmt2->execute();

        $result2 = $stmt2->get_result();

        $row2 = $result2->fetch_assoc();

        $stats["availableRents"] = (int)$row2["total"];


// count ongoing rentals

        $sql3 = "SELECT COUNT(*) AS total
                 FROM booking b
                 INNER JOIN property p
                 ON b.propertyID = p.propertyID
                 WHERE p.ownerID = ?
                 AND UPPER(b.status) = 'ACCEPTED'";

        $stmt3 = $conn->prepare($sql3);

<<<<<<< HEAD
        $stmt3->bind_param(
            "i",
            $ownerID
        );
=======
        $stmt3->bind_param("i",$ownerID);
>>>>>>> addf976 (Final updated owner)

        $stmt3->execute();

        $result3 = $stmt3->get_result();

        $row3 = $result3->fetch_assoc();

        $stats["rentOngoing"] = (int)$row3["total"];

<<<<<<< HEAD

=======
>>>>>>> addf976 (Final updated owner)
        return $stats;
    }
}

?>