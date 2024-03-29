<?php

if (isset($_POST["filecode"])) {    
    $imageData = $_POST["filecode"];
    $filteredData = substr($imageData, strpos($imageData, ",") + 1);
    $unencodedData = base64_decode($filteredData);
    $fp = fopen("file_png.png", "wb");
    fwrite($fp, $unencodedData);
    fclose($fp);
  }

?>