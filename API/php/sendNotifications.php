<?php

header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

//$_POST = json_decode(file_get_contents('php://input'), true);

$mysqli = new mysqli('badda3mon.beget.tech', 'badda3mon_hostel', 'vd%3SPTF', 'badda3mon_hostel');

$id_array = array();
if($result=$mysqli->query("SELECT * FROM `ListVkIdNotifications`")){
    if($result->num_rows>0){
        while ($row = $result->fetch_object()){
            array_push($id_array, $row->VKID);
        }
    }
}
$text = $_POST['TEXT'];
echo 'text '.$text;

sendVkMessage($id_array,$text);

function sendVkMessage($id_array,$text){
    foreach ($id_array as $id){
        $request_params = array(
            'message'=>$text,
            'peer_id'=>$id,
            'access_token'=>"e34bfc529a0d17e55292121fd2103189d29fae3c2ef9a1d2a3ce1bec4330cbe16fe33e59144a336e6b34c",
            'v'=>'5.87'
        );
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
    }
}
