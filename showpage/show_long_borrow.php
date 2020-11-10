<?php
header("Content-Type:text/html; charset=utf-8");
require_once("../dbtools.inc.php");
date_default_timezone_set('Asia/Taipei');
session_start();
if(isset($_POST['type']) && isset($_POST['user_select'])){
    
    $link = create_connection();    
    $user_id = $_SESSION['studentId'];
    $user_select_item = $_POST['user_select'];  
    
    $sql_select_user = "SELECT personName,class FROM student WHERE studentID = '$user_id'";
    $result_user =  execute_sql($link,"borrow",$sql_select_user);
    $row_user = mysqli_fetch_assoc($result_user);
    
    $sql_item = "SELECT item_info.itemNo,item_category.name AS name  FROM item_info INNER JOIN item_category on item_info.catergory = item_category.num  WHERE item_info.itemNo = '$user_select_item'";
    $result_item =  execute_sql($link,"borrow",$sql_item);
    $row_item = mysqli_fetch_row($result_item);
    
    $user_name = $row_user['personName'];
    $user_class = $row_user['class'];    
    $item_name = $row_item[1];   
   
        
    
    $date = $_POST['start_time'];        
    $end_time = $_POST['end_time'];
    $end_time = $end_time;
    $note = "";
    if(isset($_POST['note'])){
        $note = trim($_POST['note']);
        $note = mysqli_real_escape_string($link,$note);
    }
    mysqli_close($link);
}else if (isset($_POST['item_id'])){
    
    $link = create_connection();  
    $user_id = $_SESSION['studentId'];
    $item_id = $_POST['item_id'];
    
    $sql_select_user = "SELECT personName,class FROM student WHERE studentID = '$user_id'";
    $result_user =  execute_sql($link,"borrow",$sql_select_user);
    $row_user = mysqli_fetch_assoc($result_user);

    $sql_item = "SELECT tempborrow.itemNo,tempborrow.note,item_category.name,tempborrow.insert_time,tempborrow.expect_return_time  FROM tempborrow INNER JOIN item_info on   tempborrow.itemNo = item_info.itemNo INNER JOIN item_category on item_category.num = item_info.catergory WHERE tempborrow._id = '$item_id'";
    $result_item =  execute_sql($link,"borrow",$sql_item);
    $row_item = mysqli_fetch_row($result_item);

    $user_name = $row_user['personName'];
    $user_class = $row_user['class']; 

    $user_select_item = $row_item[0];
    $note = $row_item[1];
    $item_name = $row_item[2];
    $date = $row_item[3];
    $end_time = $row_item[4];  
    mysqli_close($link);
}else{
    echo "<script>window.close();</script>";
}

?>


<html>
<body>
<form method="post" action="/boom/do/item_long_borrow.php">
<div><span>姓名:</span><span><input type='hidden' name='user_name' value ='<?php echo $user_name; ?>'><?php echo $user_name; ?></span></div>
<div><span>學號:</span><span><input type='hidden' name='user_id' value ='<?php echo $user_id; ?>'><?php echo $user_id; ?></span></div>
<div><span>年級:</span><span><input type='hidden' name='user_class' value ='<?php echo $user_class; ?>'><?php echo $user_class; ?></span></div>
<div><span>設備編號:</span><span><input type='hidden' name='item_no' value ='<?php echo $user_select_item; ?>'><?php echo $user_select_item; ?></span></div>
<div><span>設備名稱:</span><span><input type='hidden' name='item_name' value ='<?php echo $item_name; ?>'><?php echo $item_name; ?></span></div>
<div><span>借用附件:</span><span><input type='hidden' name='item_ps' value ='<?php echo $note; ?>'><?php echo $note; ?></span></div>
<div><span>借用原因:</span><span><input type='text' name='item_reason'></span></div>
<div style='margin-top:0.2%;'><span>手機:</span><span><input type='text' name='user_phone'></span></div>
<div><span>借用日期:</span><span><input type='hidden' name='start_date' value ='<?php echo $date; ?>'><?php echo $date; ?></span></div>
<div><span>歸還日期:</span><span><input type='hidden' name='end_date' value ='<?php echo $end_time; ?>'><?php echo $end_time; ?></span></div>
<div>確認後請按右鍵列印</div>
<div><button>確認</button></div>
</form>
</body>
</html>