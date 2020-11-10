<?php
// todo 檢查登入與權限
include("check_fun.php");
include("header.php");
include("nav.php");?>
    <div class="container">
        <table align="center">
            <tr>
                <h1 align="center">歸還實驗室</h1>
            </tr>
            <tr>
                <p align="center">
                    登入使用者帳號:
                    <?php echo $studentID?> 使用者姓名:
                    <?php echo $personName?><br>
                </p>
            </tr>
            <tr align="center">
                <td align="center">
                    <input id="inin" type="text" value="請輸入學號" onfocus="myclear()" onkeypress="if (event.keyCode == 13) {droplist_search()}">
                    <select id="itemselect" name="item_category" style="width: 110px; height: 30px" onchange='droplist_search()'>
                        <option value="name">直接輸入</option>
                        <option value="allitem">顯示全部</option>     
                    </select></td>
            </tr>
        </table>
        <div id="displaytable" style="position: relative;">
            <script>
                $("#displaytable").load("showpage/returnalllab.php");
            </script>
        </div>
    </div>
    <?php include("footer.php");?>
