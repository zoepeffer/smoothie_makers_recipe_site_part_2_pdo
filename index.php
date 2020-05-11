<?php
require_once("inc/funktionen/zeichenketten_funktionen.inc.php");
require_once("inc/funktionen/datum_und_zeit_funktionen.inc.php");

require_once("inc/Seitensteuerung/Seitensteuerung.php");


if(!isset($_GET["action"]))
{
	$_GET["action"] = "von_uns";
}

$controller = new Seitensteuerung(); // Neuer Controller erstellen
echo $controller->selectPage($_GET["action"]); // Seite auswählen	

?>