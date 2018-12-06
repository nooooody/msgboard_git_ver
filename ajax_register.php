<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

if (empty($_POST['name']) && empty($_POST['nick']) && empty($_POST['password']) && empty($_POST['email'])) {
	$logindata = array(
		"error" => 111, 
		"msg"   => '*請輸入姓名、暱稱、密碼、Email'
    );
	echo json_encode($logindata);
} elseif (empty($_POST['name'])) {
	$logindata = array(
		"error" => 222, 
		"msg"   => '*請輸入姓名'
    );
	echo json_encode($logindata);
} elseif (empty($_POST['nick'])) {
	$logindata = array(
		"error" => 333, 
		"msg"   => '*請輸入暱稱'
    );
	echo json_encode($logindata);
} elseif (empty($_POST['password'])) {
	$logindata = array(
		"error" => 444, 
		"msg"   => '*請輸入密碼'
    );
	echo json_encode($logindata);
} elseif (empty($_POST['email'])) {
	$logindata = array(
		"error" => 555, 
		"msg"   => '*請輸入Email'
    );
	echo json_encode($logindata);
} elseif (!preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/", $_POST['email'])) {
	$logindata = array(
		"error" => 666, 
		"msg"   => '*Email格式不正確'
    );
	echo json_encode($logindata);
} else {
	// $sql = "INSERT INTO member (name, nick, password, email) VALUES ('".$name."', '".$nick."', '".$password."', '".$email."')";
    // $conn->query($sql);

	$stmt = $conn->prepare("INSERT INTO member (name, nick, password, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",$name, $nick, $password, $email);
	$name     = $_POST['name'];
	$nick     = $_POST['nick'];
	$password = md5($_POST['password']);
	$email    = $_POST['email'];
	$stmt->execute();
	$stmt->close();
	$conn->close();
	
	$logindata = array(
		"error" => 777, 
		"msg"   => '*註冊成功'
    );
	echo json_encode($logindata);
}

?>