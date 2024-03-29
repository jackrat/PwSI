<?php
header("Content-Length: 99999");
header("Content-Type: text/csv");
//header("HTTP/1.0 404 Not Found");
//header("Location: http://www.example.com/");
date_default_timezone_set("Europe/Warsaw");
$daneWE = "";
if (isset($_GET["a"]) && isset($_GET["b"]))
   $daneWE = "<br />a: " . $_GET["a"] . "<br />b: " . $_GET["b"];
else
   $daneWE = "Nie przesłano danych WEJŚCIOWYCH!";
echo (date("H:i:s")."<hr/>" );
echo ($daneWE);
for($i=0;$i<1000;$i++)
  echo ($i.") response response response response response response <br/>");

