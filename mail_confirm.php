<?php
require_once("dbtools.inc.php");

if(isset($_GET['verfiy'])){
    $link = create_connection();
    $ver = $_GET['verfiy'];
     $sql_check = "SELECT * FROM verfiy_mail WHERE verfiy = '$ver'";
    $result = execute_sql($link,"borrow",$sql_check);

    if($result){
        $row = mysqli_fetch_assoc($result);
        $mail = $row['mail'];
        $id = $row['account'];
        $sql_ok = "UPDATE student SET email = '$mail' WHERE studentID = '$id'";
        if(execute_sql($link,"borrow",$sql_ok)){
            $sql_delete = "DELETE FROM verfiy_mail WHERE account ='$id' AND verfiy ='$ver'";
            execute_sql($link,"borrow",$sql_delete);
            header('Location: http://120.96.63.55/boom/');
        }else{
            echo "錯誤";
        }        
    }else{
        echo "錯誤";
    }
}
?>