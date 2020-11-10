<!DOCTYPE html>
<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include("../check_fun.php");
include("../header.php");
include("../nav.php");?>
        <section class="section">
            <div class="container" style="text-align:center;">
                <div class="select is-dark">
                <select id="classnum">
                    <option selected="selected">列表(請選擇)</option>
                    <option value="1A">1A</option>
                    <option value="1B">1B</option>
                    <option value="2A">2A</option>
                    <option value="2B">2B</option>
                    <option value="3A">3A</option>
                    <option value="3B">3B</option>
                    <option value="4A">4A</option>
                    <option value="4B">4B</option>
                </select>
                </div>
                <input type="text" id="search_bar" name="search_bar" class="input is-dark" style="width:20%;" placeholder="請輸入">
                <button id="confirm_btn" class="button is-dark is-outlined" value="確認" onclick="getAccountDetail('no')">確認</button>
                <button id="insert_account" class="button is-dark is-outlined" onclick="insertAccount()">新增帳號</button>
                <div id="account_info"></div>
            </div>
        </section>
        <script>
            $('#search_bar').keypress(function(key) {
                keycode = key.which;
                if (keycode == 13) {
                    getAccountDetail("no");
                }

            });
            $('#classnum').change(function() {
                var value = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "account.php",
                    dataType: "json",
                    data: {
                        id: value,
                        mod: "getclass"
                    },
                    success: function(data) {
                        $('#account_info').html("");
                        $('#account_info').append("<table id=account_table align=center class='table is-hoverable is-bordered' style='margin-top:3%;'>");
                        $('#account_table').append('<tr><td>學號</td><td>姓名</td><td>卡號</td><td>違規次數</td><td>權限</td><td>修改</td><td>刪除</td></tr>');
                        var inputId = ["user_id", "user_name", "card_id", "user_foul", "user_type"];
                        var type_data = ["學生", "老師", "系辦"];
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
                                temp += "<td><button id=class_change" + i + " class='button is-dark is-outlined' onclick=getAccountDetail(" + data_feild['user_id'] + ")>修改</button></td>";
                                temp += "<td><button id=class_delete" + i + " class='button is-dark is-outlined' onclick=change_click(" + data_feild['user_id'] + ",3,this.id)>刪除</button></td>";
                                $('#account_table').append('<tr>' + temp + '</tr>');
                            }
                        }
                        if (!requestCode) {
                            $('#account_info').html("查無資料");
                        }
                    }
                });
            });
            var current_data;

            function getAccountDetail(num) {
                var inputId = ["user_id", "user_name", "card_id", "user_foul", "user_type"];
                var fieldTitle = ["學號:", "姓名:", "卡號:", "違規次數:", "權限:"];
                var input_value = $('#search_bar').val();
                if (num != "no") {
                    input_value = num;
                }
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
                            var type_data = ["學生", "老師", "系辦"];
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
                                        if (i == count - 1) {
                                            $('#account_table' + x).append('<tr><td align=right>' + fieldTitle[i] + '</td><td><select name=type_select id=type_select' + x + '></select>');
                                            for (var a = 0; a < type_data.length; a++) {
                                                var c = "";
                                                if (type_data[data_feild[inputId[count - 1]]] == type_data[a]) {
                                                    c = "selected=selected";
                                                }
                                                $('#type_select' + x).append('<option ' + c + ' value=' + a + '>' + type_data[a] + '</option>');
                                            }
                                        } else {
                                            $('#account_table' + x).append('<tr><td align=right>' + fieldTitle[i] + '</td><td><input type=text name=' + inputId[i] + ' value=' + data_feild[inputId[i]] + ' >');
                                        }
                                    }
                                    $('#change_form' + x).append('<button type=button id=confirm_change' + x + ' class="button is-dark is-outlined" align=center onclick=change_click(' + x + ',0)>修改</button> ');
                                    $('#change_form' + x).append('<button type=button id=confirm_change' + x + ' class="button is-dark is-outlined" align=center onclick=change_click(' + x + ',1)>刪除帳號</button>');
                                }
                            }
                            if (!requestCode) {
                                $('#account_info').html("查無帳號");
                            }
                        },
                        error: function() {}
                    });
                }
            }

            function insertAccount() {
                var inputId = ["user_id", "user_name", "card_id", "user_foul", "user_type"];
                var fieldTitle = ["學號:", "姓名:", "卡號:", "違規次數:", "權限:"];
                var type_data = ["學生", "老師", "系辦"];
                var count = inputId.length;
                $('#account_info').html("");
                $('#account_info').append('<form id=insert_form method=post action=account_change.php >');
                $('#insert_form').append("<table id=account_table align=center class='table is-hoverable is-bordered' style='margin-top:3%;'>");
                for (var i = 0; i < fieldTitle.length; i++) {
                    if (i == count - 1) {
                        $('#account_table').append('<tr><td align=right>' + fieldTitle[i] + '</td><td><select name=type_select id=type_select></select>');
                        for (var a = 0; a < type_data.length; a++) {
                            $('#type_select').append('<option  value=' + a + '>' + type_data[a] + '</option>');
                        }
                    } else {
                        $('#account_table').append('<tr><td align=right>' + fieldTitle[i] + '</td><td><input type=text name=' + inputId[i] + ' required>');
                    }
                }
                $('#insert_form').append('<button type=button id=confirm_change class="button is-dark is-outlined" align=center onclick=change_click("","2")>新增</button> ');
            }

        </script>
        <?php include("../footer.php");?>

    </html>
