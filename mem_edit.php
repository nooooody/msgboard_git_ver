<?php

require("managemember.php");

if($_GET['level'] == 1){
    $sql = "UPDATE member SET level=2 WHERE id='".$_GET['id']."'";
}else{
    $sql = "UPDATE member SET level=1 WHERE id='".$_GET['id']."'";
}

//echo $sql;

$conn->query($sql);

header('Location: managemember.php');
?>