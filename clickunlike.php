<?php
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
    //如果按讚的會員有在會員陣列裡面，則不能按讚
    
}else{
    //如果按讚的會員有不在會員陣列裡面，則可按讚
    //並把按讚的會員加入到clickunlike_mem
    if(empty($row['clickunlike_mem'])){
        $join_clickunlike_mem = $_SESSION['id'];
    }else{
        $join_clickunlike_mem = $row['clickunlike_mem'].",".$_SESSION['id'];
    }
    
    if($result->num_rows == 0){
        //如果此留言沒有被按讚的紀錄
        $sql = "INSERT INTO thumbsup (click_msg_id, clickunlike, clickunlike_mem) VALUES ('".$_GET['id']."', '1', '".$join_clickunlike_mem."')";
        $conn->query($sql);

    }else{
        //如果此留言有被按讚的紀錄
        $like = $row['clickunlike'];
        $num = $like + 1;
        $sql = "UPDATE thumbsup SET clickunlike='".$num."', clickunlike_mem='".$join_clickunlike_mem."' WHERE click_msg_id='".$_GET['id']."'";
        $conn->query($sql);
    }
}

// echo "<pre>";print_r($_SESSION);
header('Location: managemsg.php');
?>