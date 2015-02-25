<?php
date_default_timezone_set('Europe/Ljubljana');
// naslov strežnika
$server_name = 'solsis.gimvic.org';
// API ključ
$apikey = 'ede5e730-8464-11e3-baa7-0800200c9a66';

// URL
$url = 'https://' . $server_name.'/?';

// datum na katerega želite izvedeti suplence
//$date = date('Y-m-d'); // date in format Y-m-d -> 2014-01-23
//$date = '2014-01-23';
$date = $_GET['datum'];

// nek string, ki nima nobenega smisla, pomemeben zato, da ni mogoče ponoviti
// istih zahtevkov še enkrat, torej na vsak request mora bit nonsense durgačen
$nonsense = uniqid("suplence_mobile_", true);

// parametri, ki jih je potrebno podpisati
$params = 'func=gateway&call=suplence&datum='.$date.'&nonsense='.$nonsense;

// string za podpis je sestavljen iz imena strežnika + parametrov + apikey
$signature_string = $server_name . '||' . $params . '||' . $apikey;

// naredimo podpis
$signature = hash('sha256', $signature_string);

// pripnemo podpis v URL
$url .= $params.'&signature='.$signature;

// naredimo dejanski zahtevek na strežnik
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
curl_close($curl);
 
  
  echo $json;
?>
