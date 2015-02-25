<?php
 
 $client_hash = $_GET["hash"];
 $data = file_get_contents('https://dl.dropboxusercontent.com/u/16258361/urnik/data.js');
 $server_hash = md5($data);

 if($client_hash == $server_hash){
 	printf("no_new_data");
 }else{
 	printf($data);
 }

