<?php

header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "app";
$password = "urnikZAvse";
$dbname = "app";

$date = $_GET["date"];
$malica = $_GET["malica"];



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mb_internal_encoding('UTF-8');
$sql = "";

if($malica){
	$sql = "SELECT json FROM malica where date='".$date."';";
}else {
	$sql = "SELECT json FROM kosilo where date='".$date."';";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["json"];
    }
} else {
    echo "{}";
}
$conn->close();
?>