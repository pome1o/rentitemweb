<?php 
header("Content-Type:text/html; charset=utf-8");
$file = "../uploads/1.csv";
echo $file;
$fi = fopen($file,"r") or die("報了");
$data = fgetcsv($fi);
print_r($data);
fclose($fi);

?>