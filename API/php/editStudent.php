<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


$_POST = json_decode(file_get_contents('php://input'), true);

//Метод update или post
$method = $_POST['METHOD'];

echo $method;

$id = $_POST['ID'];
$name = $_POST['NAME'];
$phone = $_POST['PHONE_NUMBER'];
$room = $_POST['ROOM'];
$faculty = $_POST['FACULTY'];
$group = $_POST['GROUP_ID'];
$gender = $_POST['GENDER'];
$privileges = $_POST['PRIVILEGIES'];
$birth = $_POST['DATE_BIRTH'];
$educ_form = $_POST['EDUCATION_TYPE'];
$brsm = $_POST['BRSM'];
$trade_union = $_POST['TRADE_UNION'];
$works = $_POST['WORKING'];
$hobbies = $_POST['HOBBIES'];
$home_address = $_POST['HOME_ADRESS'];
$home_phone = $_POST['HOME_NUMBER'];
$father_info = $_POST['FATHER_INFO'];
$father_phone = $_POST['FATHER_NUMBER'];
$mother_info = $_POST['MOTHER_INFO'];
$mother_phone = $_POST['MOTHER_NUMBER'];
$hour_working = (int)$_POST['HOUR_WORKING']/2;
$paid_month = $_POST['PAID_MONTH'];

$mysqli = new mysqli('badda3mon.beget.tech', 'badda3mon_hostel', 'vd%3SPTF', 'badda3mon_hostel');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
    exit( );
}


if($method=='UPDATE'){
    $answer = "Access denied";
    $guard_access = "user";
    $user_name = "Unknown";

    getAccess($answer, $guard_access, $user_name);
    echo $guard_access;
    if($guard_access==='admin'){
        postLog($user_name);
        postStudent();
    }
    else{
        echo 'Недостаточно прав';
    }
}

if($method=='POST'){
    postStudent();
}

function getAccess(&$answer, &$guard_access, &$user_name){
    $authKey = $_POST["AUTH_KEY"];
    global $mysqli;
    if ($result = $mysqli->query("SELECT * FROM AuthKeys WHERE AUTHKEY='$authKey'")){
        if ($row = $result->fetch_object()){
            $answer = "Access granted";
            $guard_access = $row->ACCESS;
            $user_name = $row->NAME;
            echo $guard_access;
        }
    }
}

function postStudent(){
    global $id, $name, $phone, $room, $faculty, $group, $gender, $privileges, $birth, $home_address, $home_phone, $father_info, $father_phone, $mother_info, $mother_phone,  $educ_form, $brsm, $trade_union, $works, $hobbies, $hour_working, $paid_month;
    if ($id == 0) {
        $sql = "INSERT INTO `Students` (`ID`, `ROOM`, `NAME`, `GENDER`, `PHONE_NUMBER`, `FACULTY`, `GROUP_ID`, `PRIVILEGIES`, `DATE_BIRTH`, `HOBBIES`, `HOME_ADRESS`, `HOME_NUMBER`, `BRSM`, `TRADE_UNION`, `WORKING`, `EDUCATION_TYPE`, `MOTHER_INFO`, `MOTHER_NUMBER`, `FATHER_INFO`, `FATHER_NUMBER`, `HOUR_WORKING`, `PAID_MONTH`) VALUES (NULL, '$room', '$name', '$gender', '$phone', '$faculty', '$group', '$privileges', '$birth', '$hobbies', '$home_address', '$home_phone', '$brsm', '$trade_union', '$works', '$educ_form', '$mother_info', '$mother_phone', '$father_info', '$father_phone', '$hour_working', '$paid_month')";
    } else {
        $sql = "UPDATE Students SET NAME = '$name', PHONE_NUMBER = '$phone', ROOM = '$room', FACULTY = '$faculty', GROUP_ID = '$group', GENDER = '$gender', PRIVILEGIES = '$privileges', DATE_BIRTH = '$birth', HOME_ADRESS = '$home_address', HOME_NUMBER = '$home_phone', FATHER_INFO = '$father_info', FATHER_NUMBER = '$father_phone', MOTHER_INFO = '$mother_info', MOTHER_NUMBER = '$mother_phone', EDUCATION_TYPE = '$educ_form', BRSM = '$brsm', TRADE_UNION = '$trade_union', WORKING = '$works', HOBBIES = '$hobbies', HOUR_WORKING = '$hour_working', PAID_MONTH = '$paid_month'  WHERE ID = $id";
    }
    postDB($sql);
}

function postLog(&$user_name){
    global $mysqli, $hour_working, $paid_month, $id,$name;
    $prev_hour = '';
    $prev_paid = '';

    if($result = $mysqli->query("SELECT `HOUR_WORKING`,`PAID_MONTH` FROM Students WHERE ID=$id")){
        if($row=$result->fetch_object()){
            $prev_hour=$row->HOUR_WORKING;
            $prev_paid=$row->PAID_MONTH;
        }
    }
    if($prev_hour!=$hour_working){
        $description_hour = $_POST['DESCRIPTION_HOUR'];
        $changes = 'Изменил(-а) отработку '.$name.', было - '.($prev_hour*2).', стало - '.($hour_working*2);
        $date = date('d.m.Y H:i');
        $sql = "INSERT INTO `ChangeLog` SET NAME = '$user_name', DESCRIPTION = '$description_hour', DATE='$date', CHANGES='$changes'";
        sendNotification($user_name.' '.$changes.'. '.$description_hour);
        postDB($sql);
    }
    if($prev_paid!=$paid_month){
        $description_paid = $_POST['DESCRIPTION_PAID'];
        $difference = (int)$paid_month-(int)$prev_paid;
        $changes = 'Оплата: '.$name.' '.$difference.' месяца';
        $date = date('d.m.Y H:i');
        $sql = "INSERT INTO `ChangeLog` SET NAME = '$user_name', DESCRIPTION = '$description_paid', DATE='$date', CHANGES='$changes'";
        sendNotification($user_name.' '.$changes.'. '.$description_paid);
        postDB($sql);
    }
}

function postDB($query){
    global $mysqli;
    if ($mysqli->query($query) === TRUE) {
        echo 'POSTED';
    } else {
        echo 'ERROR: ' . $mysqli->error;
    }
}

function sendNotification($text){
    $url = 'https://cf90812.tmweb.ru/sendNotifications.php';
    $data = array('TEXT' => "$text");

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */ }

    var_dump($result);
}

$mysqli->close();