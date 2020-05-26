<?php
namespace seitensteuerung;

use Klassen\PDO\Datenbank;  // benutze diesen Namespace für Datenbank
#use Klassen\MYSQLI\Datenbank; // benutze diesen Namespace für Datenbank

// benutzte den Namensraum nur für die spezielle Klasse
use Klassen\Bearbeitung;
use Klassen\Farbe;
use Klassen\Geschmack;
use Klassen\Rezension;
use Klassen\Rezept;
use Klassen\Selection;
use Klassen\User;
use Klassen\Zutat;

use Klassen\Datei;
use Klassen\Dateimanager;

$this->content = "<h1>Löschen bestätigen</h1>";

$db = new Datenbank();

$smoothie = $db->sql_select("select * from rezepte where rezept_id=".$_GET["rezept_id"]);

$zeichenkette = file_get_contents("templates/smoothie_details.html");

// Austauschen

$zeichenkette = suchen_und_ersetzen("__ZURUECK_LINK__", 
'<a href="index.php?action=smoothie_bearbeiten">Zurück</a>', $zeichenkette);

									// Suchstelle     	Ersatzinhalt		html-Grundgerüst
$zeichenkette = suchen_und_ersetzen("__HEADLINE__", 
		$smoothie[0]["rezept_id"]." / ".
		"User: ".$smoothie[0]["user_id"]." / ".
		"Rezept Name: ".$smoothie[0]["rezept_name"]
		,	$zeichenkette);
		
// ############################################################# 
// REZENSION	
// #############################################################
	
$rezensioninfo = $db->sql_select("select * from rezension where rezension_id=".$smoothie[0]["rezension"]);	

$zeichenkette = suchen_und_ersetzen("__REZENSION__", 
		"<div style='color:red'>".$rezensioninfo[0]["rezension_beschreibung"]."</div>"
		,	$zeichenkette);		

// ############################################################# 
// Details	
// #############################################################
$details = "";

$details .= "Rezept Name:".$smoothie[0]["rezept_name"]."<br />";
$details .= "Zutaten List:".$smoothie[0]["zutaten_list"]."<br />";


$details .= "Rezept Beschreiben:".$smoothie[0]["rezept_beschreibung"]."<br />";
$details .= "Bilddatei:".$smoothie[0]["rezeptbild"]."<br />";	

$zeichenkette = suchen_und_ersetzen("__DETAILS__", $details ,	$zeichenkette);		


$this->content .= $zeichenkette;

$this->content .= "<h1>Wollen Sie wirklich löschen?</h1>";

$this->content .= "<form action='?action=smoothie_bearbeiten' method='post'>
					<input type='submit' name='loeschen' value='Bestätigen'>
					<input type='hidden' name='rezept_id' value='".$smoothie[0]["rezept_id"]."' />
					</form>";	

?>