<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

// print_r($_SESSION);

$name = $_POST['p_name'];
$nick = $_POST['p_nick'];

$sql = "UPDATE member SET name = '".$name."', nick = '".$nick."' WHERE id = '".$_SESSION['id']."'";
// echo $sql;

$conn->query($sql);

$status = "999";
$msg    = "修改成功";
$data   = "";

$final_data = array(
	"status" => $status,
	"msg"    => $msg,
	"data"   => $data
);

echo json_encode($final_data);

?>