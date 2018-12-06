<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

if (isset($_SESSION["email"]) == FALSE) {
    header('Location: login.php');
}

if (!isset($_GET["page"])) { 
    $_SESSION["page"] = 1; 
};

// echo "<pre>";print_r($_SESSION);

// $per_page = 5;

// $start_page = ($_SESSION['page']-1) * $per_page; 

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
            $("#msg_cont").keyup(function() {
                $("#msg_err").css("opacity",0);
            });

            $("#msg_check").keyup(function() {
                $("#msg_err").css("opacity",0);
            });

            $('#myModal').on('hidden.bs.modal', function () {
                $('#rep_cont').val("");
                $('#rep_check').val("");
                $('#rep_img').val("");
                $('#rep_err').css('opacity',0);
            });

            showmessage();
        });

        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        };

        function showmessage(){
            var msg = $("#msg");
            var pagebks = $("#pagebks");
            $.ajax({
                url: 'ajax_show_msg.php?page='+getUrlParameter('page'),
                dataType: 'json',
                success: function(d) {
                    // console.log(d);
                    // console.log(d.data.length);
                    // console.log(d.data[2].reply.length);
                    msg.html("");
                    if (d.status == '555') {
                        var name = d.sess.name;
                        for (var i = 0; i < d.data.length; i++) {
                            var elstr = '<div class="panel panel-default" data-id="'+d.data[i].id+'">'+
                                            '<div class="panel-heading">'+d.data[i].name+
                                                '<span class="pull-right">'+d.data[i].date+
                                                ' '+
                                                '<input type="hidden" id="inid1" class="likesign" value="'+d.data[i].input_like+'">'+
                                                '<button id="like_btn" class="btn btn-default btn-xs buttonsize like_btn">LIKE</button> '+d.data[i].cl+
                                                ' '+
                                                '<input type="hidden" id="inid2" class="unlikesign" value="'+d.data[i].input_unlike+'">'+
                                                '<button id="unlike_btn" class="btn btn-default btn-xs buttonsize unlike_btn">UNLIKE</button> '+d.data[i].cul+
                                                ' '+
                                                '<button id="reply" class="btn btn-success btn-xs reply buttonsize" data-toggle="modal" data-target="#myModal">REPLY</button>'+
                                                ' '+
                                                // '<button id="del" class="btn btn-danger btn-xs dele buttonsize" data-toggle="modal" data-target="#del_check">DELETE</button>'+
                                                '<input type="hidden" id="inid3" class="inid3" value="'+d.data[i].id+'">'+
                                                '</span>'+
                                            '</div>'+
                                            '<div class="panel-body change">';

                                            if (d.data[i].img_path) {
                                                elstr += '<p><img src="'+d.data[i].img_path+'"></p>';
                                            }
                                            elstr += d.data[i].content_data+'</div>';

                            if (d.data[i].reply) {
                                elstr += '<table class="bgcolor">'+'<tbody>';
                                for (var j = 0; j < d.data[i].reply.length; j++) {
                                    elstr +='<tr style="border-top:1px #AAAAAA solid;">'+
                                                '<td style="vertical-align:text-top;font-size:14px;padding:9px;" width="5%">'+d.data[i].reply[j].name+'</td>'+
                                                '<td style="vertical-align:text-top;font-size:14px;padding:9px;" width="5%">回覆</td>'+
                                                '<td style="font-size:14px;padding:9px;" class="change" width="76%">';
                                                    if (d.data[i].reply[j].img_path) {
                                                        elstr += '<p><img src="'+d.data[i].reply[j].img_path+'"></p>';
                                                    }
                                                    elstr += d.data[i].reply[j].content_data+
                                                '</td>'+
                                                '<td style="vertical-align:text-top;font-size:14px;padding:9px;" width="14%">'+d.data[i].reply[j].date+'</td>'+
                                            '</tr>';
                                }
                                elstr += '</tbody>'+'</table>';
                            }
                            elstr +='</div>';
                            msg.append(elstr);
                        }
                        
                        $(".reply").click(function(){
                            // var text = $(this).next('button').next('input').val();
                            var text = $(this).siblings('.inid3').val();
                            $("#rep_msgid").val(text);
                        });

                        $(".dele").click(function(){
                            var text = $(this).next('input').val();
                            $("#del_msgid").val(text);
                        });

                        $(".like_btn").click(function(){
                            // console.log($(this).next().next().next().next().next().val());
                            // console.log($(this).siblings('.inid3').val());
                            var messageid = $(this).siblings('.inid3').val();
                            $.ajax({
                                url: 'ajax_clicklike.php',
                                data: {'messageid':messageid},
                                type: 'POST',
                                dataType: 'json',
                                success: function(d) {
                                    // console.log(d);
                                    showmessage();
                                }
                            });
                        });

                        $(".unlike_btn").click(function(){
                            // console.log($(this).next().next().next().next().next().val());
                            // console.log($(this).siblings('.inid3').val());
                            var messageid = $(this).siblings('.inid3').val();
                            $.ajax({
                                url: 'ajax_clickunlike.php',
                                data: {'messageid':messageid},
                                type: 'POST',
                                dataType: 'json',
                                success: function(d) {
                                    // console.log(d);
                                    showmessage();
                                }
                            });
                        });

                        $('div[data-id]').each(function(){
                            var likesign = $(this).find('.likesign').val();
                            var unlikesign = $(this).find('.unlikesign').val();
                            if (likesign == 1) {
                                $(this).find('.like_btn').addClass('changelikecolor');
                                $(this).find('.unlike_btn').addClass('changedisable');
                            }
                            if (unlikesign == 1) {
                                $(this).find('.unlike_btn').addClass('changeunlikecolor');
                                $(this).find('.like_btn').addClass('changedisable');
                            }
                        });
                    }

                    if (d.page.total_page > 1) {
                        pagebks.html("");
                        var elpagestr = '';
                        var pre = (Number(d.page.current_page)-1);
                        var nex = (Number(d.page.current_page)+1);
                        if (pre < 1) { pre = 1 }
                        if (nex > d.page.total_page) { nex = d.page.total_page }
                        elpagestr += '<ul class="pagination">';
                        elpagestr += '<li><a href="?page='+pre+'">&laquo;</a></li>';
                        if (d.page.current_page == 1) {
                            elpagestr += '<li class="active"><a href="?page=1">1</a></li>';
                        } else {
                            elpagestr += '<li><a href="?page=1">1</a></li>';
                        }
                        
                        var start = d.page.current_page-3;
                        var end = d.page.current_page+3;

                        if (start < 2 ) {
                            start = 2;
                        }
                        if (end >= d.page.total_page) {
                            end = d.page.total_page - 1;
                        }

                        if (start - 1 >= 2) {
                            elpagestr += '<li><span>'+'...'+'</span></li>';
                        }

                        for (var i = start; i <= end; i++) {
                            if (i == Number(d.page.current_page)) {
                                elpagestr += '<li class="active"><a href="?page='+i+'">'+i+'</a></li>';
                            } else {
                                elpagestr += '<li><a href="?page='+i+'">'+i+'</a></li>';
                            }
                        }

                        if (d.page.total_page - end >= 2) {
                            elpagestr += '<li><span>'+'...'+'</span></li>';
                        }

                        if (d.page.current_page == d.page.total_page) {
                            elpagestr += '<li class="active"><a href="?page='+d.page.total_page+'">'+d.page.total_page+'</a></li>';
                        } else {
                            elpagestr += '<li><a href="?page='+d.page.total_page+'">'+d.page.total_page+'</a></li>';
                        }
                        
                        elpagestr += '<li><a href="?page='+nex+'">&raquo;</a></li>';
                        elpagestr += '</ul>';
                        pagebks.append(elpagestr);
                    }

                }
            });
        }

        function delmessage() {
            var msgid = $('#del_msgid').val();
            $.ajax({
                url: 'ajax_del_msg.php',
                data: {'msgid':msgid},
                type: 'POST',
                dataType: 'json',
                success: function(d) {
                    // console.log(d);
                    $('#del_check').modal('hide');
                    showmessage();
                }
            });
        }

        function addmessage() {
            // var file = new FormData();
            // var get_msg_cont = $('#msg_cont').val();
            // var get_msg_check = $('#msg_check').val();
            // var get_msg_img = $('#msg_img').prop('files');
            // var get_msg_page = $('#msg_page').val();
            // file.append('file', get_msg_img[0]);
            // console.log(new FormData($('#msg_form')[0]).getAll('msg_cont'));

            $.ajax({
                url: 'ajax_insert_msg.php',
                data: new FormData($('#msg_form')[0]),
                // data: {'msg_cont':get_msg_cont,'msg_check':get_msg_check,'msg_img':file,'msg_page':get_msg_page},
                // data: file,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                success: function(d) {
                    // console.log(d);
                    $('#msg_err').html(d.msg).css('opacity',1);
                    if (d.status == '999') {
                        refresh_code();
                        $('#msg_cont').val("");
                        $('#msg_check').val("");
                        $('#msg_img').val("");
                        $('#msg_err').html(d.msg).css('opacity',0);
                    }
                    showmessage();
                }
            });
        }

        function addrepmessage() {
            $.ajax({
                url: 'ajax_insert_rep_msg.php',
                data: new FormData($('#rep_form')[0]), processData: false, contentType: false,
                type: 'POST',
                dataType: 'json',
                success: function(d) {
                    // console.log(d);
                    $('#rep_err').html(d.msg).css('opacity',1);
                    if (d.status == '999') {
                        refresh_code1();
                        $('#rep_cont').val("");
                        $('#rep_check').val("");
                        $('#rep_img').val("");
                        $('#myModal').modal('hide');
                        $('#rep_err').html(d.msg).css('opacity',0);
                    }
                    showmessage();
                }
            });

        }

        function refresh_code() { 
            document.getElementById("msg_code").src="test_code.php"; 
        }

        function refresh_code1() { 
            document.getElementById("rep_code").src="test_code1.php";
        }

    </script>
    
    <style>
        .change { white-space: pre; }
        .reply { }
        .dele { }
        .Separationline { border-top: 1px solid #eee; }
        .bgcolor { background-color: #DDDDDD; width: 100%; }
        .changelikecolor,.changelikecolor:hover,.changelikecolor:focus,.changelikecolor:active:focus { 
            background-color: #ffc107; 
            /*cursor: not-allowed; */
            outline: none; 
            box-shadow: none;
            border-color: #ddd }
        .changeunlikecolor,.changeunlikecolor:hover,.changeunlikecolor:focus,.changeunlikecolor:active:focus { 
            background-color: #17a2b8; 
            /*cursor: not-allowed;*/
            outline: none; 
            box-shadow: none;
            border-color: #ddd }
        .changedisable,.changedisable:hover,.changedisable:focus,.changedisable:active:focus { 
            background-color: #fff; 
            /*cursor: not-allowed;*/
            outline: none; 
            box-shadow: none;
            border-color: #ddd }
        .pagination>li>a.pagebutton { background-color: #CCEEFF; }
        .buttonsize { width: 60px; }
        .like_btn { }
        .unlike_btn {  }
        .changewidth { width: 100% !important; }
    </style>
    
    <body>
        <br><br><br><br>
        <div class="container">
            <h3 class="text-center">留言板管理</h3>
            <hr>
            <p class="pull-right">以 <?php echo $_SESSION["name"]; ?> 的身份留言</p>
            <h4>新增留言</h4>
            <form id="msg_form" name="msg_form" action="" method="post" enctype="multipart/form-data">
                <textarea id="msg_cont" name="msg_cont" class="form-control changewidth"></textarea>
                <input id="msg_img" name="msg_img" class="form-control" type="file" accept="image/jpg, image/jpeg, image/png">
                <img id="msg_code" name="msg_code" src="test_code.php" onclick="refresh_code()">
                <input id="msg_check" name="msg_check" type="text" size="10" maxlength="10" required="TRUE">
                <input id="msg_page" name="msg_page" type="hidden" value="<?php echo $_SESSION['page']; ?>" readonly="readonly">
                <p id="msg_err" name="msg_err" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>
                <button id="msg_but" name="msg_but" type="button" class="btn btn-primary btn-lg btn-block" onclick="addmessage();" >送出</button>
            </form>
            <hr>
            <div id="msg"></div>
            <div id="pagebks"></div>
            <hr>
            <a class="btn btn-default btn-lg btn-block" href="member.php">會員首頁</a>
            <br>
        </div>

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">回覆留言</h4>
                    </div>
                    <div class="modal-body">
                        <form id="rep_form" name="rep_form" action="" method="post" enctype="multipart/form-data">        
                            <textarea id="rep_cont" name="rep_cont" class="form-control changewidth" required="TRUE"></textarea>
                            <input id="rep_img" name="rep_img"  type="file" accept="image/jpg, image/jpeg, image/png" class="form-control">
                            <input id="rep_msgid" name="rep_msgid" type="hidden" readonly="readonly">
                            <img id="rep_code" src="test_code1.php" onclick="refresh_code1()">
                            <input id="rep_check" name="rep_check" type="text" size="10" maxlength="10">
                            <input id="rep_page" name="rep_page" type="hidden" value="<?php echo $_SESSION['page']; ?>" readonly="readonly">
                            <p id="rep_err" name="rep_err" style="color: red; font-size: 14px; opacity: 0; margin: 0" >GodMartin</p>
                            <button id="msg_but1" name="msg_but1" type="button" class="btn btn-primary btn-lg btn-block" onclick="addrepmessage();" >送出</button>
                            <button id="msg_but2" name="msg_but2" type="button" class="btn btn-default btn-lg btn-block" data-dismiss="modal">取消</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="del_check" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">刪除留言</h4>
                    </div>
                    <div class="modal-body">確定要刪除嗎?</div>
                    <input id="del_msgid" name="del_msgid" type="hidden" readonly="readonly">
                    <div class="modal-footer">
                        <button id="del_but1" name="del_but1" type="button" class="btn btn-primary btn-lg btn-block" onclick="delmessage();">確定</button>
                        <button id="del_but2" name="del_but2" type="button" class="btn btn-default btn-lg btn-block" data-dismiss="modal">取消</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </body>
</html>