<?php
// todo 檢查登入及權限
session_start();
include("check_fun.php");
include("header.php");
include("nav.php");?>
    <div class="container">
        <div id="bigtitle" class="section">
        <div class="subtitle is-4">確認頁面</div>
        <div><p class="subtitle is-4">使用者帳號:<?php echo $studentID?> 使用者姓名:<?php echo $personName?></p></div>
        <div class="search-box">           
            <div><input id="textfiel" type="text" class="input is-dark" value="請輸入學號" onfocus="inputClear()" onkeypress="if (event.keyCode == 13) {droplist_search()}"></div>
            <div class="select is-dark">
                    <select id="itemselect" name="item_category" onchange='droplist_search()'>
                        <option value="name">直接輸入</option>
                        <option value="allitem">顯示全部</option>          
                    </select>
            </div>
        </div> 
        </div>
        <div id="displaytable" class="section">
            <script>
                $("#displaytable").load("showpage/ckall.php");
            </script>
        </div>
    </div>
    <?php include("footer.php");?>
