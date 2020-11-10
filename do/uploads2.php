<?php
header("Content-Type:text/html; charset=utf-8");
$target_dir = "../uploads/";
$target_name =$_FILES["fileup"]["name"];
$file = "../uploads/1.csv";
$target_file = $target_dir."1"."."."csv";
$fi = fopen($file,"r") or die("FUCK");
        $firstline=true;
         require_once("../dbtools.inc.php");
         $link = create_connection();
        $tempca = "ha";
        $a = 0;
       
        echo "<table border='1'>";
         echo "<tr><td><h1>5秒後轉頁</h1></td></tr>";
         echo "<tr><td>編號</td><td>型號</td><td>廠牌</td><td>作業系統</td><td>種類</td></tr>";
        while(($data = fgetcsv($fi))!==false){
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
           echo   mb_detect_encoding($data[4],$enclist)."<br>";
            for($i = 0; $i<5; $i++)
               {
                 
                       $type = mb_detect_encoding($data[$i],$enclist);
                       if($type!="UTF-8")
                       {
                       $data[$i] = iconv("big5", "UTF-8", $data[$i]);
                       }
                 
               }
           echo print_r($data)."<br>";
            echo   mb_detect_encoding($data[4],$enclist)."<br>";
           if($data[4]!=null && !preg_match('/\s/',$data[4]))
           {
               
            if($tempca!=$data[4])
            {
            $sql_ca = "SELECT * FROM item_category WHERE itemName ='$data[4]'";
            
                $sv_r = execute_sql($link,"borrow",$sql_ca);
              if(mysqli_num_rows($sv_r)<=0)
              {
                  $sql_inca = "INSERT INTO item_category (itemName) VALUES ('$data[4]')";
                  execute_sql($link,"borrow",$sql_inca);
              }
                $sv_r = execute_sql($link,"borrow",$sql_ca);
                $get = mysqli_fetch_assoc($sv_r);
                $sv_ca = $get['id'];
                
            }
          
            
            $tempca = $data[4];
            $sql_in = "INSERT INTO item_info (itemNo,specification,brand,os,catergory) VALUES ('$data[0]','$data[1]','$data[2]','$data[3]',$sv_ca)";
            execute_sql($link,"borrow",$sql_in);
            echo "<tr><td>$data[0]</td><td>$data[1]</td><td>$data[2]</td><td>$data[3]</td><td>$data[4]</td></tr>";
               
           }
        }
        echo "</table>";
        mysqli_free_result($sv_r);
        mysqli_close($link);
         fclose($fi);
        //header("Refresh: 5; url=../newitem.php");	

       unlink($target_file);
?>

