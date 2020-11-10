<?php
session_start();
require_once("../boom/dbtools.inc.php");
include("../boom/header.php");
include("../boom/nav.php");
$link = create_connection();
$a = $_SESSION['studentId'];
?>

<div class="container">
    <div id="bigtitle" class="section">
        <div class="title is-3" align="center">個人帳號</div>
        
        <a class='button is-dark is-outlined' id='person_change_pw'>更改密碼</a>
        <a class='button is-dark is-outlined' id='person_change_email'>更改信箱</a>
        <a class='button is-dark is-outlined' id='now_borrow'>目前借用中</a>
    </div>

    <div id="displaytable" class="section">
    <table class="table table is-hoverable is-bordered" align="center">
    <?php
        $sql_info = "SELECT * FROM student WHERE studentID = '$a'";
        $result = execute_sql($link,"borrow",$sql_info);
        $row = mysqli_fetch_assoc($result);

        $stop_status = "停權";
        switch($row['stop']){
            case -2:
            $stop_status = "帳號尚未改密碼或是登入卡號";
            break;
            case -1:
            $stop_status = "尚未登入卡號";
            break;
            case 0:
            $stop_status = "尚未更改密碼開通";
            break;
            case 5:
            $stop_status = "已被停權";
            break;
            case 1:
            $stop_status = "正常";
            break;
        }
        echo "<tr><td>帳號狀態:</td><td>$stop_status</td></tr>";
        echo "<tr><td>帳號:</td><td>".$row['studentID']."</td></tr>";
        echo "<tr><td>卡號: </td><td>".$row['cardId']."</td></tr>";       
        echo "<tr><td>信箱: </td><td>".$row['email']."</td></tr>";
        echo "<tr><td>班級: </td><td>".$row['class']."</td></tr>";
        
        mysqli_close($link);
    ?>
    </table>
    </div>
</div>
<script>

var count = 0;
$("#person_change_pw").click(function(){
    $("#displaytable").html("")
    $("#displaytable").load("/boom/showpage/forgotpassword.php")
})

$("#person_change_email").click(function(){
    $("#displaytable").html("")
    if(count ==0){
        var email_item = ""
        email_item += "<form id='new_mail_form'>"
        email_item += "<div style='width:50%; margin:auto;'><input type'text' class='input is-dark' id='newmail' placeholder='新信箱'></div>";
        email_item += "<div><a class='button is-dark is-outlined' onclick='change_mail()'>送出驗證信</a></div>"
    
        $("#displaytable").append(email_item)
        $("#newmail").data("account",<?php echo "'".$a."'"; ?>)
    }
    count ++;
   
})

$("#now_borrow").click(function(){
    $("#displaytable").html("")
	count = 0;
    $.ajax({
        type:"POST",
        url:"/boom/showpage/user_get_borrow.php",
        dataType:"html",
        data:{id:<?php echo"'".$a."'";?>},
        success:function(data){
            $("#displaytable").html(data);
        }    
        });
})

function change_mail(){
    var newmail = $("#newmail").val()
    var id = $("#newmail").data("account")
	count = 0;
    if(newmail.length > 0){
        $.ajax({
            type:"POST",
            url:"/boom/do/change_mail.php",
            data:{mail:newmail,user_id:id},
            dataType:"json",
            success:function(data){
                swal(date.numCode[1])
            }
        })
    }else{
        swal("請勿留白")
    }
}
</script>
<?php include("../boom/footer.php");?>