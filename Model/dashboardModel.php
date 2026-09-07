<?php
require_once '../db/db.php';

class DashboardModel
{
    private $conn;

    public function establishConnection()
    {
        $db = new DBConnection();
        return $db->connect();
    }


    public function getTotalClients()
    {
        $conn = $this->establishConnection();
        $sql = "SELECT COUNT(*) AS total FROM users where userRole='client'";
        $result = $conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getTotalManagers()
    {
        $conn = $this->establishConnection();
        $sql = "SELECT COUNT(*) AS total FROM users where userRole='manager'";
        $result = $conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getTotalOwners()
    {
        $conn = $this->establishConnection();
        $sql = "SELECT COUNT(*) AS total FROM users where userRole='owner'";
        $result = $conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getTotalProperties()
    {
        $conn = $this->establishConnection();
        $sql = "SELECT COUNT(*) AS total FROM property";
        $result = $conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getAvailableProperties()
    {
        $conn = $this->establishConnection();
        $sql = "SELECT COUNT(*) AS total FROM property WHERE status = 'available'";
        $result = $conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getRentedProperties()
    {
        $conn = $this->establishConnection();
        $sql = "SELECT COUNT(*) AS total FROM property WHERE status = 'rented'";
        $result = $conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getDashboardData()
    {
         $data=[
            'totalClients' => $this->getTotalClients(),
            'totalManagers' => $this->getTotalManagers(),
            'totalOwners' => $this->getTotalOwners(),
            'totalProperties' => $this->getTotalProperties(),
            'availableProperties' => $this->getAvailableProperties(),
            'rentedProperties' => $this->getRentedProperties(),
        ];
        return $data;
    }
}