<?php
//Session_start();
//if( $_SESSION["Checknum"] == $_POST['checknum'] ){
// $msg = "您所輸入的驗證碼正確！";
//}else{
// $msg = "您所輸入的驗證碼錯誤！請回上一頁重新輸入。 ";
//}
//echo $msg;

if(!isset($_SESSION)){
    session_start();
}

// print_r($_SESSION);

//判斷此兩個變數是否為空
if((!empty($_SESSION['check_word'])) && (!empty($_POST['checkword']))){
    if($_SESSION['check_word'] == $_POST['checkword']){
        $_SESSION['check_word'] = ''; //比對正確後，清空將check_word值
        header('content-Type: text/html; charset=utf-8');
        echo '<p> </p><p> </p><a href="test_form.php">Success-輸入正確，將於一秒後跳轉(按此也可返回)</a>';
        echo '<meta http-equiv="refresh" content="1; url=test_form.php">';
        exit();
    }else{
        echo '<p> </p><p> </p><a href="test_form.php">Error-輸入錯誤，將於一秒後跳轉(按此也可返回)</a>';
        echo '<meta http-equiv="refresh" content="1; url=test_form.php">';
    }

}
?>