<?php
  //連結資料庫
  function create_connection()
  {
    $link = mysqli_connect("***", "***", "***")
      or die("無法建立資料連接: " . mysqli_connect_error());
	  
    mysqli_query($link, "SET NAMES utf8");
			   	
    return $link;
  }
  //執行mysqli	
  function execute_sql($link, $database, $sql)
  {
    mysqli_select_db($link, $database)
      or die("開啟資料庫失敗: " . mysqli_error($link));
						 
    $result = mysqli_query($link, $sql);
		
    return $result;
  }
 //頁碼
 function pagetag($page,$total_page,$showside){
     echo "<div><nav class='pagination is-centered'>";
     echo "<ul class='pagination-list'>";
     if($page>1) {
         $h = $page-1;
         echo "<li><a class='pagination-previous' onclick='page($h)'>上一頁</a></li>";
     }
     
                //當總數少於兩邊數量不印 ... 和最後一頁
     if($total_page<($showside*2)){
         for($i =1; $i<=$total_page;$i++){
             if($i==$page)
                 echo "<li><a class='pagination-link is-current'>$i</a></li>";
             else
                 echo "<li><a class='pagination-link' onclick='page($i)'>$i</a></li>";                      
         }
     }else{
         //當位置在最前段時只印右邊的....和最後一頁
         if($page<1+($showside*2)){
             for($i=1;$i<1+($showside*2);$i++){
                 if($i==$page){
                     echo "<li><a class='pagination-link is-current'>$i</a></li>";
                 }
                 else
                     echo "<li><a class='pagination-link' onclick='page($i)'>$i</a></li>";
             }
             echo "<li><span class='pagination-ellipsis'>&hellip;</span></li>";
             echo "<li><a class='pagination-link' onclick='page($total_page)'>$total_page</a></li>";                        
         }else if($total_page -($showside*2)>$page && $page >($showside*2)){
             //當位置在中間時
             echo "<li><a class='pagination-link' onclick='page(1)'>1</a></li>";
             echo "<li><span class='pagination-ellipsis'>&hellip;</span></li>";
                        
             for($i=$page-$showside;$i<=$page+$showside;$i++){
                 pageFirstellip($i,$page);
             }
             echo "<li><span class='pagination-ellipsis'>&hellip;</span></li>";
             echo "<li><a class='pagination-link' onclick='page($total_page)'>$total_page</a></li>";
         }else{
             //當位置於後段時
             echo "<li><a class='pagination-link' onclick='page(1)'>1</a></li>";
             echo "<li><span class='pagination-ellipsis'>&hellip;</span></li>";
             for($i = $total_page-(2+($showside*2));$i<=$total_page;$i++){
                 pageFirstellip($i,$page);
             }
         }
     }
     if($page<$total_page){
         $p = $page+1;
         echo "<li><a class='pagination-next' onclick='page($p)'>下一頁</a></li>";
     }
     echo "</ul>";
     echo "</nav>";
}

function pageFirstellip($i,$page){
    if($i==$page){
        echo "<li><a class='pagination-link is-current'>$i</a></li>";
    }else{
        echo "<li><a class='pagination-link' onclick='page($i)'>$i</a></li>";
    }
}


?>
