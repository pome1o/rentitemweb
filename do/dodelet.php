<?php
    date_default_timezone_set('Asia/Taipei');
    $datetime = date("Y-m-d H:i:s");
    require_once("../dbtools.inc.php");
    header("Content-type: text/html; charset=utf-8");
	$requestCode = "200";
	$requestText = "成功";
    if(isset($_POST['user_select'])){
		$user_select = $_POST['user_select'];
		$ca = $_POST['category'];
        $link = create_connection();
		$sql = "";
		for($i = 0; $i<count($user_select); $i++){
			 $sql = "DELETE FROM item_info WHERE itemNo ='". $user_select[$i] . "'";
			execute_sql($link,"borrow",$sql);
		}
		$sql_check = "SELECT COUNT(*) FROM item_info WHERE catergory ='$ca'";
		$result = execute_sql($link,"borrow",$sql_check);
		$count_row = mysqli_fetch_row($result);
		
		if($count_row[0] <= 0){
			$sql = "DELETE FROM item_category WHERE num = '$ca'";
			execute_sql($link,"borrow",$sql);
		}
        mysqli_close($link);
    }
	$json = array("numCode" => array($requestCode,$requestText));
	echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>
