<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

// echo "<pre>";print_r($_SESSION);

$sql = "SELECT * FROM member WHERE id='".$_SESSION['id']."'";

$sqlRe = $conn->query($sql);
// print_r($sqlRe);

$arr_personal = array();

if ($sqlRe->num_rows > 0) {
	$sqlrow = $sqlRe->fetch_assoc();
	// print_r($sqlrow);
	$arr_personal['name'] = $sqlrow['name'];
	$arr_personal['nick'] = $sqlrow['nick'];

	$status = "999";
	$msg    = "有該會員資料";
	$data   = $arr_personal;
} else {
	$status = "000";
	$msg    = "無該會員資料";
	$data   = "";
}

// print_r($arr_personal);

$final_data = array(
	"status" => $status,
	"msg"    => $msg,
	"data"   => $data
);

echo json_encode($final_data);

?>