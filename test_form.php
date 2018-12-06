<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>php圖形驗證碼</title>

<script>
    function refresh_code(){ 
        document.getElementById("imgcode").src="test_code.php"; 
    } 
</script>

<form name="form1" method="post" action="test_check.php">
    <p>請輸入下圖字樣：</p>
    <p><img id="imgcode" src="test_code.php" onclick="refresh_code()" /><br><br>點擊圖片可以更換驗證碼</p>
    <input type="text" name="checkword" size="10" maxlength="10" />
    <input type="submit" name="Submit" value="送出" />
</form>

<!--
<form name="form1" method="post" action="test_check.php">  

    驗證碼：<input type="text" name="checknum" id="checknum">
    <img src="test_code.php" id="rand-img">
    <input type="reset" name=""  value="重設">
    <input type="submit" name="" value="送出">

</form>-->