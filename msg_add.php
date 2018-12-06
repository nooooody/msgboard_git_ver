<?php
require("msg.php");

date_default_timezone_set("Asia/Shanghai");

$date=date("Y-m-d H:i:s");

$_SESSION['checkword'] = $_POST['checkword'];

// echo "<pre>";print_r($_SESSION);
// echo "<pre>";print_r($_FILES);

if((!empty($_SESSION['check_word'])) && (!empty($_POST['checkword']))){
	if($_SESSION['check_word'] == $_POST['checkword']){
		if($_FILES["ImgFile"]["error"] == 0){
		    $fileName = $_FILES["ImgFile"]["name"];
		    $path = 'images/';
		    $filepath = $path.$fileName;
		    move_uploaded_file($_FILES["ImgFile"]["tmp_name"], $filepath); 
		    
		    $sql_6 = "INSERT INTO message (guest_id, content, img_path, date) VALUES ('".$_SESSION["id"]."', '".$_POST["msg"]."', '".$filepath."', '".$date."')";
		    $conn->query($sql_6);
		}else{
		    $sql_6 = "INSERT INTO message (guest_id, content, date) VALUES ('".$_SESSION["id"]."', '".$_POST["msg"]."', '".$date."')";
		    $conn->query($sql_6);
		}
	}
}

// $_SESSION['checkword'] = '';
// $_SESSION['check_word'] = '';

if(empty($_POST['pageat'])){
	header("Location: msg.php");
}else{
	header("Location: msg.php?page=".$_POST['pageat']);
}

?>