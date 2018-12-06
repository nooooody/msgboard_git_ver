<?php

session_start();
//echo "<pre>";print_r($_SESSION);

// 檢査是否有登入（Session 有被設定）
if(isset($_SESSION["email"])==FALSE) {
    //如果沒有，轉址到登入頁面
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>會員中心</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
    <br><br><br><br>
    <div class="container">
        <div class="row jumbotron">
            <div class="col-md-6 col-md-offset-3"> 
                <h2 class="text-center">會員登入</h2>
                <h3>帳號(E-mail)：<?php echo $_SESSION["email"];?></h3>
                <h3>姓名(Name)：<?php echo $_SESSION["name"];?></h3>
                <h3>暱稱(Nick)：<?php echo $_SESSION["nick"];?></h3>
                <a class="btn btn-primary btn-lg btn-block" href="edit_personal.php">修改個人資料</a>
                <a class="btn btn-primary btn-lg btn-block" href="edit_password1.php">修改密碼</a>
                <a class="btn btn-primary btn-lg btn-block" href="msg.php">留言板</a>
                <a class="btn btn-default btn-lg btn-block" href="logout.php">登出</a>
            </div>
        </div>
    </div>
    </body>
</html>