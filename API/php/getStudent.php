<?php
$authKey = $_GET["authKey"];
$room = $_GET["room"];
$partFullName = $_GET["partFullName"];

$mysqli = new mysqli('localhost', 'badda3mon_hostel', '71pgwTk%', 'badda3mon_hostel');

$query = "SELECT * FROM `AuthKeys` WHERE `AUTHKEY`='";
$query = $query . $authKey . "'";

$answer = "Access denied";
$privilegies = "user";
$name = "Unknown";

if ($result = $mysqli->query($query)){
	if ($row = $result->fetch_object()){
		$answer = "Access granted";
		$privilegies = $row->ACCESS;
		$name = $row->NAME;
	}
}

$students = array();

if ($room){
	if ($answer == "Access granted"){
		$query = "SELECT * FROM Students WHERE ROOM=$room";
		if ($result = $mysqli->query($query)){
			while ($row = $result->fetch_object()){
				array_push($students, $row);
			}
			echo json_encode($students);
		}
	}
} else if ($partFullName){
	if ($answer == "Access granted"){
		$query = "SELECT * FROM Students WHERE `NAME` LIKE '%" . "$partFullName" . "%'";
		if ($result = $mysqli->query($query)){
			while ($row = $result->fetch_object()){
				array_push($students, $row);
			}
			echo json_encode($students);
		}
	}
}

$result->close();
$mysqli->close();