<?php
    session_start();
    include("header.php");  
    include("nav.php"); ?>
<div class="container">
    <h2 class="title is-2">設備查詢</h2>
    <table class="table" align="center">
        <tr>
            <td>
                <input class="input is-dark" type="text" id="textfiel" value="請輸入學號" onkeypress="if (event.keyCode == 13) {check_date()}" onfocus="inputClear()" disabled="true">
            </td>
            <td>
                <button type="button" class="button is-dark is-outlined" id="searchbtn" onclick="check_date()" disabled="true">查詢</button>
            </td>
            <td>
                <div class="select is-dark">
                <select id="itemselect" name="item_category" onchange='droplist_search()'>
                    <option value="no">請選擇</option>
                        <?php
                            require_once("dbtools.inc.php");
                            $link = create_connection();
                            $sql_s = "SELECT * FROM item_category";
                            $sl = execute_sql($link,"borrow",$sql_s);
                        
                            while($row = mysqli_fetch_assoc($sl)){
                                echo "<option value=".$row['id']." >".$row['itemName']."</option>";
                            }
                            echo "<option value='personal'>個人紀錄</option>";
                            mysqli_free_result($sl);
                            mysqli_close($link);
                        ?>
                </select>
                </div>
            </td>
        </tr>
    </table>
    <div id="displaytable" style="position: relative;">
        <script>
            $("#displaytable").load("showpage/all.php");

        </script>
    </div>
</div>
<?php include("footer.php");?>
