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


$tabelle_oben = file_get_contents("templates/smoothie_bearbeiten_tabelle_oben.html");


$tabelle_oben = suchen_und_ersetzen("__SUCHE_NAME__", @$_POST["suche_name"], $tabelle_oben);

$this->content .= $tabelle_oben;

$db = new Datenbank();

$rezepte = $db->sql_select("select * from rezepte LEFT JOIN rezension 
                            ON rezepte.rezension = rezension.rezension_id
                            
                            
                            WHERE 
							rezept_name LIKE '%".@$_POST["suche_name"]."%'
					order by rezept_id
                            
                            
                            ");
foreach($rezepte as $nr => $rezept)
{
    
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

        
$this->content .= file_get_contents("templates/smoothie_bearbeiten_tabelle_unten.html");
?>