<?php
require("managemember.php");

$sql = "DELETE FROM member WHERE id='".$_GET['id']."'";

$conn->query($sql);

header('Location: managemember.php');
?>