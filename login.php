<!DOCTYPE html>
<html>
    <head>
        <title>會員登入</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#dologin").click(function() {
                $.ajax({
                        url: 'ajax_login_check.php',
                        data: $("#loginform").serialize(),
                        type: 'POST',
                        dataType: 'json',
                        success: function(d) {
                            console.log(d);
                            if (d.error == 9) {
                                $('#p1').html(d.msg).css('opacity',1);
                            } else if (d.error == 8) {
                                $('#p2').html(d.msg).css('opacity',1);
                            } else if (d.error == 7) {
                                 $('#p2').html(d.msg).css('opacity',1);
                            } else if (d.error == 6) {
                                 $('#p1').html(d.msg).css('opacity',1);
                            } else if (d.error == 5) {
                                 $('#p1').html('請輸入Email').css('opacity',1);
                                 $('#p2').html('請輸入密碼').css('opacity',1);
                            } else {
                                 $('#p2').html(d.msg).css('opacity',1);
                            }

                            if (d.level == 1) {
                                window.location = 'member.php';
                            } else if (d.level == 2) {
                                window.location = 'manager.php';
                            }
                        }
                })
            });

            $("#email").keyup(function() {
                $("#p1").css("opacity",0);
            });
            $("#pass").keyup(function() {
                $("#p2").css("opacity",0);
            });

        });
    </script>
    
    <body>
        <br><br><br><br>
        <div class="container">
            <div class="row jumbotron">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="text-center">會員登入</h2><br/>
                    <form id="loginform" name="loginform" method="POST">
                        <input id="email" name="email" class="form-control input-lg" type="text" placeholder="E-Mail"/>
                        <p id="p1" name="p1" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>
                        <input id="pass" name="pass" class="form-control input-lg" type="password" placeholder="密碼"/>
                        <p id="p2" name="p2" style="color: red; font-size: 14px; opacity: 0; margin: 0">GodMartin</p>
                        <!-- <input id="result" name="result" class="form-control input-lg" type="text" readonly="readonly" placeholder="訊息提示"/> -->
                        <button id="dologin" name="dologin" class="btn btn-primary btn-lg btn-block" type="button">登入</button>
                    </form>
                    <br>
                    <a class="btn btn-default btn-lg btn-block" href="register.php">會員註冊</a>                                                                          
                </div>
            </div>
        </div>
    </body>
</html>