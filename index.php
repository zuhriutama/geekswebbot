<?php

/*
* This file is part of GeeksWeb Bot (GWB).
*
* GeeksWeb Bot (GWB) is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License version 3
* as published by the Free Software Foundation.
* 
* GeeksWeb Bot (GWB) is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.  <http://www.gnu.org/licenses/>
*
* Author(s):
*
* © 2015 Kasra Madadipouya <kasra@madadipouya.com>
*
*/
require 'functions/constants.php';
require 'functions/global.php';
require 'vendor/autoload.php';

$client = new Zelenin\Telegram\Bot\Api(API_KEY); // Set your access token
$update = json_decode(file_get_contents('php://input'));

//your app
try {
	switch($update->message->text){
		case "/sosmed":
			$text = "Ngga mau ketinggalan dengan berbagai info dan update dari YISC Al Azhar? Follow aja nih :\n";
			$text .= "Facebook : http://facebook.com/yisc.alazhar\n";
			$text .= "Twitter  : http://twitter.com/yisc_alazhar\n";
			$text .= "Google+  : https://plus.google.com/103786599270861299742\n";
			$text .= "Youtube  : https://www.youtube.com/channel/UCLGTGGY_KFCAtb11zhy6xHA";
			sendMessage($client, $update->message, $text);
		break;
		case "/salam":
			$randomAyah = getRandomAyah();
			$text = "Wa'alaikumussalaam Warahmatullahi Wabarakaatuh\n";
			$text .= "Inspirasi harian : $randomAyah\n";
			$text .= "Untuk mengetahui cara berinteraksi dengan Marbot YISC Al Azhar, silahkan ketik /help";
			sendMessage($client, $update->message, $text);
		break;
		case "/help":
			$text = "Daftar Perintah Marbot YISC Al Azhar\n";
			$text .= "/salam - Dapatkan informasi terbaru dari YISC Al Azhar\n";
			$text .= "/beye - Berita dan Artikel Terbaru dari website www.yisc-alazhar.or.id\n";
			$text .= "/inspirasi - Inspirasi dari ayat suci Al Qur'an khusus untuk kamu\n";
			$text .= "/sosmed - Daftar Sosial Media YISC Al Azhar\n";
			sendMessage($client, $update->message, $text);
		break;
		case "/beye":
			Feed::$cacheDir 	= __DIR__ . '/cache';
			Feed::$cacheExpire 	= '5 hours';
			$rss 		= Feed::loadRss(URL_FEED);
			$items 		= $rss->item;
			$lastitem 	= $items[0];
			$lastlink 	= $lastitem->link;
			$lasttitle 	= $lastitem->title;
			$text = $lasttitle . " \n ". $lastlink;
			sendMessage($client, $update->message, $text);
		break;
		case "/start":
			$text = "Assalaamu'alaikum Warahmatullahi Wabarakaatuh\n";
			$text = "Perkenalkan saya adalah Marbot YISC Al Azhar yang akan membantu kamu mendapatkan informasi terbaru seputar YISC Al Azhar.\n";
			$text = "Untuk memulai, silahkan ketik /salam";
			sendMessage($client, $update->message, $text);
		break;
		case "/inspirasi":
			$text = "Inspirasi Ayat Suci Al Qur'an\n";
			$text .= getRandomAyah();

			sendMessage($client, $update->message, $text);
		break;
		case "/waktushalat":
			$text = "'afwan, fitur ini belum tersedia";//getShalatTime();
			
			$inline_keyboard['InlineKeyboardMarkup'] = [
			'Test',
			'Test 2',
			'Test 3'
			];
			
			$response = $client->sendChatAction(['chat_id' => $update->message->chat->id, 'action' => 'typing']);
			$response = $client->sendMessage([
				'chat_id' => $update->message->chat->id,
				'text' => $text,
				'reply_markup' => array(
						'keyboard' => array(array('Hello', 'Hi')),
						'one_time_keyboard' => true,
						'resize_keyboard' => true)
			]);
		break;
		default:
			$text = "Hai... untuk daftar perintah, silahkan ketik /help";
			sendMessage($client, $update->message, $text);
		break;
	}
} catch (\Zelenin\Telegram\Bot\NotOkException $e) {

    //echo error message ot log it
    //echo $e->getMessage();

}