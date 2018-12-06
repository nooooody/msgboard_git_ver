<?php
require("managemsg.php");

//抓取 msg.php 布好的GET表單的刪除ID
$sql = "DELETE FROM message WHERE id='".$_GET['id']."'";

$conn->query($sql);

//刪除完畢轉回留言板
header('Location: managemsg.php');
?>