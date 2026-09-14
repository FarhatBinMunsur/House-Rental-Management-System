<?php

// http://localhost/House Rental Management System/api/earningsData.php

require_once __DIR__.'/../model/earningsModel.php';

if($_SERVER['REQUEST_METHOD']=='GET'){

    $earningsModel = new EarningsModel();

    $earningsData = $earningsModel->getEarningsData();

    $earningsDataJson = json_encode($earningsData);
    // var_dump($earningsDataJson);

    echo $earningsDataJson;     //returned
}

?>