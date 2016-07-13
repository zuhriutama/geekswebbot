<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'http://api.globalquran.com/ayah/1:1/id.indonesian?key=d1bdfe6421908ff4cfb71fd1e7630e0b');
$result = curl_exec($ch);
curl_close($ch);
$data = json_decode($result,true);
var_dump($data);
echo "<br/>ayat quran : ";
?>