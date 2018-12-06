<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

date_default_timezone_set("Asia/Shanghai");

// print_r($_SESSION);
// print_r($_FILES);

$date = date("Y-m-d H:i:s");

$date1 = strtotime($date);

$_SESSION['checkword'] = $_POST['msg_check'];

$n = $_SESSION["name"].$date1.chr(rand(65,90)).rand((int)100,(int)999);

$htmlcode = htmlentities($_POST["msg_cont"]);

if (empty($_POST['msg_cont'])) {
	$status = "111";
	$msg    = "*請輸入內文";
	$data   = "";
} elseif (empty($_POST['msg_check'])) {
	$status = "222";
	$msg    = "*請輸入驗證碼";
	$data   = "";
} elseif ($_SESSION['check_word'] <> $_SESSION['checkword']) {
	$status = "333";
	$msg    = "*驗證碼錯誤";
	$data   = "";
} else {
	if($_FILES["msg_img"]["error"] == 0){

	    // $fileName = $_FILES["msg_img"]["name"];
	    // $path = 'images/';
	    // $filepath = $path.$fileName;
	    // move_uploaded_file($_FILES["msg_img"]["tmp_name"], $filepath);

	    $cutfilesname = explode(".",$_FILES["msg_img"]["name"]);
	    $fileName = $n.".".$cutfilesname['1'];
	    $path = 'images/';
	    $filepath = $path.$fileName;
	    move_uploaded_file($_FILES["msg_img"]["tmp_name"], $filepath);
	    

	    $stmt = $conn->prepare("INSERT INTO message (guest_id, content_data, img_path, date) VALUES (?, ?, ?, ?)");
	    $stmt->bind_param("ssss",$guest_id, $content_data, $img_path, $date);
	    $guest_id = $_SESSION["id"];
		$content_data = $htmlcode;
		$img_path = $filepath;
		$date = $date;
		$stmt->execute();
		$stmt->close();
		$conn->close();

	}else{
		$stmt = $conn->prepare("INSERT INTO message (guest_id, content_data, date) VALUES (?, ?, ?)");
	    $stmt->bind_param("sss",$guest_id, $content_data, $date);
	    $guest_id = $_SESSION["id"];
		$content_data = $htmlcode;
		$date = $date;
		$stmt->execute();
		$stmt->close();
		$conn->close();
		
	}

	$status = "999";
	$msg    = "留言成功";
	$data   = "";
}

$final_data = array(
	"status" => $status,
	"msg"    => $msg,
	"data"   => $data
);

// print_r($final_data);

echo json_encode($final_data);

?>