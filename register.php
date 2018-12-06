<!DOCTYPE html>
<html>
    <head>
        <title>會員註冊</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#doregister").click(function() {
                $.ajax({
                        url: 'ajax_register.php',
                        data: $("#registerform").serialize(),
                        type: 'POST',
                        dataType: 'json',
                        success: function(d) {
                            console.log(d);
                            if (d.error == 111) {
                                $('#p1').html("*請輸入姓名").css('opacity',1);
                                $('#p2').html("*請輸入暱稱").css('opacity',1);
                                $('#p3').html("*請輸入密碼").css('opacity',1);
                                $('#p4').html("*請輸入Email").css('opacity',1);
                            } else if (d.error == 222) {
                                $('#p1').html(d.msg).css('opacity',1);
                            } else if (d.error == 333) {
                                $('#p2').html(d.msg).css('opacity',1);
                            } else if (d.error == 444) {
                                $('#p3').html(d.msg).css('opacity',1);
                            } else if (d.error == 555) {
                                $('#p4').html(d.msg).css('opacity',1);
                            } else if (d.error == 666) {
                                $('#p4').html(d.msg).css('opacity',1);
                            } else if (d.error == 777) {
                                $('#name').val("");
                                $('#nick').val("");
                                $('#password').val("");
                                $('#email').val("");
                                $('#p1').html(d.msg).css('opacity',0);
                                $('#p2').html(d.msg).css('opacity',0);
                                $('#p3').html(d.msg).css('opacity',0);
                                $('#p4').html(d.msg).css('opacity',0);
                                alert("註冊成功");
                            } else {
                                $('#p4').html("*系統發生錯誤").css('opacity',1);
                            }
                        }
                })
            });

            $("#name").keyup(function() {
                $("#p1").css("opacity",0);
            });
            $("#nick").keyup(function() {
                $("#p2").css("opacity",0);
            });
            $("#password").keyup(function() {
                $("#p3").css("opacity",0);
            });
            $("#email").keyup(function() {
                $("#p4").css("opacity",0);
            });
        });
    </script>

    <body>
        <br><br><br><br>
        <div class="container">
            <div class="row jumbotron">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="text-center">會員註冊</h2>
                    <br>
                    <form id="registerform" name="registerform" method="POST">
                        <label>姓名 *</label>
                        <input id="name" name="name" type="text" class="form-control">
                        <p id="p1" name="p1" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>

                        <label>匿稱 *</label>
                        <input id="nick" name="nick" type="text" class="form-control">
                        <p id="p2" name="p2" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>

                        <label>密碼 *</label>
                        <input id="password" name="password" type="password" class="form-control">
                        <p id="p3" name="p3" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>

                        <label>Email *</label>
                        <input id="email" name="email" type="email" class="form-control">
                        <p id="p4" name="p4" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>
                        <button id="doregister" name="doregister" class="btn btn-primary btn-lg btn-block" type="button">註冊</button>
                    </form>
                    <br>
                    <a class="btn btn-default btn-lg btn-block" href="login.php">返回登入</a>
                </div>
            </div>
        </div>
    </body>
</html>