<?php
require_once("../dbtools.inc.php");
header("Content-Type:text/html; charset=utf-8");
$do_while = true;
if(isset($_FILES['fileToUpload'])){
    $file_type =  pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION);
    if($file_type != "csv"){
        $do_while = false;
		echo "不是CSV檔";
    }
    if($do_while){
		
        $link = create_connection();
        $file = fopen( $_FILES['fileToUpload']['tmp_name'],"r");
        $i = -1;
        $temp_odd = 0;
        $temp_even = 4;
        $temp_period ="";
        $room_num = "";
		
		$temp_array = ["30801","30802","30803"];
		for($i =0; $i < count($temp_array); $i++){
			$temp_room = $temp_array[$i];
			$sql_insert_room = "INSERT INTO classroom (num,name) VALUES ($temp_room,$temp_room) ON DUPLICATE KEY UPDATE num = '$temp_room'";
			execute_sql($link,"borrow",$sql_insert_room);
		}
		
		
        while(!feof($file)){
            $data =  fgetcsv($file);
            if(count($data) > 6){
                echo "欄位大於六";
                break;
            }
            //碰到最底break
            if($data[0] == "break"){
                break;
            }
            if($data[0] == "live"){
                continue;
            }
            //判斷是哪一間教室
            if($i == -1){
               if(preg_grep("/30801/",$data)){
                $room_num = "30801";
               }else if(preg_grep("/30802/",$data)){
                $room_num = "30802";
               }else if(preg_grep("/30803/",$data)){
                $room_num = "30803";
               }    
            }
            //將時間空格還多餘的移除        
            if(($i >= 2 && $i%2 == 0 && $i < 9) || ($i >10 && $i%2 == 1) || $i == -1 || $i == 0){

            }else{          
                //將早上奇數 格轉成 一般數字順序
                if($i<10){                
                    $temp_period = odd_to_sort($i,$temp_odd);
                    $temp_odd ++;
                    if($temp_odd == 5){
                        $temp_odd = 0;
                    }                
                }
                //將早上偶數 格轉成 一般數字順序
                if($i >9){                
                    $temp_period = odd_to_sort($i,$temp_even);
                    $temp_even ++;
                    if($temp_even == 8){
                        $temp_even = 4;
                    }
                }

                for($j = 0; $j <count($data); $j++ ){
                    if($j != 0 ){
                        if(strlen(trim($data[$j])) > 0 ){
                            $class_name = iconv("big5", "UTF-8", $data[$j]);                       
                        }else{
                            $class_name = "no_class";
                        }                   
                        //$sql = "UPDATE classperiod1 SET class_name = '$class_name' WHERE room_no = '$room_num' AND period = '$i' AND day = '$j'";
                        //$sql = "INSERT INTO classperiod1 (room_no,period,day,class_name) VALUES ('$room_num','$temp_period','$j','$class_name')";

                        $sql = "INSERT INTO classperiod1 (room_no,period,day,class_name) VALUES ('$room_num','$temp_period','$j','$class_name') ON DUPLICATE KEY UPDATE class_name = '$class_name'";
                        execute_sql($link,"borrow",$sql);
                        echo $class_name;
                    }                   
                }
                echo "<br>";
            }      
            if($i == 17){
                $i = -1;
            }else{
                $i++;
            }
        }
        mysqli_close($link);
    }    
	 
}


sleep(5);
header("Location:/boom/update_class.php");

function odd_to_sort($num,$n){
    if($num == 1){
        return 1;
    }  
    return $num - $n;
}
?>