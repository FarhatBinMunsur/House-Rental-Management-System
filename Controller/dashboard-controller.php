<?php

require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../Model/Property2.php';


// Create Property model
$propertyModel = new Property2();


// Get search/filter values from URL
$location = trim($_GET['location'] ?? '');
$propertyType = trim($_GET['property_type'] ?? '');
$priceRange = trim($_GET['price_range'] ?? '');


// Get available properties
$properties = $propertyModel->getAvailable(
    $location,
    $propertyType,
    $priceRange
);


// Get locations for filter
$locations = $propertyModel->getLocations();


// Get property types for filter
$types = $propertyModel->getTypes();


// Load dashboard view
require_once __DIR__ . '/../View/ClientDashboard.php';

?>