﻿<?php
require("managemsg.php");

//留言被按讚的紀錄
$sql = "SELECT * FROM thumbsup WHERE click_msg_id='".$_GET['id']."'"; //GET msg的id
$result = $conn->query($sql);
//echo "<pre>";print_r($result);
$row = $result->fetch_assoc();
//echo "<pre>";print_r($row);

$clicklike_mem = $row['clicklike_mem'];
$clicklike_mem_arr = explode(",", $clicklike_mem);
// echo "<pre>";print_r($clicklike_mem_arr);

$clickunlike_mem = $row['clickunlike_mem'];
$clickunlike_mem_arr = explode(",", $clickunlike_mem);
// echo "<pre>";print_r($clickunlike_mem_arr);

if (in_array($_SESSION['id'], $clicklike_mem_arr) || in_array($_SESSION['id'], $clickunlike_mem_arr)) {
    //如果按讚的會員有在喜歡陣列或不喜歡陣列裡面，則不能按讚
   
}else{
    //如果按讚的會員有不在喜歡陣列或不喜歡陣列裡面，則可按讚
    //並把按讚的會員加入到clicklike_mem
    if(empty($row['clicklike_mem'])){
        $join_clicklike_mem = $_SESSION['id'];
    }else{
        $join_clicklike_mem = $row['clicklike_mem'].",".$_SESSION['id'];
    }
    
    if($result->num_rows == 0){
        //如果此留言沒有被按讚的紀錄
        $sql = "INSERT INTO thumbsup (click_msg_id, clicklike, clicklike_mem) VALUES ('".$_GET['id']."', '1', '".$join_clicklike_mem."')";
        $conn->query($sql);

    }else{
        //如果此留言有被按讚的紀錄
        $like = $row['clicklike'];
        $num = $like + 1;
        $sql = "UPDATE thumbsup SET clicklike='".$num."', clicklike_mem='".$join_clicklike_mem."' WHERE click_msg_id='".$_GET['id']."'";
        $conn->query($sql);
    }
}

header('Location: managemsg.php');

?>