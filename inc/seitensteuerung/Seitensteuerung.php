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

class Seitensteuerung
{
	// Attribute
	public $action 		= "";								// Seitenauswahl
	public $formData 	= array();							// Formulardaten
	public $template 	= "templates/grundgeruest.html";	// HTML-Seite
	public $content 	= "Inhalt ist noch leer"; 			// Seiteninhalt der Unterseite
	
	public function selectPage($page)
	{
		$this->action = $page;
		
		switch($this->action)
		{
			case "von_uns":				$this->actionVon_uns();				break;
			case "shake_suchen":		$this->actionShake_suchen();    	break;
			case "shake_schreiben":		$this->actionShake_schreiben();		break;
			case "shake_bearbeiten":	$this->actionShake_bearbeiten();	break;
			case "kontakt":				$this->actionKontakt();				break;
			case "impressum":			$this->actionImpressum();			break;
			case "agb":					$this->actionAGB();					break;
			case "download":			$this->actionDownload();			break;
			case "veraltet":			$this->actionVeraltet();			break;
			default:					$this->actionSeiteNichtGefunden();
		}
		// Template Vorlage holen
		$zeichenkette = file_get_contents($this->template);
		//echo $zeichenkette;
		$ersatztext = suchen_und_ersetzen("__#__CONTENT__#__", $this->content,	$zeichenkette);
		return $ersatztext;
	}
	
	protected function actionVon_uns()
	{
		#$this->content = "<h1>Von uns</h1>";
		$this->content = file_get_contents("templates/von_uns.html");

		#$db = new \klassen\PDO\Datenbank();
		$db = new Datenbank();
		$rezept = new Rezept();
	}
	protected function actionShake_suchen()
	{
		$this->content = "<h1>Shake suchen</h1>";
	}
	protected function actionShake_schreiben()
	{
		$this->content = "<h1>Shake schreiben</h1>";
		$this->formData = $_POST;
		// Speichern der Daten in einer TXT-Datei
		// Wenn das Formular verschickt wurde
		if(isset($this->formData["shake_schreiben"]))
		{
			// Post Array umwandeln in eine serialisierte Version einer Zeichenkette
			$speicherbare_zeichenkette = serialize($this->formData);
			// Dateiname generieren
			$dateiname = uniqid("shakerezepte_"); // paketsendung_5b28d75206bec
			// Die Zeichenkette in die Datei schreiben
			file_put_contents("shakerezepten/$dateiname.txt", $speicherbare_zeichenkette);
			$this->content .= "Daten wurden gespeichert";

			$db = new Datenbank(); 				#  BEI use Klassen\PDO\Datenbank;
			# $db = new \Klassen\PDO\Datenbank(); #	ohne use
			
			$dominierte_zutat_typ = $db->sql_select("select * from zutat where zutat_id =".$this->formData["zutat_typ"]);		
			
			$datei = new Datei($_FILES["uploaddatei"]);
			$dateimanager = new Dateimanager();
			
			$db->sql_insert
				("insert into rezepte 
					(rezension, rezept_name, zutaten_list, preisstufe, rezeptbild)
				values
					(
					:platzhalter_rezension, 
					:platzhalter_rezept_name, 
					:platzhalter_zutaten_list, 
					:platzhalter_zutat_typ,
					:platzhalter_rezeptbild
					)",
					array
					(
						"platzhalter_rezension" => 1,						// DEFAULT
						"platzhalter_rezept_name" => $this->formData["rezept_name"],
						"platzhalter_zutaten_list" => $this->formData["zutaten_list"],
						"platzhalter_zutat_typ" => $this->formData["zutat_typ"],
						"platzhalter_rezeptbild" => $dateimanager->datei_hochladen($datei->getDateiinfo())
					)
				);			
		}
		else
		{
			// Teiltemplate
			$this->content .= file_get_contents("templates/shake_schreiben_formular.html");
		}
	}
	protected function actionShake_bearbeiten()
	{
		$this->content = "<h1>Shake bearbeiten</h1>";
		
				// Teiltemplate
		$this->content .= file_get_contents("templates/shake_bearbeiten_tabelle_oben.html");
		
		$db = new Datenbank();
		
		$rezepte = $db->sql_select("select * from rezepte LEFT JOIN rezension 
									ON rezepte.rezension = rezension.rezension_id");
		foreach($rezepte as $nr => $rezept)
		{
			// Teiltemplate
			$zeichenkette =  file_get_contents("templates/shake_bearbeiten_tabelle_mitte.html");
			
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
		$this->content .= file_get_contents("templates/shake_bearbeiten_tabelle_unten.html");
	}
	
	protected function actionKontakt()
	{
		$this->content = "<h1>Kontakt</h1>";
	}

	protected function actionImpressum()
	{
		$this->content = "<h1>Impressum</h1>";
	}

	protected function actionAGB()
	{
		$this->content = "<h1>AGB</h1>";
	}	

	protected function actionDownload()
	{
		$this->content = "<h1>Download</h1>";
		header("Location: downloads/download.php"); // Weiterleitung
	}	

	protected function actionVeraltet()
	{
		$this->content = "<h1>Veraltet</h1>";
		header("Expires: Tue, 24 Apr 2018 11:06:00 GMT");
	}	

	protected function actionSeiteNichtGefunden()
	{
		$this->content = "<h1>Seite nicht gefunden</h1>";
		header("HTTP/1.1 404 Not Found"); // Fehlerseite
	}		
}
?>