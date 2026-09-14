<?php

require_once __DIR__ . '/auth-check.php';

$propertyId = (int)($_GET['id'] ?? 0);

if (
    $propertyId > 0 &&
    isset($_SESSION['compareProperties'])
) {

    $_SESSION['compareProperties'] = array_values(
        array_filter(
            $_SESSION['compareProperties'],
            function ($id) use ($propertyId) {

                return (int)$id !== $propertyId;

            }
        )
    );
}

header("Location: compare-controller.php");

exit;

?>