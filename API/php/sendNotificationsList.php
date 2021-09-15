<?php

header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$_POST = json_decode(file_get_contents('php://input'), true);


$mysqli = new mysqli('badda3mon.beget.tech', 'badda3mon_hostel', 'vd%3SPTF', 'badda3mon_hostel');

$id = $_POST['ID'];
$name = $_POST['NAME'];
$access = $_POST['ACCESS'];

if($id==''){
    exit();
}

if ($result = $mysqli->query("SELECT * FROM ListVkIdNotifications WHERE VKID='$id'")){
    if($result->num_rows>0){
        exit('Exists');
    }
    else{
        if($mysqli->query("INSERT INTO ListVkIdNotifications SET VKID='$id', NAME='$name', ACCESS='$access'")){
            echo 'Registered';
        }
    }
}

$mysqli->close();