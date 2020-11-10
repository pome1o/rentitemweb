<?php
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,"https://portal.oit.edu.tw/index.php?sid=CosQuery&mode=Query");
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query( array( "room_id"=>"30802","cos_smtr"=>"1062","building_id"=>"3","room_floor"=>"08","room_id"=>"30802","display_mode"=>"T") ));
$temp = curl_exec($curl);
echo $temp;
echo 1; 
curl_close($curl);
?>