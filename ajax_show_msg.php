<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

// print_r($_SESSION);
// print_r($_FILES);

$sql_5 = "SELECT * FROM `message`";
$messageallRe = $conn->query($sql_5);
// print_r($messageallRe);

$per_page      = 3;
$total_records = $messageallRe->num_rows;
$total_page    = ceil($total_records/$per_page);

$getpage = (int)$_GET['page'];

if ($getpage >= 1 && $getpage <= $total_page) {
    $p = $getpage;
}elseif ($getpage > $total_page) {
    $p = $total_page;
}elseif ($getpage < 1) {
    $p = 1;
} else {
    $p = 1;
}

$start_page = ($p-1) * $per_page;

$page_data = array(
    "per_page"      => $per_page,     
    "total_records" => $total_records,
    "start_page"    => $start_page,   
    "total_page"    => $total_page,
    "current_page"  => $p
);

// print_r($page_data);

$sql = "SELECT * FROM `message` ORDER BY `id` DESC LIMIT ".$start_page.", ".$per_page."";
// echo $sql;

$messageRe = $conn->query($sql);
// print_r($messageRe);

// 檢査message table有沒有留言數，如果有留言，一筆一筆印出留言
if ($messageRe->num_rows > 0) {
	while ($messageRow = $messageRe->fetch_assoc()) {
		// print_r($messageRow);
		// 依照message table的guest_id找出該筆留言的留言會員是哪位
	    $sql_1 = "SELECT * FROM member WHERE id='".$messageRow['guest_id']."'";
	    $memberRe = $conn->query($sql_1);
	    $memberRow=$memberRe->fetch_assoc();
	    // print_r($memberRow);
	    $messageRow['name'] = $memberRow['name'];

	    // 依照message table的id找出該筆留言按like和按unlike的狀況
        $sql_2 = "SELECT * FROM thumbsup WHERE click_msg_id='".$messageRow['id']."'";
        $thumbsupRe = $conn->query($sql_2);
        $thumbsupRow = $thumbsupRe->fetch_assoc();
        // print_r($thumbsupRow);

        if($thumbsupRow['clicklike']){
            $messageRow['cl'] = $thumbsupRow['clicklike'];
            
        }else{
            $messageRow['cl'] = 0;
        }
        
        if($thumbsupRow['clickunlike']){
            $messageRow['cul'] = $thumbsupRow['clickunlike'];
            
        }else{
            $messageRow['cul'] = 0;
        }

        // 查詢此登入會員對每則留言的like和unlike點擊狀況
        $clicklike_mem = $thumbsupRow['clicklike_mem'];
        $clicklike_mem_arr = explode(",", $clicklike_mem);
        // print_r($clicklike_mem_arr);

        $clickunlike_mem = $thumbsupRow['clickunlike_mem'];
        $clickunlike_mem_arr = explode(",", $clickunlike_mem);
        // print_r($clickunlike_mem_arr);

        if (in_array($_SESSION['id'], $clicklike_mem_arr)) {
            $messageRow['input_like'] = 1;
        } else {
            $messageRow['input_like'] = 0;
        }

        if (in_array($_SESSION['id'], $clickunlike_mem_arr)) {
            $messageRow['input_unlike'] = 1;
        } else {
            $messageRow['input_unlike'] = 0;
        }

        // 根據該筆留言id找出回覆的留言
        $sql_3 = "SELECT * FROM reply WHERE reply_msg_id='".$messageRow['id']."'";
        $replyRe = $conn->query($sql_3);
        // print_r($replyRe);

        if($replyRe->num_rows > 0){
            while($replyRow = $replyRe->fetch_assoc()){
            	// print_r($replyRow);
            	$sql_4 = "SELECT * FROM member WHERE id='".$replyRow['guest_id']."'";
                $repmemRe = $conn->query($sql_4);
                $repmemRow = $repmemRe->fetch_assoc();
                // print_r($repmemRow);
                $replyRow['name'] = $repmemRow['name'];
				$messageRow['reply'][] = $replyRow;
            }
        }
        $arr_message[] = $messageRow;
	}
	// print_r($arr_message);

	$status = "555";
	$msg    = "目前有留言";
	$data   = $arr_message;
	
} else {
	$status = "666";
	$msg    = "目前沒有留言";
	$data   = "";
}

$final_data = array(
	"status" => $status,
	"msg"    => $msg,
	"data"   => $data,
	"sess"	 => $_SESSION,
    "page"   => $page_data
);

// print_r($final_data);

echo json_encode($final_data);

?>