<?php
// lesen einer Datei
$rohdaten = file_get_contents("smoothierezepten/paketsendung_5eb10bf339777.txt");
echo $rohdaten;

// umwandeln in den normalen Zustand vorher
$formulardaten = unserialize($rohdaten);
echo "<pre>";
print_r($formulardaten);
echo "</pre>";
?>