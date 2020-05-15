<?php
$verzeichnis = "smoothierezepten";
$content = "";

// Prüfung ob Verzeichnis existiert
if( is_dir($verzeichnis) )
{
	// öffnen des Verzeichnisses
	if($geoeffnetes_verzeichnis = opendir($verzeichnis))
	{
				// einlesen vom Verzeichnis
		while( ($datei = readdir($geoeffnetes_verzeichnis)) !== false)
		{
			if($datei != "." && $datei != "..")
			{
				$content .= "<h1>".$datei."</h1>";
				
				// lesen einer Datei
				$rohdaten = file_get_contents("$verzeichnis/$datei");
				// umwandeln in den normalen Zustand vorher
				$formulardaten = unserialize($rohdaten);
				// Ausgabe der Formulardaten
				$content .= "<pre>";
				$content .= print_r($formulardaten, true); // rückgabewert erzeugen
				$content .= "</pre>";					
			}
		}
	}
}

echo $content;
?>