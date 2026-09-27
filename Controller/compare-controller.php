<?php

require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../Model/Property2.php';

$propertyModel = new Property2();

$propertyId = (int)($_GET['id'] ?? 0);

if ($propertyId <= 0) {
    header("Location: ../Controller/dashboard-controller.php");
    exit;
}

if (!isset($_SESSION['compareProperties'])) {
    $_SESSION['compareProperties'] = [];
}

if (!in_array($propertyId, $_SESSION['compareProperties'])) {
    $_SESSION['compareProperties'][] = $propertyId;
}

$compareIds = $_SESSION['compareProperties'];

$compareProperties = [];

foreach ($compareIds as $id) {

    $property = $propertyModel->getById((int)$id);

    if ($property) {
        $compareProperties[] = $property;
    }
}

require_once __DIR__ . '/../View/ClientCompare.php';

?>