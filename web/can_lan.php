<?php

$data = [
    'lan' => true,
];
$jsonData = json_encode($data);
$callback = $_GET['callback'];
header('Content-Type: application/javascript');
echo $callback . '(' . $jsonData . ');';
