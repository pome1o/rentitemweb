<?php
header("Content-Type:text/html; charset=utf-8");
require_once("../dbtools.inc.php");
$link = create_connection();

$error_csv = false;
$error_img = false;
$csv_success = false;
$img_success = false;

$img_types = array('image/jpeg', 'image/png');

$lab_num = $_POST["lab_num"];
$lab_name = $_POST["lab_name"];

// todo file[0] 實驗室CSV   file[1] 實驗室座位圖

$csv_target_dir = "../uploads/labs/$lab_num.csv";
//echo $csv_target_dir."<br>";

$csv_target_name = $_FILES["file"]["name"][0];
$csv_ext = pathinfo($csv_target_name, PATHINFO_EXTENSION);



$img_target_name = $_FILES["file"]["name"][1];
$img_ext = pathinfo($img_target_name, PATHINFO_EXTENSION);

// todo 圖片上傳位置
$img_target_dir = "../uploads/labs/$lab_num.$img_ext";
$thumbimg_target_dir = "../uploads/labs/thumb_$lab_num.$img_ext";
//echo $img_target_dir."<br>";

//echo $lab_num."<br>";
//echo $_FILES["file"]["type"][1]."<br>";
//echo $_FILES["file"]["name"][1]."<br>";
//echo $_FILES["file"]["size"][1]."<br>";

//echo "實驗室的編號：".$_POST["lab_num"]."<Br>";
//echo "實驗室的名稱：".$_POST["lab_name"]."<Br>";

// todo CSV 處理
if(is_file($csv_target_dir)){
    echo "CSV檔案已存在"."<br>";
    $error_csv = true;
}

if($csv_ext != "csv"){
    echo "檔案不是CSV檔"."<Br>";
    $error_csv = true;
}

if($_FILES["file"]["size"][0] >= 500000){
    echo "CSV檔太大"."<Br>";
    $error_csv = true;
}

if (move_uploaded_file($_FILES["file"]["tmp_name"][0],$csv_target_dir)){
    header("Content-Type:text/html; charset=utf-8");
    $file = fopen($csv_target_dir,"r") or die("檔案開啟錯誤");
    $firstline = true;
    $error = false;
    
    $a = 0;
    while(($data = fgetcsv($file))!=false && $error_csv != true){
        //echo count($data);
        if(count($data) > 1){
            echo "檔案格式有錯"."<Br>";
            $error_csv = true;
        }
        
        if($firstline){  
            $firstline = false; 
            continue;
        }
        
        $enclist = array( 
            'UTF-8', 'ASCII', 
            'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 
            'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10', 
            'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 
            'Windows-1251', 'Windows-1252', 'Windows-1254', 
        );
        
        for($i = 0; $i < count($data); $i++){
            $temparray[$a] = $data[$i];
            //echo $temparray[$i]."<Br>";
            
            $type = mb_detect_encoding($data[$i],$enclist);
            //echo $type."<br>";
            if($type!="UTF-8"){
                $data[$i]= iconv("big5", "UTF-8", $data[$i]);
                $temparray[$a] = $data[$i];
            }
            
            if($a > 0 && $i > 0){
                if($temparray[$i] > 2){
                    $error_csv = true;
                }
            }
        }
        
        
        // todo CSV 檔檢查重複值
        $arr_duplicate = array_count_values($temparray);
        //print_r($arr_duplicate); 
        
        foreach($arr_duplicate as $key => $value){
            //echo $key." & ". $value."<Br>";
            if($value > 1){
                $error_csv = true;
                echo "檔案內有重複的欄位"."<br>";
            }
        }

        $a++;
    }
    
    fclose($file);
    unlink($csv_target_dir);
        
    
}
else{
    echo "上傳失敗"."<Br>";
}

// todo 圖片處理
if(!in_array($_FILES["file"]["type"][1], $img_types)){
    echo "圖片格式錯誤"."<Br>";
    //echo $_FILES["file"]["type"][1]."<br>";
    echo "只能上傳 .jpg 或 .png 檔"."<Br>";
    $error_img = true;
}

