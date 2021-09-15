<?php

header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


$mysqli = new mysqli('badda3mon.beget.tech', 'badda3mon_hostel', 'vd%3SPTF', 'badda3mon_hostel');

$notifications = array();

if ($result = $mysqli->query("SELECT * FROM ChangeLog ORDER BY ID DESC LIMIT 50")){
    if($result->num_rows>0){
        while ($row = $result->fetch_object()){
            array_push($notifications, $row);
        }
        echo json_encode($notifications);
    }
    else{
        echo 'false';
    }
}

$mysqli->close();