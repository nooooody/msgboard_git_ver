<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

$sql = "SELECT * FROM message WHERE id='".$_POST['msgid']."'";

$sqlRe = $conn->query($sql);
// print_r($sqlRe);

$sqlrow = $sqlRe->fetch_assoc();
// print_r($sqlrow);

unlink($sqlrow['img_path']);

$sql2 = "DELETE FROM message WHERE id='".$_POST['msgid']."'";
// echo $sql2;
$conn->query($sql2);

//===================================================================

$sql3 = "SELECT * FROM reply WHERE reply_msg_id='".$_POST['msgid']."'";

$sqlRe3 = $conn->query($sql3);
// print_r($sqlRe3);

while($sqlrow3 = $sqlRe3->fetch_assoc()){
	// print_r($sqlrow3);
	unlink($sqlrow3['img_path']);
}

$sql4 = "DELETE FROM reply WHERE reply_msg_id='".$_POST['msgid']."'";
// echo $sql4;
$conn->query($sql4);

echo json_encode("刪除成功");

?>