if($_FILES["file"]["size"][1] >= 4096000){
    echo "圖檔超過大小"."<Br>";
    $error_img = true;
}

if(is_file($img_target_dir)){
    echo "圖檔已存在"."<Br>";
    $error_img = true;
}


if($error_img == false && $error_csv == false){
    
    if($_FILES["file"]["type"][1] == "image/jpeg"){
        $src = imagecreatefromjpeg($_FILES['file']['tmp_name'][1]);
        $type = "jpg";
    }
    else{
        $src = imagecreatefrompng($_FILES['file']['tmp_name'][1]);
        $type = "png";
    }
    $img_width = imagesx($src);
    $img_height = imagesy($src);
    
    $thumb_width = $img_width / 2;
    $thumb_height = $img_height / 2;
    /*
    echo $img_width."<br>";
    echo $img_height."<br>";
    echo $thumb_width."<br>";
    echo $thumb_height."<br>";
    */
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled($thumb, $src, 0, 0, 0, 0, $thumb_width, $thumb_height, $img_width, $img_height);
    
    if($type == "jpg"){
        if(is_dir("../uploads/labs")){
            if(imagejpeg($thumb, $thumbimg_target_dir)){
                $img_success = true;
            }
            else{
                echo $_FILES["file"]["error"][1];
            }
        }
        else{
            mkdir("../uploads/labs", 0777);
            if(imagejpeg($thumb, $thumbimg_target_dir)){
                $img_success = true;
            }
            else{
                echo $_FILES["file"]["error"][1];
            }  
        }
    }
    else{
        if(is_dir("../uploads/labs")){
            if(imagepng($thumb, $thumbimg_target_dir)){
                $img_success = true;
            }
            else{
                echo $_FILES["file"]["error"][1];
            }
        }
        else{
            mkdir("../uploads/labs", 0777);
            if(imagepng($thumb, $thumbimg_target_dir)){
                $img_success = true;
            }
            else{
                echo $_FILES["file"]["error"][1];
            }  
        }
    }

    if(move_uploaded_file($_FILES["file"]["tmp_name"][1], $img_target_dir)){
        //echo "圖片上傳成功"."<br>";
        $img_success = true;
    }
    else{
        echo $_FILES["file"]["error"][1];
        echo "上傳失敗圖片失敗"."<br>";
    }
    
    $sql_ca = "INSERT INTO lab_category(num, name, img) VALUES ('$lab_num','$lab_name', '$lab_num.$img_ext')";
    //echo $sql_ca."<br>";
    mysqli_select_db($link, "borrow")or die("開啟資料庫失敗: " . mysqli_error($link));
    if(mysqli_query($link, $sql_ca)){
        //echo "成功"."<br>";
    }
    else{
        echo "失敗".mysqli_error($link)."<br>";
    }
    
    if($error == false){
        $meeting = false;
        for($i = 0; $i < count($temparray); $i++){
            //echo $temparray[$i]."<br>";
            if($meeting == false){
                $sql_info = "INSERT INTO laboratory_info(lab_num, seat_num) VALUES ('$lab_num', 'Meeting')";
                $meeting = true;
            }
            else{
                $sql_info = "INSERT INTO laboratory_info(lab_num, seat_num) VALUES ('$lab_num', '$temparray[$i]')";
                //echo $sql_info."<br>";
                mysqli_select_db($link, "borrow")or die("開啟資料庫失敗: " . mysqli_error($link));
            }
            
						 
            if(mysqli_query($link, $sql_info)){
                //echo "成功"."<br>";
                $csv_success = true;
            }
            else{
                echo "失敗".mysqli_error($link)."<br>";
            }
            
        }
    }
    mysqli_close($link);

    
}

if($csv_success == true && $img_success == true){
    echo "成功新增實驗室 ".$lab_num."<Br>";
}
else{
    echo "新增實驗室失敗"."<br>";
}


echo "五秒後返回"."<br>";
header("Refresh: 5; url=../add_lab.php");





?>