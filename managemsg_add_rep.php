<?php
require("managemsg.php");

date_default_timezone_set("Asia/Shanghai");

$date=date("Y-m-d H:i:s");

$_SESSION['checkword1'] = $_POST['checkword1'];

// echo "<pre>";print_r($_SESSION);
// echo "<pre>";print_r($_FILES);

if((!empty($_SESSION['check_word1'])) && (!empty($_POST['checkword1']))){
	if($_SESSION['check_word1'] == $_POST['checkword1']){
		if($_FILES["ImgFile"]["error"] == 0){
		    $fileName = $_FILES["ImgFile"]["name"];
		    $path = 'images/';
		    $filepath = $path.$fileName;
		    move_uploaded_file($_FILES["ImgFile"]["tmp_name"], $filepath); 
		    
		    $sql_6 = "INSERT INTO reply (guest_id, content, img_path, date , reply_msg_id) 
		    		  VALUES ('".$_SESSION["id"]."', '".$_POST["msg1"]."', '".$filepath."', '".$date."', '".$_POST["msg2"]."')";
		    $conn->query($sql_6);
		}else{
		    $sql_6 = "INSERT INTO reply (guest_id, content, date , reply_msg_id) 
		    		  VALUES ('".$_SESSION["id"]."', '".$_POST["msg1"]."', '".$date."', '".$_POST["msg2"]."')";
		    $conn->query($sql_6);
		}
	}
}

// $_SESSION['checkword1'] = '';
// $_SESSION['check_word1'] = '';

if(empty($_POST['pageat1'])){
	header("Location: managemsg.php");
}else{
	header("Location: managemsg.php?page=".$_POST['pageat1']);
}

?>