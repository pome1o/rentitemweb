
<?php
session_start();
header("Content-type: text/html; charset=utf-8");
require_once("../dbtools.inc.php");
include("../check_fun.php");
include("../check_stop.php");
include("../header.php");
$p = $_SESSION['chmod'];
date_default_timezone_set("Asia/Taipei");
$link = create_connection();
?>
<?php 
include("../nav.php");

$now = date('Y');
echo $sql_check = "select * From semester_value WHERE date_from = '".$now."-08-01'";
$result = execute_sql($link,"borrow",$sql_check);
$check_row = mysqli_num_rows($result);
if($check_row <= 0){
	$now_tw = $now - 1911;
echo	$sql_insert = "INSERT INTO semester_value (semester,date_from,date_to) VALUES ('".$now_tw."1','".$now."-08-01','".($now + 1)."-01-31')";
	execute_sql($link,"borrow",$sql_insert);
echo	$sql_insert = "INSERT INTO semester_value (semester,date_from,date_to) VALUES ('".$now_tw."2','".($now + 1) ."-02-01','".($now + 1)."-07-31')";
	execute_sql($link,"borrow",$sql_insert);
}

mysqli_close($link);


?>
        <section class="section">
            <div class="container" style="text-align:center;">
                <div id=search-bar>
                <div class="select is-dark">
                <select id="classnum">
                    <option selected="selected" value="other">請選擇</option>
                    <option value="1A">1A</option>
                    <option value="1B">1B</option>
                    <option value="2A">2A</option>
                    <option value="2B">2B</option>
                    <option value="3A">3A</option>
                    <option value="3B">3B</option>
                    <option value="4A">4A</option>
                    <option value="4B">4B</option>
                    <option value='delay'>延修生</option>
                    <option value="畢業生">畢業生</option>
                    <?php if($p == 3 || $p ==5){
                        echo "<option value='teacher'>老師</option>
                        <option value='manager'>工讀生</option>
			<option value='master'>系助</option>
			";
                    } ?>
                    
                </select>
                </div>
                <input type="text" id="search_bar" name="search_bar" class="input is-dark" style="width:20%;"  placeholder="學號,姓名,卡號">
                <a class="button is-dark is-outlined" onclick="tablesearch()">搜尋</a>
                <a id="insert_account" class="button is-dark is-outlined" onclick="insertAccount()">新增帳號</a>
                </div>
                <div id="account_info" style="text-align:center;"></div>
            </div>
        </section>
        <script>
        
            $('#search_bar').keypress(function(key) {
                keycode = key.which;
                if (keycode == 13) {
                    tablesearch();
                }

            });
            //下拉是選單 選擇後讀取班級
            $('#classnum').change(function() {
                var value = $(this).val();
                if(value != "other"){
                getAccountDetailData(value);
                }                
            });
            var current_data;
            //印出大量資料
            function getAccountDetailData(value){
                
                $.ajax({
                    type: "POST",
                    url: "account.php",
                    dataType: "json",
                    data: {
                        id: value,
                        mod: "getclass",
                        userInput: $("#search_bar").val()
                    },
                    success: function(data) {
                        $('#account_info').html("");
                        $('#account_info').append("<div><a id='graduation_btn' class='button is-dark is-outlined' onclick='graduation()'>4年級畢業帳號停用</a> <a id='change_card_btn' data-clickcount=False class='button is-dark is-outlined' onclick='addinput()'>卡號大量修改</a></div>")
                        $('#account_info').append("<table id=account_table align='center' class='table is-hoverable is-bordered' style='margin-top:3%;'>");
                        //TABLE 標題
                        var table_title =["學號","姓名","班級","信箱", "卡號", "違規次數","權限","修改","驗證","停權"];
                        var title = ""

                        for(var i = 0; i < table_title.length; i ++){
                            if(i == 0 ){
                                title += "<tr>";
                            }
                            title += "<th>" + table_title[i] +"</th>";
                        }                       
                        title += "</tr>";
                        $('#account_table').append(title);

                        var inputId = ["user_id", "user_name","class","email","card_id", "user_foul","user_type"];
                        var type_data = ["[0]學生", "[1]老師", "[2]工讀生","[3]系助"];
                        var requestCode = true;

                        for (var i = 0; i < data.length; i++) {
							
                            if (data[0] == 404) {
                                requestCode = false;
                                break;
                            }
							
                            if (i > 0) {
                                var data_feild = data[i];
                                var temp = ""
                                for (var j = 0; j < inputId.length; j++) {
                                    if (j == inputId.length - 1) {
                                        temp += "<td><span>" + type_data[data_feild[inputId[j]]] + "</span></td>";
                                    } else {
                                        temp += "<td><span>" + data_feild[inputId[j]] + "</span></td>";
                                    }
                                }
                                //印出按鈕
                                temp += '<td><a id=class_change' + i + ' class="button is-dark is-outlined" onclick="getAccountDetail(&quot;' + data_feild['user_id'] + '&quot;)">修改</a></td>';
                                temp += '<td><a class="button is-dark is-outlined" onclick="send_verfiy(&quot;'+ data_feild['user_id'] +'&quot;)">發送驗證</a></td>'
                                if(data_feild['user_stop']== 5){
                                    temp += "<td><a id=class_resume" + i + " class='button is-dark is-outlined' onclick=change_click(" + data_feild['user_id'] + ",3,this.id)>恢復</a></td>";                                    
                                    $('#account_table').append('<tr id=' + data_feild['user_id'] + ' style="background-color:#FF6666">' + temp + '</tr>');
                                    
                                }else{
                                    temp += "<td><a id=class_delete" + i + " class='button is-dark is-outlined' onclick=change_click(" + data_feild['user_id'] + ",1,this.id)>停用</a></td>";                                   
                                    $('#account_table').append('<tr id='+ data_feild['user_id'] +'>' + temp + '</tr>');
                                }                                                              
                            }
                        }
                        if (!requestCode) {
                            $('#account_info').html("查無資料");
                        }
                    }
                });
            }
            //詳細資料
            function getAccountDetail(num) {
                var inputId = ["user_id", "user_name","class","email","card_id", "user_foul","user_stop","user_type"];
                var fieldTitle = ["學號:", "姓名:","班級:","信箱:", "卡號:", "違規次數:","停權:","權限:"];
                var input_value = $('#search_bar').val();
                if (num != "no") {
                    input_value = num;
                }
                var selectvalue = $("#classnum").val();
                
                input_value = $.trim(input_value);
                $('#search_bar').val('');
                if (input_value.length > 0) {
                    $.ajax({
                        type: "POST",
                        url: "account.php",
                        dataType: "json",
                        data: {
                            id: input_value,
                            mod: "getDetail"
                        },
                        success: function(data) {
                            <?php   
                            if($p == 3 || $p == 5){
                                echo "var type_data = ['學生', '老師', '工讀生','系助'];";
                            }else{
                                echo "var type_data = ['學生'];";
                            }
                            ?>
                            var stop_data = ["[0]正常","[1]停權"];
                            var count = inputId.length;
                            var requestCode = true;
                            $('#account_info').html("");
                            for (var x = 0; x < data.length; x++) {
                                if (data[0] == 404) {
                                    requestCode = false;
                                    break;
                                }
                                if (x > 0) {
                                    $('#account_info').append('<form id=change_form' + x + ' method=post action=account_change.php >');
                                    $('#change_form' + x).append("<table id=account_table" + x + " align=center class='table is-hoverable is-bordered' style='margin-top:3%;'>");
                                    var data_feild = data[x];
                                    for (var i = 0; i < fieldTitle.length; i++) {
                                        
                                        if (i == count - 1 || i== count -2) {
                                            if(i == count-2){
                                                //一般資料
                                                $('#account_table' + x).append('<tr><td align=right>' + fieldTitle[i] + '</td><td><select name=user_stop id=user_stop' + x + '></select>');
                                                for (var a = 0; a < stop_data.length; a++) {
                                                    var c = "";
                                                    if (stop_data[data_feild[inputId[count - 2]]] == stop_data[a]) {
                                                        c = "selected=selected";
                                                    }
                                                    $('#user_stop' + x).append('<option ' + c + ' value=' + a + '>' + stop_data[a] + '</option>');
                                                }
                                            }else{
                                                //印出選項
                                                $('#account_table' + x).append('<tr><td align=right>' + fieldTitle[i] + '</td><td><select name=type_select id=type_select' + x + '></select>');
                                                for (var a = 0; a < type_data.length; a++) {
                                                    var c = "";
                                                    if (type_data[data_feild[inputId[count - 1]]] == type_data[a]) {
                                                        c = "selected=selected";
                                                    }
                                                    $('#type_select' + x).append('<option ' + c + ' value=' + type_data[a] + '>' + type_data[a] + '</option>');
                                                }
                                            }
                                        } else if(i == 2) {
                                            var temp_html = ""
                                            var temp_option = data_feild[inputId[i]]
                                            var temp_value = ["無","1A","1B","2A","2B","3A","3B","4A","4B","delay","畢業生"];
                                            var temp_selected = ""
                                            for(var k = 0; k < temp_value.length; k++){
                                                var temp_selected = ""
                                                if(temp_value[k] == temp_option){
                                                    temp_selected = "selected='selected'" + temp_option
                                                }
                                                
                                                if(k == 9){
                                                    temp_html += "<option value='"+temp_value[k]+"'"+temp_selected+">延修生</option>"
                                                }else{
                                                    
                                                    temp_html += "<option value='"+temp_value[k]+"'"+temp_selected+">"+ temp_value[k] +"</option>"
                                                }
                                            }
                                            $('#account_table' + x).append('<tr><td align=right>' + fieldTitle[i] + '</td><td><select name="class">'+ temp_html+'</select>');
                                        }else{
                                             $('#account_table' + x).append('<tr><td align=right>' + fieldTitle[i] + '</td><td><input type=text name=' + inputId[i] + ' value=' + data_feild[inputId[i]] + ' >');
                                        }
                                    }
                                    $('#change_form' + x).append('<a  id=confirm_change' + x + ' class="button is-dark is-outlined" align=center onclick=change_click(' + x + ',0)>修改</a> ');
                                    $('#change_form' + x).append('<a id="goback" class="button is-dark is-outlined" onclick="getAccountDetailData(&quot;'+selectvalue+'&quot;)">返回</a>');
                                }
                                if (!requestCode) {
                                    $('#account_info').html("查無帳號");
                                }
                            }
                        }
                    });
                }
            }

            function insertAccount() {
                var inputId = ["user_id", "user_name","class","email","card_id","user_type"];
                var fieldTitle = ["帳號/學號:", "姓名:","班級(沒有填無):","信箱:", "卡號:","權限:"];               
                <?php   
                if($p == 3 || $p == 5){
                    echo "var type_data = ['學生', '老師', '工讀生','系助'];";
                }else{
                    echo "var type_data = ['學生'];";
                }
                ?>
                var count = inputId.length;
                $('#account_info').html("");
                $('#account_info').append('<form id=insert_form method=post action=account_change.php >');
                $('#insert_form').append("<table id=account_table align=center class='table is-hoverable is-bordered' style='margin-top:3%;'>");
                
                for (var i = 0; i < fieldTitle.length; i++) {
                    if (i == count - 1) {
                        $('#account_table').append('<tr><td align=right>' + fieldTitle[i] + '</td><td><select name=type_select id=type_select></select>');
                        for (var a = 0; a < type_data.length; a++) {
                        $('#type_select').append('<option  value=' + type_data[a] + '>' + type_data[a] + '</option>');
                        }
                    } else if(i == 0){
						$('#account_table').append('<tr><td align=right>' + fieldTitle[i] + '</td><td><input type=text name=' + inputId[i] + ' placeholder="注意大小寫!" required>');
                    } else if(i == 2){
						var temp_option = "";
						var temp_value = ["無","1A","1B","2A","2B","3A","3B","4A","4B","delay","畢業生"];
						for(var k = 0; k < temp_value.length; k++){
							if(k== 9){
							temp_option += "<option value='"+ temp_value[k]+"'>延修生</option>";
							}else{
							temp_option += "<option value='"+ temp_value[k]+"'>"+temp_value[k]+"</option>";
							}
							
						}
						$('#account_table').append('<tr><td align=right>'+ fieldTitle[2]+'</td><td><select name="class" >'+temp_option+'</seelect></td>');
					}else{
						 $('#account_table').append('<tr><td align=right>' + fieldTitle[i] + '</td><td><input type=text name=' + inputId[i] + ' required>');
					}
                }
                $('#insert_form').append('<a  id="confirm_change" class="button is-dark is-outlined" align="center" onclick=change_click("","2")>新增</a> ');
                $('#insert_form').append('<a  class="button is-dark is-outlined" onclick=insertLotAccount()>多筆上傳</a>');
            }

            function insertLotAccount(){
                $('#account_info').html("");
                $('#account_info').append('<form id=insert_form method=post action =../do/adduser.php enctype = mutipart/form-data >');
                $('#insert_form').append("<table id=account_table align=center class='table is-hoverable is-bordered' style='margin-top:3%;'>");
                $('#account_table').append("<input id='input_file' type='file' class=input is-dark >");
                $('#insert_form').append("<a  class='button is-dark is-outlined' align='center' onclick=uploadUser()>上傳</a> ");
                $('#insert_form').append("<a  href='http://120.96.63.55/boom/帳號檔案.xlsx' class='button is-dark is-outlined'>格式下載</a> ");
                $('#insert_form').append('<a  class="button is-dark is-outlined" onclick=insertAccount()>單筆上傳</a> ');
            }

            function graduation(){
                swal({
                    title: '確定?',
                    text: "確定?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText:"取消",
                    confirmButtonText: '確定'
                    }).then(function(result){
                    if (result) {
                        $.ajax({
                            url:"/boom/do/graduation.php",
                            type:"POST",
                            dataType:"json",
                            success:function(data){
                                if(data.numCode[0] == 200){
                                    swal(
                                    '',
                                    '畢業帳號已停止使用',
                                    'success'
                                    )
                                }
                            }
                        })
                        
                    }
                })
            }        

           
        </script>
        <?php include("../footer.php");?>
