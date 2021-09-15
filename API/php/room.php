<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$room = $_GET["ROOM"];

$mysqli = new mysqli('badda3mon.beget.tech', 'badda3mon_hostel', 'vd%3SPTF', 'badda3mon_hostel');
$mysqli->set_charset("utf8");
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}
$myArray = array();

if ($room) {
    $result = $mysqli->query("SELECT * FROM Students WHERE ROOM=$room");
    if ($result) {
        $tempArray = array();
        while ($row = $result->fetch_object()) {
            $tempArray = $row;
            array_push($myArray, $tempArray);
        }
        echo json_encode($myArray);
    }
}

$mysqli->close();
