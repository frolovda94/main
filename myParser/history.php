<?php

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Europe/Moscow');

if($_GET){
	echo file_get_contents("hist.txt");
}
else if($_POST){
	$my_req = "IP: ".$_SERVER['REMOTE_ADDR']
	.", time: ".date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
	.", expression: ".$_POST[message]."<br>"
	.PHP_EOL;
	$f = fopen("hist.txt","a");
	fwrite($f,$my_req);
	fclose($f);
}
?>