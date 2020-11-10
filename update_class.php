<?php
    session_start();
    include("../boom/check_fun.php");
    include("../boom/header.php");
    include("../boom/nav.php");
    include("check_stop.php");
?>

<div class="container">
    <div id="bigtitle" class="section">
        <div class="title is-3">更新課表</div>
            <div class="search-box">
            <form  method="post" enctype="multipart/form-data" action="/boom/do/upload_class.php" >
                <div>
                <input class="button is-dark is-outlined" type='file' name='fileToUpload' id = 'fileToUpload'> <button class="button is-dark is-outlined">送出</button>
               
                
                    <a href='/boom/教室格式.xlsx' class="button is-dark is-outlined">格式下載</a>
                    </div>
            </form>  
            </div>
    </div>
</div>
<script>
</script>
<?php
    include("footer.php");
?>

