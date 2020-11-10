<?php
    session_start();
    include("../boom/check_fun.php");
    include("../boom/header.php");
    include("../boom/nav.php");
    include("check_stop.php");
    
?>

<div class="container">
    <div id="bigtitle" class="section">
        <div class="title is-3">借用確認</div>
            <div class="search-box">
                <div>
                    <input type="text" class="input is-dark" id="textfiel" placeholder="學號,卡號" onkeypress='return enter_input(event)'> 
                </div>
                <div><a class="button is-dark is-outlined" id="search_button" onclick='get_confirm_data(0)'>查詢</a>
                <a class="button is-dark is-outlined" id="search_button" onclick='get_confirm_data(1)'>列出全部</a></div>
            </div>
    </div>
    <div id="displaytable" class="section" style="
    text-align: -webkit-center;">
    </div>
</div>
<script>
function enter_input(e){
    if(e.keyCode==13){
        get_confirm_data(0);
    }
}
function get_confirm_data(select_type){
    datafield = {all:1};
    if(select_type == 0){
        var user_id = $("#textfiel").val();
        if(user_id.length >0){
            datafield = {id:user_id,all:0}
        }
    }else if(select_type == 1){
        datafield = {all:1}
    }   
     $.ajax({
        type:"POST",
        url:"/boom/showpage/confirmdata.php",
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