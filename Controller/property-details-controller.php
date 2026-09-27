<?php

require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../Model/Property2.php';

$propertyId = (int)($_GET['id'] ?? 0);

if ($propertyId <= 0) {
    exit('Invalid property ID.');
}

$propertyModel = new Property2();

$property = $propertyModel->getById($propertyId);

if (!$property) {
    exit('Property not found. ID = ' . $propertyId);
}

require_once __DIR__ . '/../View/ClientPropertyDetails.php';

?>