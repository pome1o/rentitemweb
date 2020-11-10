<?php
session_start();
require_once("../dbtools.inc.php");
include("../header.php");
include("../nav.php");
?>

<div class="container">
    <div id="bigtitle" class="section">
    <div class="title is-3">更換密碼</div>
    </div>
    <div  class="section" >
    <div id = "input_send_mail" style="width:50%; margin:auto;">
        <input class="input is-dark" id="user_id" type="text" size="15" placeholder="帳號">
    </div>
    <div id = "input_change_password" style="width:50%; margin:auto; display:none">
        <input class="input is-dark" id="user_verfiy" type="text" size="15" placeholder="驗證碼">
        <input class="input is-dark" id="user_new_pw" type="password" size="15" placeholder="新密碼">
        <input class="input is-dark" id="user_new_pw_check" type="password" size="15" placeholder="確認密碼">
        </div>
    <div>    
     <a type="button" id="confirm" class="button is-dark is-outlined" style="margin-top:1%" onclick="confirm_send()">確認</a>
     <a type= "button" id="change_form_pw"  class="button is-dark is-outlined" style = "margin-top:1%">填寫驗證碼</a>
     </div>
</div>
<script>
    var count = 0;
    function confirm_send(){
        var id = $("#user_id").val();
        if(id.length > 0){
            send_verfiy(id)
        }else{
            swal("請輸入文字")
        }
        
    }
        
    
    $('#change_form_pw').click(function(){
        if(count == 0 ){
            $("#confirm").attr("onclick","change_password_email()");
            $("#change_form_pw").html("發送驗證");
            $("#input_change_password").show();        
            count ++;
        }else{
            $("#confirm").attr("onclick","confirm_send()");
            $("#change_form_pw").html("填寫驗證碼");
            $("#input_change_password").hide();
            count = 0;
        }   
  });

</script>
<?php include("../footer.php");?>