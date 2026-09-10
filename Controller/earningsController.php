<?php
require_once __DIR__.'/../model/earningsModel.php';

$paymentModel = new EarningsModel();

$earningsData = $paymentModel->getEarningsData();

?>