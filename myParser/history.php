<?php

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Europe/Moscow');

if($_GET){
	echo file_get_contents("hist.txt");
}
else if($_POST){
	$my_req = "IP: ".$_SERVER['REMOTE_ADDR']
	.", time: ".date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']+60*60)
	.", expression: ".$_POST[message]."<br>".PHP_EOL;
	$f = fopen("hist.txt","a");
	fwrite($f,$my_req);
	fclose($f);

	$replace_newline = str_replace(";", PHP_EOL, $_POST[tex]);

	$g = fopen("tex.txt","a");
	$new_note =
	"\tDate: ".date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']+60*60)."\\\\*".PHP_EOL
	."\tIP: ".$_SERVER['REMOTE_ADDR']."\\\\*".PHP_EOL
	."\tExpression: ".$_POST[message]."\\\\*".PHP_EOL
	.$replace_newline."\\par".PHP_EOL
	."\t\\vspace{10 mm}".PHP_EOL;
	fwrite($g, $new_note);
	fclose($g);

	$tex_final = fopen("tex_download.tex","w");
	fwrite($tex_final , file_get_contents("tex_begin.txt"));
	fwrite($tex_final , str_replace("^", "{\$^\\wedge\$}", file_get_contents("tex.txt")));
	fwrite($tex_final , file_get_contents("tex_end.txt"));
	fclose($tex_final);
}
?>