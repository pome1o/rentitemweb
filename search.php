<?php
    session_start();
    include("../boom/check_fun.php");
    include("../boom/header.php");
    include("../boom/nav.php");
    include("check_stop.php");
?>

<div class="container">
    <div id="bigtitle" class="section">
        <div class="title is-3">查詢</div>
            <div class="search-box">               
                <div><a class="button is-dark is-outlined" id="search_button" onclick='get_return_data()'>查詢</a></div>
                <div><a class="button is-dark is-outlined" id="search_button" onclick='get_return_data()'>查詢</a></div>
                <div><a class="button is-dark is-outlined" id="search_button" onclick='get_return_data()'>查詢</a></div>
            </div>
    </div>
    <div id="displaytable" class="section" style="
    text-align: -webkit-center;">
    </div>
</div>
<script>
function enter_input(e){
    if(e.keyCode==13){
        get_return_data();
    }
}
function get_return_data(){
    var user_id = $("#textfiel").val();
        if(user_id.length >0){
            $.ajax({
                type:"POST",
                url:"/boom/showpage/returndata.php",
                dataType:"html",
                data:{id:user_id},
                success:function(data){
                    $("#displaytable").html(data);
                }    
            });
        }
}

</script>
<?php
    include("footer.php");
?>