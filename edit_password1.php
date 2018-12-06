<!DOCTYPE html>
<html>
    <head>
        <title>Message Board</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#doedit").click(function() {
                $.ajax({
                        url: 'ajax_edit_password.php',
                        data: $("#editform").serialize(),
                        type: 'POST',
                        dataType: 'json',
                        success: function(d) {
                            // console.log(d);
                            // $('#result').val(d);
                            if (d.status == 111) {
                                $('#p1').html("*請輸入新密碼").css('opacity',1);
                                $('#p2').html("*請再輸入一次新密碼").css('opacity',1);
                            } else if (d.status == 222) {
                                $('#p1').html(d.msg).css('opacity',1);
                            } else if (d.status == 333) {
                                $('#p2').html(d.msg).css('opacity',1);
                            } else if (d.status == 444) {
                                $('#p2').html(d.msg).css('opacity',1);
                            } else if (d.status == 999) {
                                alert("修改成功");
                                $('#pass1').val("");
                                $('#pass2').val("");
                                $('#p1').html(d.msg).css('opacity',0);
                                $('#p2').html(d.msg).css('opacity',0);
                            } else {
                                $('#p2').html("*系統發生錯誤").css('opacity',1);
                            }
                        }
                })
            });

            $("#pass1").keyup(function() {
                $("#p1").css("opacity",0);
            });
            $("#pass2").keyup(function() {
                $("#p2").css("opacity",0);
            });
        });
    </script>
    
    <body>
        <br><br><br><br>
        <div class="container">
            <h3 class="text-center">修改密碼</h3>
            <hr>
        </div>
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <form id="editform" name="editform" method="POST">
                    <input id="pass1" name="pass1" class="form-control input-lg" type="password" placeholder="輸入新密碼"/>
                    <p id="p1" name="p1" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>
                    <input id="pass2" name="pass2" class="form-control input-lg" type="password" placeholder="再輸入一次新密碼"/>
                    <p id="p2" name="p2" style="color: red; font-size: 14px; opacity: 0; margin: 0">GodMartin</p>
                    <!-- <input id="result" name="result" class="form-control input-lg" type="text" readonly="readonly" placeholder="訊息提示"/> -->
                    <button id="doedit" name="doedit" class="btn btn-primary btn-lg btn-block" type="button">修改</button>
                </form>
                <br>
                <a class="btn btn-default btn-lg btn-block" href="member.php">會員首頁</a>                                                                    
            </div>
        </div>
        <br>
    </body>
</html>