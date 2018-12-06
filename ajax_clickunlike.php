<?php
require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

// print_r($_SESSION);

//留言被按讚的紀錄
$sql = "SELECT * FROM thumbsup WHERE click_msg_id='".$_POST['messageid']."'";
$result = $conn->query($sql);
// print_r($result);
$row = $result->fetch_assoc();
// print_r($row);

$clicklike_mem = $row['clicklike_mem'];
$clicklike_mem_arr = explode(",", $clicklike_mem);
// print_r($clicklike_mem_arr);

$clickunlike_mem = $row['clickunlike_mem'];
$clickunlike_mem_arr = explode(",", $clickunlike_mem);
// print_r($clickunlike_mem_arr);

if (in_array($_SESSION['id'], $clicklike_mem_arr) || in_array($_SESSION['id'], $clickunlike_mem_arr)) {
    //如果按讚的會員有在like陣列或unlike陣列裡面，則不能按讚
    if (in_array($_SESSION['id'], $clickunlike_mem_arr)) {
        $edit_arr = array_diff($clickunlike_mem_arr, [$_SESSION['id']]);
        // print_r($edit_arr);
        $upda_str = "";
        foreach ($edit_arr as $key => $value) {
            $upda_str .= $value.",";
            
        }
        $upda_str = substr($upda_str,0,-1);
        // echo $upda_str;

        $unlike = $row['clickunlike'];
        $num = $unlike - 1;
        $sql = "UPDATE thumbsup SET clickunlike ='".$num."', clickunlike_mem='".$upda_str."' WHERE click_msg_id='".$_POST['messageid']."'";
        // echo $sql;
        $conn->query($sql);

        $status = "111";
        $msg    = "已取消UNLIKE";
        $data   = "";
    } else {
        //如果已有按like或unlike，則改變like或unlike的資料
        if(empty($row['clickunlike_mem'])){
            $join_clickunlike_mem = $_SESSION['id'];
        }else{
            $join_clickunlike_mem = $row['clickunlike_mem'].",".$_SESSION['id'];
        }
        // echo $join_clickunlike_mem;

        $unlike = $row['clickunlike'];
        $num = $unlike + 1;
        $sql = "UPDATE thumbsup SET clickunlike='".$num."', clickunlike_mem='".$join_clickunlike_mem."' WHERE click_msg_id='".$_POST['messageid']."'";
        // echo $sql;
        $conn->query($sql);

        $edit_arr = array_diff($clicklike_mem_arr, [$_SESSION['id']]);
        // print_r($edit_arr);

        $upda_str = "";
        foreach ($edit_arr as $key => $value) {
            $upda_str .= $value.",";
            
        }
        $upda_str = substr($upda_str,0,-1);
        // echo $upda_str;

        $like = $row['clicklike'];
        $num = $like - 1;

        $sql2 = "UPDATE thumbsup SET clicklike ='".$num."', clicklike_mem='".$upda_str."' WHERE click_msg_id='".$_POST['messageid']."'";
        // echo $sql2;
        $conn->query($sql2);

        $status = "222";
        $msg    = "已修改為按UNLIKE紀錄";
        $data   = "";
    }
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
        $sql = "INSERT INTO thumbsup (click_msg_id, clickunlike, clickunlike_mem) VALUES ('".$_POST['messageid']."', '1', '".$join_clickunlike_mem."')";
        // echo $sql;
        $conn->query($sql);
    }else{
        //如果此留言有被按讚的紀錄
        $unlike = $row['clickunlike'];
        $num = $unlike + 1;
        $sql = "UPDATE thumbsup SET clickunlike='".$num."', clickunlike_mem='".$join_clickunlike_mem."' WHERE click_msg_id='".$_POST['messageid']."'";
        // echo $sql;
        $conn->query($sql);
    }
    $status = "999";
    $msg    = "按UNLIKE成功";
    $data   = "";
}

$final_data = array(
    "status" => $status,
    "msg"    => $msg,
    "data"   => $data,
);

echo json_encode($final_data);

?>