//----------------------------借教室

        // todo 顯示選擇的教室借用狀況 給借教室用
        function chose() {
            var a = document.getElementsByName("UserChose");
            for (var i = 0; i < a.length; i++) {
                var ca;
                if (a[i].checked) {
                    c = a[i].value;
                    a[i].checked = true;
                }
            }
            //alert("以選擇"+c);
            document.cookie = "rooom=" + c;
            location.href = 'roomborrow.php?value=' + c;

        }
        // todo 檢查登入
        function checklog() {
            var c = getCookie("comein");
            if (c == "True") {
                return true;
            }
            swal("請先登入");
            return false;
        }

        function getCookie(cookieName) {
            var name = cookieName + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }
        //--------------------------設備查詢用
        var name;
        // todo 檢查輸入是否為null
        function check_date() {

            if (document.getElementById("textfiel").value.length > 0) {
                var text = document.getElementById("textfiel").value;
                name = text;
                $("#ccc").load("showpage/all.php?choice=name&who=" + name);
            } else {

                alert("沒有輸入");
            }
        }

        //------------------------查看教室用
        // todo 檢查選擇
        function chose() {
            var a = document.getElementsByName("UserChose");
            for (var i = 0; i < a.length; i++) {
                var ca;
                if (a[i].checked) {
                    c = a[i].value;
                    a[i].checked = true;
                }
            }
            //alert("以選擇"+c);
            //document.cookie = "rooom="+c;

            // todo 依照選擇刷新頁面
            location.href = 'roomtime.php?value=' + c;

        }
        //-----------------------查實驗室用
        var name;
        // todo 檢查輸入是否為null
        function check_date() {

            if (document.getElementById("textfiel").value.length > 0) {
                var text = document.getElementById("textfiel").value;
                name = text;
                $("#ccc").load("showpage/laball.php?choice=name&who=" + name);
            } else {

                alert("沒有輸入");
            }
        }


        function ck() {            
            var t = true;
            for (var i = 1; i <= 3; i++) {
                var a = document.getElementById("t" + i).value.length;
                if (a <= 0) {
                    var t = false;
                    break;
                }
            }

            if (t == false) {
                alert("請勿留白");
            } else {
                myForm.submit();
            }
        }

        // todo 顯示CSV上傳
        function goup() {
            $("#eachitem").hide();
            $("#manyitem").show();
            $("#new").load(document.URL + "#new");

        }

        // todo 回新增單筆
        function back() {
            $("#eachitem").show();
            $("#manyitem").hide();
            $("#new").load(document.URL + "#new");
        }

        //account_main 確認修改
        function change_click(num, mod, buttonid) {
            var formname = "change_form" + num;
            var user_value = "確定修改?\n";
            var check = true;
            var putdata = "";
            if (mod == 2 || mod == 0) {
                if (mod == 2) {
                    formname = "insert_form" + num;
                    user_value = "確定新增?"
                }
                $("#" + formname).find("input").each(function(ee) {
                    if ($(this).val().length <= 0) {
                        check = false;
                    }
                });
                putdata = $("#" + formname).serialize() + "&mod=" + mod;
            }
            if (mod == 1 || mod == 3) {
                user_value = "確定修改?";
                putdata = {
                    user_id: num,
                    mod: mod
                };
            }

            if (check) {
                var con = confirm(user_value);
                if (con == true) {
                    $.ajax({
                        type: "POST",
                        url: "account_change.php",
                        dataType: "text",
                        data: putdata,
                        success: function(data) {
                            if (data == 200) {
                                swal("成功");
                                if (mod == 3) {
                                    $("#" + buttonid).closest('tr').css("background-color","white");
                                    $("#" + buttonid).text("停用");
                                    $("#"+buttonid).attr("onclick","change_click("+num+",1,'"+buttonid+"')");
                                    $("#"+buttonid).attr("id",buttonid);
                                }
                                if (mod == 1){
                                    $("#" + buttonid).closest('tr').css("background-color","#FF6666");
                                    $("#" + buttonid).text("恢復");
                                    $("#"+buttonid).attr("onclick","change_click("+num+",3,'"+buttonid+"')");
                                    $("#"+buttonid).attr("id",buttonid);
                                }
                                if(mod == 2){
                                    send_verfiy($("input[name='user_id']").val())
                                }
                            } else {
                                swal("失敗");
                            }
                        }
                    });
                }
            } else {
                swal("請勿留白");
            }
        }
        //-----------------------index用
        // todo 帳密確認
        function check_login() {
            if (document.myForm.studentID.value.length == 0)
                swal("帳號欄位不可以空白哦！");
            else if (document.myForm.password.value.length == 0)
                swal("密碼欄位不可以空白哦！");
            else
                myForm.submit();
            return false;
        }
        //換頁
        function page(ch) {
            
            var path = window.location.pathname;
            var progressUrl = "";
            var a = document.getElementById("itemselect").value;
            var booforsame = false;
            var booforsame2 = false;
            var type = $("#itemselect").data("type")
            var shorturl = "";
            if (path == "/boom/returnlab.php") {
                shorturl = "returnalllab.php";
                booforsame = true;
            } else if (path == "/boom/cklab.php") {
                shorturl = "ckalllab.php";
                booforsame = true;
            } else if (path == "/boom/returnitem.php") {
                shorturl = "reutrnall.php";
                booforsame = true;
            } else if (path == "/boom/ckborrow.php") {
                shorturl = "ckall.php";
                booforsame = true;
            } else if (path == "/boom/search.php") {
                shorturl = "all.php";
                booforsame2 = true;
            } else if (path == "/boom/searchlab.php") {
                shorturl = "laball.php";
                booforsame2 = true;
            } else if (path == "/boom/borrowitem.php") {
                shorturl = "borrow_data.php";
            } else if (path == "/boom/deletitem.php") {
                shorturl = "delshow.php";
            } else if (path == "/boom/borrowlab.php") {
                shorturl = "labshow.php";
            }else if (path == "/boom/show_item.php") {
                shorturl = "get_all_data.php";
            }else if(path =="/boom/report.php") {
                shorturl = "report_data.php";
            }

            if(type){
                var semester = ""
                if($('#semester').val()){
                    semester = $('#semester').val()
                }                 
                progressUrl = "showpage/" + shorturl + "?choice=" + a + "&page=" + ch + "&type="+ type + "&semester=" + semester;
            }else{
                progressUrl = "showpage/" + shorturl + "?choice=" + a + "&page=" + ch;
            }

            if (booforsame) {
                var b = document.getElementById("inin").value;
                if (a == "alltime") {
                    progressUrl = "showpage/" + shorturl + "?choice=" + a + "&page=" + ch;
                } else {

                    progressUrl = "showpage/" + shorturl + "choice=" + a + "&name=" + b + "&page=" + ch;
                }
            }

            if (booforsame2) {
                if (name != "請輸入學號") {
                    progressUrl = "showpage/" + shorturl + "?choice=name&page=" + ch + "&who=" + name;
                } else {
                    progressUrl = "showpage/" + shorturl + "?choice=" + a + "&page=" + ch;
                }
            }
            $("#displaytable").load(progressUrl);
        }
        //下拉是選單 搜尋 按不同位置 給予不同的資料
        function droplist_search() {
    
            var path = window.location.pathname;
            var a = document.getElementById("itemselect").value;

            var booSearchBtn = false;
            var progressUrl = "";
            var shortUrl = "";
            if (path == "/boom/search.php") {
                booSearchBtn = true;
                shortUrl = "all.php";
            } else if (path == "/boom/searchlab.php") {
                booSearchBtn = true;
                shortUrl = "laball.php";
            } else if (path == "/boom/ckborrow.php") {
                shortUrl = "ckall.php";
            } else if (path == "/boom/returnitem.php") {
                shortUrl = "returnall.php";
            } else if (path == "/boom/cklab.php") {
                shortUrl = "ckalllab.php";
            } else if (path == "/boom/returnlab.php") {
                shortUrl = "returnalllab.php";
            }
            if (booSearchBtn) {
                var disbool = "";
                if (a != "personal") {
                    disbool = "disabled";
                    name = "請輸入學號";
                }
                $('#searchbtn').prop('disabled', disbool);
                $('#textfiel').prop('disabled', disbool);
                progresUrl = "showpage/" + shortUrl + "?choice=" + a;
            } else {
                var b = document.getElementById("textfiel").value;
                if (a == "allitem") {
                    document.getElementById("textfiel").disabled = true;
                    progresUrl = "showpage/" + shortUrl + "?choice=" + a;
                } else {
                    document.getElementById("textfiel").disabled = false;
                    if (b.length == 0) {
                        swal("請輸入學號");
                    } else {
                        progresUrl = "showpage/" + shortUrl + "?choice=" + a + "&name=" + b;
                    }
                }
            }
            $("#displaytable").load(progresUrl);
        }

        function droplist_show() {
            
            var path = window.location.pathname;
            //刪除物品
            var type = $("#itemselect").data("type")
            var a = document.getElementById("itemselect").value;
            if (path == "/boom/deletitem.php") {
                $("#displaytable").load("showpage/delshow.php?choice=" + a);
            } else if (path == "/boom/borrowitem.php") {
                $("#displaytable").load("showpage/borrow_data.php?choice=" + a + "&type="+type);
            }else if(path == "/boom/show_item.php"){
                $("#displaytable").load("showpage/get_all_data.php?choice=" + a + "&type="+type);
            }else if(path == "/boom/report.php"){
                $("#displaytable").load("showpage/report_data.php?choice=" + a + "&type="+type);
            }
        }

        function droplist_simple() {
            var drop = document.getElementById("drop").value;
            if (drop == "newcate") {
                document.getElementById("sp").disabled = false;
            } else
                document.getElementById("sp").disabled = true;
        }

        function checkBoxAll_confirm() {
            $('[data-act="checkall"]').each(function() {
                var domm = $(this);
                var scope = domm.data('scope')
                domm.on('change', function() {
                    $('input' + scope + ':checkbox').prop('checked', domm.prop('checked'));
                });
            });
        }

        function checkBoxAll() {
            $('[data-act="checkall"]').each(function() {
                var domm = $(this);
                var scope = domm.data('scope')
                domm.on('change', function() {
                    $('input' + scope + ':checkbox').prop('checked', domm.prop('checked'));
                });
            });
        }
       
       //確認使用者是否選擇
        function check_choose_simple() {
            
            var borrow_type = $('#borrow_type').val();
            
            var temp_lab ="";
            var do_post = false
			var checkbool = false;
            var item_more_day =false;
            $('form').find('input[id=choosebox]').each(function() {
                if ($(this).prop('checked')) {
                    checkbool = true;
                    return false;
                    }
            });            
            
            if (checkbool) {
                if(borrow_type == "lab"){
                    temp_lab += "&lab_cate=" + $('#itemselect').val()
                    do_post = true
                }               
                
                if(borrow_type == "item"){
                    var reg = /([1-9][0-9][0-9][0-9])[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])/
                    var start_time = $('#start_time').val();
                    var end_time = $('#end_time').val();
                    
                    if(reg.test(start_time) && reg.test(end_time)){
                        
                        var start = new Date(start_time)
                        var end = new Date(end_time)
						var interval_mill = Math.abs(end.getTime() - start.getTime())
                        var interval =  Math.ceil(interval_mill/ (1000 * 3600 * 24))
                        if(interval >= 0 && interval <= 14){
                            if(interval > 0){
                                swal({
                                    title: '長期借用請額外填單子',
                                    type: 'warning',
                                    html:"<a class='subtitle is-4' onclick=document.getElementById('borrow_form').submit()>請點這裡填入資料</a>",
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '確認'
                                  }).then(function(result) {
                                    if (result) {
                                        $.ajax({
                                            type:"POST",
                                            url:"/boom/do/doborrow.php",
                                            data:$('[data-act=itemChooseForm]').serialize() + "&item_category=" + $('#itemselect').val() + temp_lab + class_expect_time,
                                            dataType:"json",
                                            success:function(data){
                                                if(data.numCode[0] == "200"){
                                                                                                     
                                                    swal(
                                                        '已紀錄',
                                                        '填完單子後才能正確領取物品',
                                                        'success'
                                                    )          
                                                    droplist_show();                                          
                                                }else{
                                                    droplist_show();
                                                    swal(data.numCode[1])
                                                }
                                            }
                                        });

                                        
					                    /* $.ajax({
                                            type:"POST",
                                            url:"/boom/showpage/item_long_borrow.php",
                                            data:$('[data-act=itemChooseForm]').serialize() + "&item_category=" + $('#itemselect').val() + temp_lab + class_expect_time,
                                            dataType:"html",
                                            success:function(data){
                                                var mywindow = window.open('','iamwindow')
						 mywindow .document.open();
   						 mywindow .document.write(data);
                                            }
                                        }); */                
                                     
                                    }
                                  })
                            }else{
								do_post = true
							}
						}else{
                            swal('時間區間錯誤 請選擇1天-14天');  
                        }                        
                    }else{
                        swal('日期格式不正確');                
                    }
                }
            var class_expect_time = "";    
            if(borrow_type == "class"){
                var class_type = $("#user").data("class_type")
                var now = new Date()                                       
                var hour_start
                
                if(class_type == "today"){
                    if(now.getHours() < 17){
                        do_post = true
                    }else{
                        swal("時間已過-夜間借用請先向系辦領取單子")
                    }                           
                }else{
                    class_expect_time ="&start_time=" + $("#class_date_pick").val() + "&class_expect=1";
                    do_post = true
                }
            }                  

              if(do_post){
                    $.ajax({
                        type:"POST",
                        url:"/boom/do/doborrow.php",
                        data:$('[data-act=itemChooseForm]').serialize() + "&item_category=" + $('#itemselect').val() + temp_lab + class_expect_time,
                        dataType:"json",
                        success:function(data){                            
                            swal(data.numCode[1]);                       
                            if(data.numCode[0] == "200"){
                                droplist_show();
                            }
                        }
                    });
               }             
            } else {
                swal('請選擇');
            }
        }

        //確認 check box 是否勾選
        function check_box_checked(){
            var checkbool = false;
            $('table').find('input[type=checkbox]').each(function() {
                if ($(this).prop('checked')) {
                    checkbool = true;
                    return false;
                }
            });
            if(checkbool){
                return true;
            }else{
                swal('請選擇');
                return false;
            }
            
        }

        function room_box_check(){
            var checkbool = false;
            $('table').find("input[name='nocheck']").each(function() {
                if ($(this).prop('checked')) {
                    checkbool = true;
                    return false;
                }
            });
            if(checkbool){
                return true;
            }else{
                
                return false;
            }
        }
        
        //borrowconfirm 送出 確認或駁回
        function sendConfirmOrReject(x){
            if(check_box_checked()){
                var i =0;
                var temparray = [];
                var room_user_array = [];
                var room_user_data = "";
                $('table').find('input[type=checkbox]').each(function() {
                    var checkbox = $(this);
                    
                    if (checkbox.prop('checked') == true) {
                        temparray[i] = checkbox.attr('id');
                        i++;
                    }
                });
                if(x ==0){
                    if(room_box_check()){
                        $('input[name="check_name[]"]').each(function(){
                            room_user_array.push($(this).val())
                        })
                        room_user_data = ",room_user:room_user_array";
                    }
                }
                
                
            var id = $("#borrow_user").attr("data");
              $.ajax({
                type:"POST",
                url:"/boom/do/doconfirm.php",
                dataType:"json",
                data:{ user_id: id,confirmData:temparray,mod:x+room_user_data},
                success:function(data){
                    swal(data.numCode[1])
                    if(data.numCode[0] == 200){
                        var user_id = $("#textfiel").val();
                        get_confirm_data(0)
                    }
                }    
                });
            }
        }
        
        //borrowconfirm 去得確認資料
        function getConfirmData(){
            var user_id = $("#textfiel").val();
            $.ajax({
                type:"POST",
                url:"/boom/showpage/confirmdata.php",
                dataType:"html",
                data:{id:user_id},
                success:function(data){
                    $("#displaytable").html(data);
                }    
            });
        }

        //nav bar 在手機模式下 切換右上MENU
        document.addEventListener('DOMContentLoaded', function() {
            var $navbarburger = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
            if ($navbarburger.length > 0) {
                $navbarburger.forEach(function($el) {
                    $el.addEventListener('click', function() {
                        var target = $el.dataset.target;
                        var $target = document.getElementById(target);
                        $el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }
        });

        function inputClear() {
            $("#textfiel").val("");
        }

        //account_main 帳號搜尋
        function tablesearch() {
            var input, filter, table, tr, td, i;
            var findbool = false;
            input = document.getElementById("search_bar");
            filter = input.value.toUpperCase();
            table = document.getElementById("account_table");
            if (table) {
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    td2 = tr[i].getElementsByTagName("td")[1];                
                   if (td) {                                         
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            console.log("found");
                            tr[i].style.display = "";
                        } else {
                            console.log("not found"+ i);
                            tr[i].style.display = "none";
                            findbool = true;
                        }
                    }
                }
                
            }else{
                findbool = true;
            }
            if (findbool) {
                getAccountDetailData("search");
            }            
        }

        //account_main 批量上傳帳號
        function uploadUser(){
            var file_data = $('#input_file').get(0).files;
            var form_data = new FormData();
            form_data.append('fileToUpload',file_data[0]);
            $.ajax({
                type:"POST",
                url:"../do/adduser.php",
                dataType:"text",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                    if(data.length>0){
                        if(data == "404"){
                            alert("上傳錯誤");
                        }else if(data == "200"){
                            alert("成功")
                        }
                    }
                }
            })
        }
        
        //forgotpassword 修改密碼按鈕
        function change_password_email(){
            
            var user_id = $("#user_id").val();
            var user_verfiy = $("#user_verfiy").val();
            var user_new_pw = $("#user_new_pw").val();
            var user_pw_check = $("#user_new_pw_check").val();
            var fail_go = false;            
           
            if(user_verfiy.length <=0|| user_new_pw.length <=0|| user_id.length <=0 || user_pw_check.length<=0 ){                
                swal("請勿留白");
            }else{                
                if(user_pw_check != user_new_pw){
                    swal("確認密碼不符")
                }else{
                    fail_go = true;
                }                  
            }
            
            if(fail_go){
            $.ajax({
                type:"POST",
                    url:"/boom/do/change_password.php",
                    dataType:"json",
                    data:{user_id:user_id,user_verfiy:user_verfiy,user_new_pw:user_new_pw},
                    success: function(data){
                        $request = data.numCode;
                        swal($request[1]);
                    }
                })
            }            
        }

        //account_main 批量輸入卡號欄位
        function addinput(){
           var clickcount  = $("#change_card_btn").data("clickcount");            
            if(clickcount){
                $("table > tr").not(':first').append("<td><input type='text' name='card_input'></td>");
                clickcount = false;
                $("#account_info").append("<a class='button is-dark is-outlined' onclick='submit_card_id()'>送出所有卡號</a>");
                $("#change_card_btn").data("clickcount",false);
            }            
            
        }

        //account_main 送出卡號
        function submit_card_id(){
            var i = 0;
            var json = [];      
            $("#account_table  tr").each(function(){
                if(i==0){
                    i = 1;
                   return;                   
                }
                var id = this.id;              
                var card_id = $(this).find("input").val();
                var temp_data = {id:id,card_id:card_id};
                json.push(temp_data)
            })
           var myjson =  JSON.stringify(json)
           myjson = JSON.parse(myjson)
           $.ajax({
            type:"POST",
                url:"../do/change_card_id.php",
                dataType:"json",
                data:{json_data:myjson},
                success: function(data){
                   if(data.numCode[0] == "200"){
                       swal("成功")
                        var value = $("#classnum").val();
                       getAccountDetailData(value);
                   }
                }
            })
        }

        function send_return(){
            if(check_box_checked()){
                var i =0;
                var temparray = [];
                $('table').find('input[type=checkbox]').each(function() {
                    var checkbox = $(this);
                    
                if (checkbox.prop('checked') == true) {
                    temparray[i] = checkbox.attr('id');
                    i++;
                }
            });
                var id = $("#borrow_user").attr("data");
              $.ajax({
                    type:"POST",
                    url:"/boom/do/doreturn1.php",
                    dataType:"json",
                    data:{ user_id: id,confirmData:temparray},
                    success:function(data){
                        swal(data.numCode[1])
						get_return_data(1);
                    }    
                });
            }
        }

        function send_verfiy(id){
            $.ajax({
                type:"POST",
                url:"/boom/do/send_verfiy.php",
                dataType:"json",
                data:{user_id:id},
                success:function(data){
					swal(data.numCode[1])
                }
            })
        }
		
		function delete_send(){
			var do_post = false
			var checkbool = false;            
            $('form').find('input[id=choosebox]').each(function() {
                if ($(this).prop('checked')) {
                    checkbool = true;
                    return false;
                    }
            });

            if(checkbool){
				var cate = $('#itemselect').val()
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
                            type:'post',
                            url:"/boom/do/dodelet.php",
                            data:$('[data-act=itemChooseForm]').serialize() + '&category=' + cate,
                            dataType:"json",
                            success:function(data){
                                swal(data.numCode[1])
								droplist_show()
                            }				
                        });
                        
                    }
                })
			}else{
				swal("請先選擇")
			}
		}
		