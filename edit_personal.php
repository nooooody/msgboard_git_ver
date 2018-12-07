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
        showpersonal();
      });

      function showpersonal() {
        $.ajax({
            url: 'ajax_show_personal.php',
            type: 'POST',
            dataType: 'json',
            success: function(d) {
                // console.log(d);
                $('#per_name').val(d.data.name);
                $('#per_nick').val(d.data.nick);
            }
        });
      }

      function edit() {
        var p_name = $('#per_name').val();
        var p_nick = $('#per_nick').val();
        $.ajax({
            url: 'ajax_edit_personal.php',
            data: {'p_name':p_name, 'p_nick':p_nick},
            type: 'POST',
            dataType: 'json',
            success: function(d) {
                console.log(d);
                // $('#del_check').modal('hide');
            }
        });
      }

    </script>

    <body>
        <br><br><br><br>
        <div class="container">
            <h3 class="text-center">修改個人資料</h3>
            <hr>
        </div>
        <div class="container">
          <div class="col-md-6 col-md-offset-3">
              <form id="editform" name="editform" method="POST">
                  <label>姓名(Name) *</label>
                  <input id="per_name" name="per_name" class="form-control input-lg" placeholder="輸入姓名(Name)"/>
                  <p id="p1" name="p1" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>
                  <label>暱稱(Nick) *</label>
                  <input id="per_nick" name="per_nick" class="form-control input-lg" placeholder="輸入暱稱(Nick)"/>
                  <p id="p2" name="p2" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>
                  <button id="doedit" name="doedit" class="btn btn-primary btn-lg btn-block" type="button" onclick="edit();">修改</button>
              </form>
              <br>
              <a class="btn btn-default btn-lg btn-block" href="manager.php">管理者首頁</a>
              <a class="btn btn-default btn-lg btn-block" href="manager.php">管理者首頁</a>
              <a class="btn btn-default btn-lg btn-block" href="manager.php">管理者首頁</a>                                                                 
          </div>
        </div>
        <br>
    </body>
</html>