<?php

header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "app";
$password = "urnikZAvse";
$dbname = "app";

$date = $_GET["date"];
$type = $_GET["type"];



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mb_internal_encoding('UTF-8');
$sql = ";";

if($type=="malica"){
	$sql = "SELECT json FROM malica where date='".$date."';";
}else if($type=="kosilo"){
	$sql = "SELECT json FROM kosilo where date='".$date."';";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
$counter = 1;
    while($row = $result->fetch_assoc()) {
        if($result->num_rows == $counter){
		echo $row["json"];
	}
	$counter = $counter + 1;
    }
} else {
    echo "{}";
}
$conn->close();
?>