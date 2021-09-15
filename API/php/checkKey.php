<?php

header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$key = $_GET['KEY'];

$mysqli = new mysqli('badda3mon.beget.tech', 'badda3mon_hostel', 'vd%3SPTF', 'badda3mon_hostel');

if ($result = $mysqli->query("SELECT * FROM `AuthKeys` WHERE AUTHKEY='$key'")){
    if($result->num_rows>0){
        echo json_encode($row = $result->fetch_object());
    }
    else{
        echo 'false';
    }
}

$mysqli->close();

