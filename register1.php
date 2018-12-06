<?php
ini_set("display_errors","On");
$noInfo_flag = false; //請輸入所有欄位
$duplicate_flag = false; //此 Eamil 已經註冊過
$success_flag=false; //註冊成功
$fail_flag=false; //註冊失敗

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "msgboard";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
 
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} else {
    //echo "连接成功";
}

mysqli_set_charset($conn,"utf8");

//送出鍵按出後，使用者沒有輸入資料的情況
if(isset($_POST['submit'])==true){
    //檢査所有欄位有沒有輸入
    if(empty($_POST['email'])==true || empty($_POST['password'])==true || empty($_POST['nick'])==true || empty($_POST['name'])==true){
        //有缺的話，叫使用者寫完
        $noInfo_flag = true;
    }
}

//送出鍵按出，使用者有輸入資料的情況
if(isset($_POST['submit'])==true && empty($_POST['email'])==false && empty($_POST['password'])==false && empty($_POST['name'])==false && empty($_POST['nick'])==false){
    //用 WHERE 檢查是否重複註冊
    $sql = "SELECT * FROM member WHERE email='$_POST[email]'";
    //echo $sql;
    $result = $conn->query($sql);
    //echo "<pre>";print_r($result);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row["email"]==$_POST["email"]){
                $duplicate_flag = true;
            }
        }
    } else {
        //echo "0 results";
        //沒有重複到，寫入資料
        $sql = "INSERT INTO member (name, nick, password, email) VALUES ('".$_POST["name"]."', '".$_POST["nick"]."', '".md5($_POST["password"])."', '".$_POST["email"]."')";
        //echo $sql;
        $SaveNewData = $conn->query($sql);
        
        //檢查註冊是否成功
        if(!$SaveNewData){
            $fail_flag=true;
        }else{
            $success_flag=true;
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>會員註冊</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <br><br><br><br>
        <div class="container">
            <div class="row jumbotron">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="text-center">會員註冊</h2>
                    <hr>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <div class="form-group">
                            <label for="input-name">姓名 *</label>
                            <input type="text" class="form-control" id="input-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="input-nick">匿稱 *</label>
                            <input type="text" class="form-control" id="input-nick" name="nick">
                        </div>
                        <div class="form-group">
                            <label for="input-password">密碼 *</label>
                            <input type="password" class="form-control" id="input-password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="input-email">Email *</label>
                            <input type="email" class="form-control" id="input-email" name="email">
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="註冊" name="submit">
                        <br>
                        <a class="btn btn-default btn-lg btn-block" href="login.php">登入</a>
                    </form>
                    <br>
                    <?php if($noInfo_flag){ ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            請輸入所有欄位！
                        </div>
                    <?php }?>

                    <?php if($duplicate_flag){ ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            此 Eamil 已經註冊過！
                        </div>
                    <?php }?>

                    <?php if($success_flag){ ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            註冊成功！
                        </div>
                    <?php }?>
                    <?php if($fail_flag){ ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            註冊失敗！
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </body>
</html>