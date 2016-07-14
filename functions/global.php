<?php

function getApi($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);
	
	return $result;
}

function sendMessage($client, $message, $text){
	$response = $client->sendChatAction(['chat_id' => $update->message->chat->id, 'action' => 'typing']);
	$response = $client->sendMessage([
		'chat_id' => $update->message->chat->id,
		'text' => $text
	]);
}

function getShalatTime(){
	$result = getApi('http://muslimsalat.com/jakarta.json?key='.MS_API_KEY);
	$shalat = json_decode($result);
	$waktu = $shalat['items'][0];
	
	$msg = "Waktu Shalat Jakarta dan Sekitarnya\n".date('j, d M Y')."\n";
	$msg .= "Shubuh  : ".$waktu['fajr']."\n";
	$msg .= "Terbit  : ".$waktu['shurooq']."\n";
	$msg .= "Zhuhur  : ".$waktu['dhuhr']."\n";
	$msg .= "Ashar   : ".$waktu['asr']."\n";
	$msg .= "Maghrib : ".$waktu['maghrib']."\n";
	$msg .= "Isya    : ".$waktu['isha'];
	
	return $msg;
}

function getRandomAyah(){
	$rand = rand(1,6236); // random ayah from 1:1 - 114:7
	
	$result = getApi('http://api.globalquran.com/ayah/'.$rand.'/id.indonesian?key='.GQ_API_KEY);
	
	$data = json_decode($result,true);
	$data = $data['quran']['id.indonesian'];
	$line = array();
	foreach($data as $id=>$val)
		$line = $val;
	return $line['verse']."\n[QS. ".$line['surah'].":".$line['ayah']."]";
}