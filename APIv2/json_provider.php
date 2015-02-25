<?php
/**
 * Created by PhpStorm.
 * User: ziga
 * Date: 10/9/14
 * Time: 8:26 PM
 */


/**
 * When calling this php u have to specify date ("datum") and datetime telling how old is your data("last_update")
 */


date_default_timezone_set('Europe/Ljubljana');
// naslov strežnika
$server_name = 'solsis.gimvic.org';
// API ključ
$apikey = 'ede5e730-8464-11e3-baa7-0800200c9a66';

// URL
$url = 'https://' . $server_name . '/?';

// datum na katerega želite izvedeti suplence
//$date = date('Y-m-d'); // date in format Y-m-d -> 2014-01-23
//$date = '2014-01-23';
$date = $_GET['datum'];

// nek string, ki nima nobenega smisla, pomemeben zato, da ni mogoče ponoviti
// istih zahtevkov še enkrat, torej na vsak request mora bit nonsense durgačen
$nonsense = uniqid("suplence_mobile_", true);

// parametri, ki jih je potrebno podpisati
$params = 'func=gateway&call=suplence&datum=' . $date . '&nonsense=' . $nonsense;

// string za podpis je sestavljen iz imena strežnika + parametrov + apikey
$signature_string = $server_name . '||' . $params . '||' . $apikey;

// naredimo podpis
$signature = hash('sha256', $signature_string);

// pripnemo podpis v URL
$url .= $params . '&signature=' . $signature;

// naredimo dejanski zahtevek na strežnik
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
curl_close($curl);


//check if date already exists in database


// Create connection
$con = mysqli_connect("localhost", "app", "urnikZAvse", "app");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT * FROM suplence_json WHERE date='$date';");


$i=0;
while ($row = mysqli_fetch_array($result)) {
    $i++;
}
//close connection
mysqli_close($con);


$last_update = strtotime($_GET["last_update"]);


if ($i == 1) {
    //normal behaviour



    //check if sql contains last data and write it to sql if needed
    // Create connection
    $con = mysqli_connect("localhost", "app", "urnikZAvse", "app");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con, "SELECT * FROM suplence_json WHERE json='$json';");


    $j=0;
    while ($row = mysqli_fetch_array($result)) {
        $j++;
    }
    //close connection
    mysqli_close($con);


    if($j==0){
        // Create connection
        $con = mysqli_connect("localhost", "app", "urnikZAvse", "app");

        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        mysqli_query($con, "UPDATE supence_json SET json='$json' WHERE date='$date;'");

        //close connection
        mysqli_close($con);
    }


    // Create connection
    $con = mysqli_connect("localhost", "app", "urnikZAvse", "app");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con, "SELECT * FROM suplence_json WHERE date='$date';");


    while ($row = mysqli_fetch_array($result)) {

        $timestamp=strtotime($row["timestamp"]);

    }


    //close connection
    mysqli_close($con);

    if ($last_update >= $timestamp) {
        echo "no_new_data";
    }else{
        echo($json);

        // Create connection
        $con = mysqli_connect("localhost", "app", "urnikZAvse", "app");

        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        mysqli_query($con, "UPDATE supence_json SET json='$json' WHERE date='$date;'");

        //close connection
        mysqli_close($con);

    }


} elseif ($i == 0) {
    //create new day

    echo($json);

    // Create connection
    $con = mysqli_connect("localhost", "app", "urnikZAvse", "app");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysqli_query($con, "INSERT INTO suplence_json (json, date) VALUES ('$json', '$date');");

    //close connection
    mysqli_close($con);


}else{
    echo("error");
}