<?php

$csv = $_POST["data"];
$date = date("Y-m-d-H-i-s", time());

$fileName = $date . ".csv";

$file = fopen($fileName, "w");
fwrite($file, $csv);
fclose($file);

shell_exec("./parser " . $fileName);

?>
