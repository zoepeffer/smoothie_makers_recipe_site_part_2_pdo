<?php
namespace seitensteuerung;

use Klassen\PDO\Datenbank;  
#use Klassen\MYSQLI\Datenbank; 

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

$this->content = "<h1></h1>";

$db = new Datenbank();

$smoothie = $db->sql_select("select * from rezepte where rezept_id=".$_GET["rezept_id"]);

# print_r($smoothie);

$zeichenkette = file_get_contents("templates/smoothie_details.html");


$zeichenkette = suchen_und_ersetzen("__ZURUECK_LINK__", 
'<a href="index.php?action=smoothie_bearbeiten">Zurück</a>', $zeichenkette);

$zeichenkette = suchen_und_ersetzen(
		"__HEADLINE__", 
		
		$smoothie[0]["rezept_id"]." / ".
		"Datum: ".$smoothie[0]["rezeptdatum"]." / ".
		"Rezept ID: ".$smoothie[0]["rezept_id"],	
		
		$zeichenkette);
		
// ############################################################# 
// REZENSION	
// #############################################################
$rezensioninfo = $db->sql_select("select * from rezension where rezension_id=".$smoothie[0]["rezension"]);	
$front = $rezensioninfo[0]["front"]; // Das ist die Spalte mit 0 oder 1
		
if($front == 1)
{
	$zeichenkette = suchen_und_ersetzen("__REZENSION__", 
			"<div style='color:red'><h1>Smoothie ist in Frontseite Der Rezension kann nicht mehr geändert werden!</h1></div>"
			,	$zeichenkette);
}		
else
{
		// Rezension abfragen die nach dem aktuellen Rezension folgen
	$rezensionliste = $db->sql_select("select rezension_id, rezension_beschreibung, front from rezension
	where rezension_id > ".$smoothie[0]["rezension"]."
	order by rezension_id");
	
	$rezension_formular = file_get_contents("templates/rezension_formular.html");	
	
	$optionen = "";	
	foreach($rezensionliste as $rezensionzeile)
	{
		$optionen .= '<option value="'.$rezensionzeile["rezension_id"].';'.$rezensionzeile["rezension_beschreibung"].'">'
		.$rezensionzeile["rezension_beschreibung"].'</option>';
	}
	$rezension_formular = suchen_und_ersetzen("__OPTIONEN__", $optionen	,	$rezension_formular);
	$rezension_formular = suchen_und_ersetzen("__REZEPT_ID__", $smoothie[0]["rezept_id"]	,	$rezension_formular);	
	
	$zeichenkette = suchen_und_ersetzen("__REZENSION__", $rezension_formular	,	$zeichenkette);	
	
}
$bearbeitung_formular = file_get_contents("templates/smoothie_bearbeitung_formular.html");	


$bearbeitung_formular = suchen_und_ersetzen("__REZEPT_NAME__", $smoothie[0]["rezept_name"] ,	$bearbeitung_formular);
$bearbeitung_formular = suchen_und_ersetzen("__ZUTATEN_LIST__", $smoothie[0]["zutaten_list"] ,	$bearbeitung_formular);	
$bearbeitung_formular =	suchen_und_ersetzen("__REZEPT_ID__", $smoothie[0]["rezept_id"]	,	$bearbeitung_formular);

$zeichenkette = suchen_und_ersetzen("__DETAILS__", $bearbeitung_formular ,	$zeichenkette);	
																	
$this->content .= $zeichenkette;
?>