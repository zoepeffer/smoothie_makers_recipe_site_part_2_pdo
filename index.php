<?php
session_start();
require_once("inc/funktionen/zeichenketten_funktionen.inc.php");
require_once("inc/funktionen/datum_und_zeit_funktionen.inc.php");

#require_once("inc/klassen/MYSQLI/Datenbank.php");
#require_once("inc/klassen/PDO/Datenbank.php");
#require_once("inc/Seitensteuerung/Seitensteuerung.php");

function autoLoad($name)
{
	$pfad = "inc/".$name.".php";
	$pfad = "inc" . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, $name) . ".php";
	#echo "<h1>$name => $pfad</h1>";
    if(file_exists($pfad))
    {
		require_once($pfad);
    }	 
}

spl_autoload_register("autoLoad"); // Automatisches Laden aktivieren

if(!isset($_GET["action"]))
{
	$_GET["action"] = "von_uns";
}

$controller = new seitensteuerung\Seitensteuerung(); // Neuer Controller erstellen
echo $controller->selectPage($_GET["action"]); // Seite auswählen	
?>