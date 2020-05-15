<?php
use Klassen\PDO\Datenbank;  // benutze diesen Namespace für Datenbank
# use Klassen\MYSQLI\Datenbank; // benutze diesen Namespace für Datenbank

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

// Teiltemplate
$this->content .= file_get_contents("templates/smoothie_bearbeiten_tabelle_oben.html");
		
$db = new Datenbank();

$rezepte = $db->sql_select("select * from rezepte LEFT JOIN rezension 
                            ON rezepte.rezension = rezension.rezension_id");
foreach($rezepte as $nr => $rezept)
{
    // Teiltemplate
    $zeichenkette =  file_get_contents("templates/smoothie_bearbeiten_tabelle_mitte.html");
    
    $austausch_array = array(	"__REZEPTENAME__" 			=> $rezept["rezept_name"],
                                "__REZEPTID__" 				=> $rezept["rezept_id"],
                                "__ZUTATENLIST__" 			=> $rezept["zutaten_list"],
                                "__REZEPT_BESCHREIBEN__" 	=> $rezept["rezept_beschreibung"],
                                "__BILD__" 					=> $rezept["rezeptbild"]
                            );		

    foreach($austausch_array as $platzhalter => $austauschwert)
    {		
        $zeichenkette  = suchen_und_ersetzen($platzhalter, $austauschwert,	$zeichenkette);
    }		
    $this->content .= $zeichenkette;	
}

        // Teiltemplate
$this->content .= file_get_contents("templates/smoothie_bearbeiten_tabelle_unten.html");
?>