```php
<?php

require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../Model/Notification.php';

$clientID = (int)($_SESSION['userId'] ?? 0);

if ($clientID <= 0) {
    header("Location: ../View/login.php");
    exit;
}

$notificationModel = new Notification();

$notifications = $notificationModel->getByUser($clientID);

if (!is_array($notifications)) {
    $notifications = [];
}

require_once __DIR__ . '/../View/ClientNotifications.php';

?>
```
