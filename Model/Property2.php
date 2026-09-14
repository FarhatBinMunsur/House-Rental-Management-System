<?php

require_once __DIR__ . '/../db/db.php';


class Property2
{
    private $conn;


    // Establish database connection
    public function establishConnection()
    {
        $db = new DBConnection();

        return $db->connect();
    }


    // Get available properties with filters
    public function getAvailable($location = '', $type = '', $priceRange = '')
    {
        $conn = $this->establishConnection();


        $sql = "SELECT
                    propertyID,
                    Title,
                    location,
                    bedrooms,
                    bathrooms,
                    rent,
                    images
                FROM property
                WHERE status = 'accepted'";


        // Location filter
        if ($location !== '') {
            $sql .= " AND location LIKE ?";
        }


        // Property type filter
        if ($type !== '') {
            $sql .= " AND propertyType = ?";
        }


        // Price filter
        if ($priceRange === 'under_2000') {
            $sql .= " AND rent < 2000";
        }


        if ($priceRange === '2000_3000') {
            $sql .= " AND rent BETWEEN 2000 AND 3000";
        }


        if ($priceRange === 'over_3000') {
            $sql .= " AND rent > 3000";
        }


        // Newest properties first
        $sql .= " ORDER BY propertyID DESC";


        // Prepare statement
        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }


        // Prepare parameters
        $bindTypes = "";
        $values = [];


        if ($location !== '') {

            $bindTypes .= "s";

            $values[] = "%" . $location . "%";
        }


        if ($type !== '') {

            $bindTypes .= "s";

            $values[] = $type;
        }


        // Bind parameters if required
        if (!empty($values)) {

            $stmt->bind_param($bindTypes, ...$values);
        }


        // Execute query
        $stmt->execute();


        // Get result
        $result = $stmt->get_result();


        // Convert result to array
        $properties = $result->fetch_all(MYSQLI_ASSOC);


        // Close statement
        $stmt->close();


        return $properties;
    }



    // Get all available locations
    public function getLocations()
    {
        $conn = $this->establishConnection();


        $sql = "SELECT DISTINCT location
                FROM property
                WHERE status = 'available'
                ORDER BY location";


        $result = $conn->query($sql);


        $locations = [];


        if ($result) {

            while ($row = $result->fetch_assoc()) {

                $locations[] = $row['location'];
            }
        }


        return $locations;
    }



    // Get all available property types
    public function getTypes()
    {
        $conn = $this->establishConnection();


        $sql = "SELECT DISTINCT propertyType
                FROM property
                WHERE status = 'available'
                ORDER BY propertyType";


        $result = $conn->query($sql);


        $types = [];


        if ($result) {

            while ($row = $result->fetch_assoc()) {

                $types[] = $row['propertyType'];
            }
        }


        return $types;
    }



    // Get one property by ID
    public function getById($id)
    {
        $conn = $this->establishConnection();


        $sql = "SELECT
                    p.*,
                    u.userName AS owner_name,
                    u.userEmail AS owner_email,
                    u.phone AS owner_phone
                FROM property p
                LEFT JOIN users u
                    ON u.userID = p.ownerID
                WHERE p.propertyID = ?";


        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }


        $stmt->bind_param("i", $id);


        $stmt->execute();


        $result = $stmt->get_result();


        $property = $result->fetch_assoc();


        $stmt->close();


        return $property;
    }



    // Get available properties except one property
    public function getAvailableExcept($id)
    {
        $conn = $this->establishConnection();


        $sql = "SELECT
                    propertyID,
                    ownerID,
                    Title,
                    propertyType,
                    status,
                    rent,
                    location,
                    bedrooms,
                    bathrooms,
                    area,
                    availabilityDate,
                    description,
                    images
                FROM property
                WHERE status = 'available'
                AND propertyID <> ?
                ORDER BY propertyID DESC";


        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }


        $stmt->bind_param("i", $id);


        $stmt->execute();


        $result = $stmt->get_result();


        $properties = $result->fetch_all(MYSQLI_ASSOC);


        $stmt->close();


        return $properties;
    }
}

?>