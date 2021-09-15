<?php

header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$name = $_GET['NAME'];

$mysqli = new mysqli('badda3mon.beget.tech', 'badda3mon_hostel', 'vd%3SPTF', 'badda3mon_hostel');
$mysqli->set_charset("utf8");

$myArray = array();
if ($result = $mysqli->query("SELECT * FROM Students WHERE `NAME` LIKE '%" . "$name" . "%'")) {
    $tempArray = array();
    while ($row = $result->fetch_object()) {
        $tempArray = $row;
        array_push($myArray, $tempArray);
    }
    echo json_encode($myArray);
}