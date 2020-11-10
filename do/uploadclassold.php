<?php
header("Content-Type:text/html; charset=utf-8");
$n = rand(1,9999);
$target_dir = "../uploads/";
$target_name =$_FILES["fileup"]["name"];

$target_file = $target_dir.$n."."."csv";

$uploadOk = 1;
$type = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
$roomno = $_POST['roomno'];
$roomname = $_POST['roomname'];


// todo 檔案是否存在
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

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
    if (move_uploaded_file($_FILES["fileup"]["tmp_name"],$target_file )) {
        header("Content-Type:text/html; charset=utf-8");
        $target_dir = "../uploads/";
        $target_name =$_FILES["fileup"]["name"];
        $file = "../uploads/".$n."."."csv";
        $target_file = $target_dir.$n."."."csv";
        $fi = fopen($file,"r") or die("FUCK");
        $firstline=true;
        require_once("../dbtools.inc.php");
        $link = create_connection();
        $tempca = "ha";
        $a = 0;
       
        echo "<table border='1'>";
        echo "<tr><td><h1>5秒後轉頁</h1></td></tr>";
        $sql_cl_add = "INSERT INTO classroom (roomNo,roomName) VALUES ('$roomno','$roomname')";
         
        $ckf = true;
        while(($data = fgetcsv($fi))!=false && !($a>7)){
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
            for($i = 0; $i<count($data)-2; $i++){
                $temparray[$a][$i] = $data[$i];
                $type = mb_detect_encoding($data[$i],$enclist);
                
                // todo 將檔案轉成UTF-8
                if($type!="UTF-8"){
                    $data[$i]= iconv("big5", "UTF-8", $data[$i]);
                    $temparray[$a][$i]=$data[$i];
                }
                if($a>0 && $i>0){
                    if($temparray[$a][$i]>2){
                        $ckf=false;
                    }
                }
            }
            $a++; 
        }
        
       
        $o=0;
        if($ckf){
        while($a!=$o){
            $ha[0] = $temparray[$o][0];$ha[1] = $temparray[$o][1];$ha[2] = $temparray[$o][2];$ha[3] = $temparray[$o][3];
            $ha[4] = $temparray[$o][4]; $ha[5] = $temparray[$o][5];
            $sql_in = "INSERT INTO classperiod (room,period,Mon,Tue,Wed,Thu,Fri) VALUES ('$roomno',$ha[0],$ha[1],$ha[2],$ha[3],$ha[4],$ha[5])";
            execute_sql($link,"borrow",$sql_in);
            echo "<tr><td>$ha[0]</td><td>$ha[1]</td><td>$ha[2]</td><td>$ha[3]</td><td>$ha[4]</td><td>$ha[5]</td></tr>";      
            $o++;           
        }
        echo "</table>";
        execute_sql($link,"borrow",$sql_cl_add);}else{ echo "<h1>檔案內數字有錯</h1>";}
        mysqli_close($link);
        fclose($fi);
        	

        unlink($target_file);
    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }
  
    header("Refresh: 5; url=../addclass.php");
}



?>