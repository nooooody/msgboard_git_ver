<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

// print_r($_SESSION);
// print_r($_POST);

$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];

if (empty($_POST['pass1']) && empty($_POST['pass2'])) {
	$status = "111";
	$msg    = "*請輸入兩次新密碼";
	$data   = "";
} elseif (empty($_POST['pass1'])) {
	$status = "222";
	$msg    = "*請輸入新密碼";
	$data   = "";
} elseif (empty($_POST['pass2'])) {
	$status = "333";
	$msg    = "*請再輸入一次新密碼";
	$data   = "";
} elseif ($_POST['pass1'] <> $_POST['pass2']) {
	$status = "444";
	$msg    = "*兩次密碼輸入不相符";
	$data   = "";
} else {
	$newpassword = md5($_POST['pass2']);
	$sql = "UPDATE member SET password = '".$newpassword."' WHERE id = '".$_SESSION['id']."'";
	$conn->query($sql);
	$status = "999";
	$msg    = "修改成功";
	$data   = "";
}

$final_data = array(
    "status" => $status,
    "msg"    => $msg,
    "data"   => $data,
);

echo json_encode($final_data);

?>