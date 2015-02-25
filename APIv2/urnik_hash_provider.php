<?php

 $data = file_get_contents('https://dl.dropboxusercontent.com/u/16258361/urnik/data.js');
 $server_hash = md5($data);

 printf($server_hash);

