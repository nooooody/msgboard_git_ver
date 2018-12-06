<?php

ini_set("display_errors","On");
session_start();
//echo "<pre>";print_r($_SESSION);

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

//如果沒有登入的SESSION，就轉址
if (isset($_SESSION["email"])==FALSE) {
 header('Location: login.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Message Board</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    
    <script>

    </script>
    
    <style>
        table, th, td { 
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
        }
    </style>
    
    <body>
        <br><br><br><br>
        <div class="container">
            <h3 class="text-center">會員管理</h3>
            <hr>
            <table style="width:100%">
                <tr>
                    <th>id</th>
                    <th>name</th> 
                    <th>nick</th>
                    <th>email</th>
                    <th>level</th>
                    <th>EDIT-LEVEL</th>
                    <th>DEL-USER</th>
                </tr>
                <?php
                    $sql = "SELECT * FROM member";
                    //echo $sql;
                    $re = $conn->query($sql);
                    //echo "<pre>";print_r($re);
                    
                    $i=1;
                    
                    if($re->num_rows > 0){
                         while($row = $re->fetch_assoc()){
                             //echo "<pre>";print_r($row);
                             echo "<tr>
                                      <td>".$i."</td>
                                      <td>".$row['name']."</td>
                                      <td>".$row['nick']."</td>
                                      <td>".$row['email']."</td>
                                      <td>".$row['level']."</td>
                                      <td><a href=\"mem_edit.php?id=".$row['id']."&level=".$row['level']."\" class=\"btn btn-success btn-xs\">EDIT</a></td>
                                      <td><a href=\"mem_del.php?id=".$row['id']."\" class=\"btn btn-danger btn-xs\">DELETE</a></td>                              
                                  </tr>";
                             $i++;
                         }
                    }
                ?>
            </table>
            <br>
            <a class="btn btn-primary btn-lg btn-block" href="manager.php">管理者首頁</a>
            <br>
        </div>
        
    </body>
</html>