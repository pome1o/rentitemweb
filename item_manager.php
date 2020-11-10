<?php
    session_start();
    include("../boom/check_fun.php");
    include("../boom/header.php");
    include("../boom/nav.php");
    include("check_stop.php");
    
?>

<div class="container">
    <div id="bigtitle" class="section">
        <div class="title is-3">物品管理</div>
            <div class="search-box">
            
            </div>
    </div>
    <div id="displaytable" class="section" style="
    text-align: -webkit-center;">
    </div>
</div>

<script>
function get_item(){
$.ajax({
    type:"post",
    url:"/boom/showpage/all_borrow.php",
    data:{mod:0},
    success:function(data){
        $("#displaytable").html(data)
    }
})
}

get_item();
</script>

<?php
    include("footer.php");
?>