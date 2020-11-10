<?php
ob_start();
header("Content-Type:text/html; charset=utf-8");
$target_dir = "../uploads/";
$target_name =$_FILES["fileup"]["name"];

$target_file = $target_dir."物品上傳格式"."."."csv";

$uploadOk = 1;
$type = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image



// todo 檔案是否太大
if ($_FILES["fileup"]["tmp_name"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// todo 格式是否為csv檔
if($type != "csv" ) {
    echo "Sorry, only csv files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} 
else {
	if (file_exists($target_file)) {
		unlink($target_file);
	}
    if (move_uploaded_file($_FILES["fileup"]["tmp_name"],$target_file )) {
        header("Content-Type:text/html; charset=utf-8");
        $target_dir = "../uploads/";
        $target_name =$_FILES["fileup"]["name"];
        $file = "../uploads/物品上傳格式.csv";
        $fi = fopen($file,"r") or die("FUCK");
        $firstline=true;
        require_once("../dbtools.inc.php");
        $link = create_connection();
        $tempca = "ha";
        $a = 0;
        $check = true;

        $array_ca_name = array();
        $array_ca_num = array();
        $sql_cate = "SELECT * FROM item_category";
        $cate_result = execute_sql($link,"borrow",$sql_cate);
        while($row = mysqli_fetch_row($cate_result)){
            array_push($array_ca_num,$row[0]);
            array_push($array_ca_name,$row[1]);
        }

        echo "<table border='1'>";
        echo "<tr><td><h1>5秒後轉頁</h1></td></tr>";

        while(($data = fgetcsv($fi))!==false && $check){
            if($firstline){ 
                $firstline = false; continue;
            }
            
            $enclist = array( 
            'UTF-8', 'ASCII', 
            'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 
            'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10', 
            'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 
            'Windows-1251', 'Windows-1252', 'Windows-1254', 
            );
            //echo   mb_detect_encoding($data[4],$enclist)."<br>";
            for($i = 0; $i<count($data); $i++){
                $type = mb_detect_encoding($data[$i],$enclist);
                if($type!="UTF-8"){
                    $data[$i] = iconv("big5", "UTF-8", $data[$i]);
                }
                if(preg_match("/[\@!\'\"\|\?\%\^\(\)\=\+\$\#]/",$data[$i])){
                    $check = false;
                    echo "請勿使用底線 _ - 以外的符號";
                    break;
                }   
            }
            // echo print_r($data)."<br>";
            // echo mb_detect_encoding($data[4],$enclist)."<br>";          
            if($check){
                if(strlen($data[4]) > 0){
                    $num_take_white = preg_replace('/\s/',"",trim($data[1]));
                    $array_id_num = array();  
                    if(preg_match("/~|～/",$num_take_white)){                                          
                        $num = preg_split("/~|～/",$num_take_white);                    
                        for($i = $num[0];$i<=$num[1];$i++){
                            array_push($array_id_num,$i);
                        }
                    }else{
                        array_push($array_id_num,$num_take_white);
                    }
                    
                    
                    $brand_speci = preg_split("/&|＆/",$data[3]);
                    if(!in_array($data[2],$array_ca_name)){
                        $sql_inca = "INSERT INTO item_category (name) VALUES ('$data[2]')";
                        execute_sql($link,"borrow",$sql_inca);
                        array_push($array_ca_name,$data[2]);
                        array_push($array_ca_num,mysqli_insert_id($link));
                    }
                    $item_id = array_search($data[2],$array_ca_name);
                    for($i = 0; $i < $data[4]; $i++){
                        $item_num = $data[0].$array_id_num[$i];
                        $sql_insert = "INSERT INTO item_info (itemNo,specification,brand,catergory) VALUES ('$item_num','$brand_speci[1]','$brand_speci[0]',$array_ca_num[$item_id])";
                        execute_sql($link,"borrow",$sql_insert);
                        echo "<tr><td>$item_num</td><td>$brand_speci[1]</td><td>$brand_speci[0]</td><td>$array_ca_num[$item_id]</td></tr>";                        
                    }               
                }
            
            }else{
                echo "有誤";
                break;
            }
        }
        echo "</table>";        
        mysqli_close($link);
        fclose($fi);
        
    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }    
	
    header("Refresh: 5; url=../newitem.php"); 
	ob_flush();
}


?>