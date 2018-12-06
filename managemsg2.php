<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

if (isset($_SESSION["email"])==FALSE) {
 header('Location: login.php');
}

// echo "<pre>";print_r($_SESSION);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Message Board</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    
    <script>
        $(document).ready(function(){
            //$("#button").click(function(){
            //    if($("#msg").val()==""){
            //        alert("尚未填寫內文");   
            //    }else{
            //        document.form.submit();
            //    }
            //});
            
            // $("#button1").click(function(){
            //     if($("#msg1").val()==""){
            //         alert("尚未填寫內文");   
            //     }else{
            //         document.form1.submit();
            //         $('#myModal').modal('hide');
            //     }
            // });

            $('div[data-id]').each(function(){
                var likesign = $(this).find('.likesign').val();
                var unlikesign = $(this).find('.unlikesign').val();
                if (likesign == 1) {
                    $(this).find('.likesign1').addClass('changelikecolor');
                }
                if (unlikesign == 1) {
                    $(this).find('.unlikesign1').addClass('changeunlikecolor');
                }
            });
           
            $(".reply").click(function(){
                var text = $(this).next('a').next('input').val();
                $("#msg2").val(text);
            });

            $('a[data-pageid="'+$("#pageat").val()+'"]').addClass('pagebutton');

        })

        function refresh_code(){ 
            document.getElementById("imgcode").src="test_code.php"; 
        }

        function refresh_code1(){ 
            document.getElementById("imgcode").src="test_code1.php";
        }

    </script>
    
    <style>
        .change { white-space: pre; }
        .reply { }
        .Separationline { border-top: 1px solid #eee; }
        .bgcolor { background-color: #DDDDDD; width: 100%; }
        .changelikecolor { background-color: #ffc107; }
        .changeunlikecolor { background-color: #17a2b8; }
        .pagination>li>a.pagebutton { background-color: #CCEEFF; }
    </style>
    
    <body>
        <br><br><br><br>
        <div class="container">
            <h3 class="text-center">留言板管理</h3>
            <hr>
            <?php
                $num_per_page=5;
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
                $start_from = ($page-1) * $num_per_page; 

                $sql = "SELECT * FROM message LIMIT ".$start_from.", ".$num_per_page."";
                $messageRe = $conn->query($sql);
                // echo "<pre>";print_r($messageRe);
                              
                //檢査有沒有留言數（ message 資料表的資料筆數是否大於0）
                if($messageRe->num_rows > 0){
                    //如果有留言，一筆一筆印出留言
                    while($row = $messageRe->fetch_assoc()){
                        //找出該筆留言的留言會員是哪位
                        $sql_1 = "SELECT * FROM member WHERE id='".$row['guest_id']."'";
                        $memberRe = $conn->query($sql_1);
                        $memberRow=$memberRe->fetch_assoc();
                        // echo "<pre>";print_r($memberRow);
                        
                        //找出該筆留言按like和按unlike的狀況
                        $sql_2 = "SELECT * FROM thumbsup WHERE click_msg_id='".$row['id']."'";
                        $thumbsupRe = $conn->query($sql_2);
                        $thumbsupRow = $thumbsupRe->fetch_assoc();
                        // echo "<pre>";print_r($thumbsupRow);

                        if($thumbsupRow['clicklike']){
                            $cl = $thumbsupRow['clicklike'];
                            
                        }else{
                            $cl = 0;
                        }
                        
                        if($thumbsupRow['clickunlike']){
                            $cul = $thumbsupRow['clickunlike'];
                            
                        }else{
                            $cul = 0;
                        }

                        //查看該登入會員對每則留言的like和unlike點擊狀況
                        $clicklike_mem = $thumbsupRow['clicklike_mem'];
                        $clicklike_mem_arr = explode(",", $clicklike_mem);
                        // echo "<pre>";print_r($clicklike_mem_arr);

                        $clickunlike_mem = $thumbsupRow['clickunlike_mem'];
                        $clickunlike_mem_arr = explode(",", $clickunlike_mem);
                        // echo "<pre>";print_r($clickunlike_mem_arr);

                        if (in_array($_SESSION['id'], $clicklike_mem_arr)) {
                            $input_like = 1;
                        } else {
                            $input_like = 0;
                        }

                        if (in_array($_SESSION['id'], $clickunlike_mem_arr)) {
                            $input_unlike = 1;
                        } else {
                            $input_unlike = 0;
                        }
                        
                        echo "<div class=\"panel panel-default\" data-id=".$row['id'].">";
                        echo "<div class=\"panel-heading\">".$memberRow['name'];
                        echo "<span class=\"pull-right\">".$row['date'];

                        echo "<input type=\"hidden\" id=\"inid1\" class=\"likesign\" value=".$input_like.">";
                        echo " <a href=\"clicklike.php?id=".$row['id']."\" class=\"btn btn-default btn-xs likesign1\">LIKE</a> ".$cl;
                        
                        echo "<input type=\"hidden\" id=\"inid2\" class=\"unlikesign\" value=".$input_unlike.">";
                        echo " <a href=\"clickunlike.php?id=".$row['id']."\" class=\"btn btn-default btn-xs unlikesign1\">UNLIKE</a> ".$cul;
                        
                        echo " <button id=\"reply\" class=\"btn btn-success btn-xs reply\" data-toggle=\"modal\" data-target=\"#myModal\">REPLY</button>";
                        echo " <a href=\"managemsg_del.php?id=".$row['id']."\" class=\"btn btn-danger btn-xs\">DELETE</a>";
                        echo "<input type=\"hidden\" id=\"inid3\" value=".$row['id'].">";
                        echo "</span>";
                        echo "</div>";

                        if ($row['img_path']) {
                            echo "<div class=\"panel-body change \"><div><img src=".$row['img_path']."></div><div>".$row['content']."</div></div>";
                        } else {
                            echo "<div class=\"panel-body change \">".$row['content']."</div>";
                        }

                        //根據該筆留言id找出回覆的留言
                        $sql_3 = "SELECT * FROM reply WHERE reply_msg_id='".$row['id']."'";
                        $replyRe = $conn->query($sql_3);
                        // echo "<pre>";print_r($replyRe);

                        if($replyRe->num_rows > 0){
                            echo "<table class=\"bgcolor\">";
                            while($replyRow = $replyRe->fetch_assoc()){
                                // echo "<pre>";print_r($replyRow);
                                $sql_4 = "SELECT * FROM member WHERE id='".$replyRow['guest_id']."'";
                                $repmemRe = $conn->query($sql_4);
                                $repmemRow=$repmemRe->fetch_assoc();
                                // echo "<pre>";print_r($repmemRow);

                                echo "<tr style=\"border-top:1px #AAAAAA solid;\">";
                                echo "<td style=\"vertical-align:text-top;\" width=\"1%\"></td>";
                                echo "<td style=\"vertical-align:text-top;\" width=\"5%\">".$repmemRow['name']."</td>";
                                echo "<td style=\"vertical-align:text-top;\" width=\"5%\">回覆>>></td>";
                                if ($replyRow['img_path']) {
                                    echo "<td width=\"77%\">";
                                    echo "<img src=".$replyRow['img_path'].">";
                                    echo "<p>".$replyRow['content']."</p>";
                                    echo "</td>";
                                } else {
                                    echo "<td width=\"77%\">".$replyRow['content']."</td>";
                                }
                                echo "<td style=\"vertical-align:text-top;\" width=\"12%\">".$replyRow['date']."</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } 
                        echo "</div>";                       
                    }

                    $sql_5 = "SELECT * FROM message";
                    $allmsgRe = $conn->query($sql_5);
                    $total_records=$allmsgRe->num_rows;
                    $total_pages = ceil($total_records / $num_per_page);
                    echo "<ul class=\"pagination\">";
                    echo "<li><a href='managemsg.php?page=1'>首頁</a></li>";
                    for ($i=1; $i<=$total_pages; $i++) { 
                        echo "<li><a href='managemsg.php?page=".$i."' data-pageid='".$i."'>".$i."</a></li>";
                    }; 
                    echo "<li><a href='managemsg.php?page=$total_pages'>末頁</a></li>";
                    echo "</ul>";
                }else{
                    //沒有留言的話
                    echo "<p class=\"text-center\">沒有任何訊息！</p>";
                }
            ?>
            <hr>
            <p class="pull-right">以 <?php echo $_SESSION["name"]; ?> 的身份留言</p>
            <h4>新增留言</h4>
            <form id="form" name="form" action="managemsg_add.php" method="post" enctype="multipart/form-data">
                <textarea id="msg" name="msg" class="form-control" required="TRUE"></textarea>
                <input id="ImgFile" name="ImgFile"  type="file" accept="image/jpg, image/jpeg, image/png" class="form-control">
                <img id="imgcode" src="test_code.php" onclick="refresh_code()">
                <input name="checkword" type="text" size="10" maxlength="10" required="TRUE">
                <input id="pageat" name="pageat" type="hidden" value="<?php if(empty($_GET['page'])){echo 1;}else{echo $_GET['page'];}?>" readonly="readonly">
                <input id="button" name="button" type="submit" value="送出" class="btn btn-primary btn-lg btn-block">
            </form>            
            <br>
            <a class="btn btn-default btn-lg btn-block" href="manager.php">管理者首頁</a>
            <br>
        </div>
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">REPLY Message</h4>
                    </div>
                    <div class="modal-body">
                        <!-- <form id="form1" name="form1" action="managemsg_add_rep.php" method="post" onclick="return false"> -->
                        <form id="form1" name="form1" action="managemsg_add_rep.php" method="post" enctype="multipart/form-data">        
                            <textarea id="msg1" name="msg1" class="form-control" required="TRUE"></textarea>
                            <input id="ImgFile" name="ImgFile"  type="file" accept="image/jpg, image/jpeg, image/png" class="form-control">
                            <input id="msg2" name="msg2" type="hidden" readonly="readonly">
                            <img id="imgcode1" src="test_code1.php" onclick="refresh_code1()">
                            <input name="checkword1" type="text" size="10" maxlength="10" required="TRUE">
                            <input id="pageat1" name="pageat1" type="hidden" value="<?php if(empty($_GET['page'])){echo 1;}else{echo $_GET['page'];}?>" readonly="readonly">
                            <input id="button1" name="button1" type="submit" value="送出" class="btn btn-primary btn-lg btn-block">
                            <input id="button2" name="button2" type="submit" value="關閉" class="btn btn-default btn-lg btn-block" data-dismiss="modal">
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
                        <button id="button1" name="button1" type="submit" value="送出" class="btn btn-primary">SEND</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>                  
                    </div> -->
                </div>
            </div>
        </div>
    </body>
</html>

<!-- <?php

    echo "<pre>";print_r($_SESSION);

?> -->