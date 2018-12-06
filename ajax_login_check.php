<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

if (empty($_POST['email']) && empty($_POST['email'])) {
	$logindata = array(
		"error" => 5, 
		"msg"   => '請輸入Email和密碼'
    );
	echo json_encode($logindata);
} elseif (empty($_POST['email'])) {
	$logindata = array(
		"error" => 6, 
		"msg"   => '請輸入Email'
    );
	echo json_encode($logindata);
} elseif (empty($_POST['pass'])) {
	$logindata = array(
		"error" => 7, 
		"msg"   => '請輸入密碼'
    );
	echo json_encode($logindata);
} else {
	$email    = $_POST['email'];
	$password = md5($_POST['pass']);
	$sql      = "SELECT * FROM member WHERE email = '".$_POST['email']."'";
	$result   = $conn->query($sql);
	$sql1     = "SELECT * FROM member WHERE email = '".$_POST['email']."' AND password = '".$password."'";
	$result1  = $conn->query($sql1);

	if ($result->num_rows > 0) {
		if ($result1->num_rows > 0) {
			$row = $result->fetch_assoc();
			// print_r($row);
			$_SESSION["id"]       =$row["id"];
		    $_SESSION["name"]     =$row["name"];
		    $_SESSION["nick"]     =$row["nick"];
		    $_SESSION["password"] =md5($_POST["pass"]);
		    $_SESSION["email"]    =$_POST["email"];
		    $_SESSION["level"]    =$row["level"];

		    $logindata = array(
				"level" => $row["level"], 
				"error" => 0, 
				"msg"   => '登入成功'
		    );
			echo json_encode($logindata);
		} else {
			$logindata = array(
			"error" => 8, 
			"msg"   => '密碼錯誤'
		    );
			echo json_encode($logindata);
		}
	} else {
		$logindata = array(
			"error" => 9, 
			"msg"   => '帳戶不存在'
	    );
		echo json_encode($logindata);
	}
}

?>