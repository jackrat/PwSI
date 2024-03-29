<?php

$tmpfile = "gas.csv";
$handle = fopen($tmpfile, "r");                  
$contents = fread($handle, filesize($tmpfile));  
fclose($handle);
$decodeContent   = base64_encode($contents);     
    



$url = "http://localhost:56282/E4WebService.asmx?WSDL";
$client = new SoapClient($url, array("trace" => 1, "exception" => 0));

//$header = new SoapHeader("http://numeron.pl/TestPostFile", null, false);
$header = new SoapHeader('NAMESPACE','Auth', null, false);
$client->__setSoapHeaders($header);
$result = $client->__soapCall("TestPostFile", array($decodeContent, "gas.csv"));
// $result = $client->__soapCall("TestPostFile", array(
//     "DeleteMarketplaceAd" => array(
//         "accountID"        => "$12121212",
//         "marketplaceAdID"    => "9938745"        
//     )
// ), NULL, $header);



echo("OK");
//echo($result);

?>