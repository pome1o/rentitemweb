<?php
    session_start();
    include("../boom/check_fun.php");
    include("../boom/header.php");
    include("../boom/nav.php");
    include("check_stop.php");
?>

<div class="container">
    <div id="bigtitle" class="section">
        <div class="title is-3">歸還</div>
            <div class="search-box">
                <div>
                    <input type="text" class="input is-dark" id="textfiel" placeholder="帳號,卡號" onkeypress='return enter_input(event)'> 
                </div>
                <div><a class="button is-dark is-outlined" id="search_button" onclick='get_return_data(0)'>查詢</a>
                <a class="button is-dark is-outlined" id="search_button" onclick='get_return_data(1)'>全部列出</a>
                </div>
            </div>
    </div>
    <div id="displaytable" class="section" style="
    text-align: -webkit-center;">
    </div>
</div>
<script>
function enter_input(e){
    if(e.keyCode==13){
        get_return_data(0);
    }
}

function get_return_data(select_type){
    if(select_type == 0){
        var user_id = $("#textfiel").val();
        if(user_id.length >0){
            datafield = {id:user_id}
        }else{
            datafield = {all:1}
        }
    }else if(select_type == 1){
        datafield = {all:1}
    }   
    $.ajax({
        type:"POST",
        url:"/boom/showpage/returndata.php",
        dataType:"html",
        data:datafield,
        success:function(data){
            $("#displaytable").html(data);
        }    
    });   
}
</script>
<?php
    include("footer.php");
?>